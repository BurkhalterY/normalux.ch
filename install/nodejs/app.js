const Fs = require('fs');
const Https = require('https');
const WebSocket = require('ws');

const rooms = { };

const server = Https.createServer({
	key: Fs.readFileSync('key.pem'),
	cert: Fs.readFileSync('cert.pem')
});

const wss = new WebSocket.Server({ server });

wss.on('connection', function connection(ws) {

	console.log('connected');

	ws.on('message', function incoming(msg) {
		
		let datas = JSON.parse(msg);
		let obj, obj2, clients;
		switch (datas.type) {
			case 'join':
				if(!datas.hasOwnProperty('pseudo') || !datas.hasOwnProperty('pseudo')){
					return;
				}
				console.log(datas.pseudo+" joins room "+datas.room_code);

				ws.uuid = datas.pseudo+"_"+Math.floor(Math.random() * 10000);
				ws.pseudo = datas.pseudo;
				ws.room_code = datas.room_code;
				ws.score = 0;

				if(!rooms.hasOwnProperty(ws.room_code)){
					rooms[ws.room_code] = {
						clients: { },
						positions: [],
						state: 'waiting'
					};
					ws.admin = true;
					obj2 = { type: 'admin' };
					ws.send(JSON.stringify(obj2));
				}
				if(rooms[ws.room_code].state == 'waiting') {
					rooms[ws.room_code].clients[ws.uuid] = ws;

					obj = {
						type: 'join',
						uuid: ws.uuid,
						pseudo: ws.pseudo
					}

					clients = rooms[ws.room_code].clients;
					for (let uuid in clients) {
						clients[uuid].send(JSON.stringify(obj));

						obj2 = {
							type: 'join',
							uuid: uuid,
							pseudo: clients[uuid].pseudo
						}
						ws.send(JSON.stringify(obj2));
					}
				}
				break;
			case 'start':
				if(ws.hasOwnProperty('admin')){

					clients = rooms[ws.room_code].clients;
					for (let uuid in clients) {
						clients[uuid].isImpostor = false;
						clients[uuid].votesImpostor = clients[uuid].votesBest = 0;
						clients[uuid].impostorVote = clients[uuid].bestVote = '';
						clients[uuid].detailsPoints = [];
					}

					rooms[ws.room_code].state = 'in-game';

					//Https.get('http://localhost/normalux.ch/multi/random', function(res){
					Https.get('https://normalux.ch/multi/random', function(res){
						let body = '';

						res.on('data', function(chunk){
							body += chunk;
						});

						res.on('end', function(){
							let picture = JSON.parse(body);

							clients = rooms[ws.room_code].clients;
							let keys = Object.keys(clients);
							let impostorUUID = keys[Math.floor(Math.random() * keys.length)];
							clients[impostorUUID].isImpostor = true;

							for (let uuid in clients) {
								obj = {
									'type': 'start',
									'picture': picture,
									'initialTime': Date.now(),
									'impostor': clients[uuid].isImpostor
								}
								clients[uuid].send(JSON.stringify(obj));
							}
						});
					});
				}
				break;
			case 'position':
				if(!datas.hasOwnProperty('position')){
					return;
				}
				datas.position.playerId = ws.uuid;
				rooms[ws.room_code].positions.push(datas.position);

				obj = {
					type: 'position',
					position: datas.position,
				};

				clients = rooms[ws.room_code].clients;
				for (let uuid in clients) {
					if(clients[uuid].isImpostor){
						clients[uuid].send(JSON.stringify(obj));
					}
				}
				break;
			case 'post':
				if(!datas.hasOwnProperty('image') || !datas.hasOwnProperty('json')){
					return;
				}

				let file = ws.room_code+'_'+ws.uuid+'_'+Math.floor(Math.random() * 10000);
				Fs.writeFile('archives/'+file+'.png', datas.image.split(';base64,').pop(), {encoding: 'base64'}, function(err) { });
				Fs.writeFile('archives/'+file+'.json', JSON.stringify(datas.json), {encoding: 'utf8'}, function(err) { });

				obj = {
					type: 'post',
					image: datas.image,
					from: ws.uuid
				};
				clients = rooms[ws.room_code].clients;
				for (let uuid in clients) {
					clients[uuid].send(JSON.stringify(obj));
				}
				break;
			case 'vote':
				if(!datas.hasOwnProperty('cat') || !datas.hasOwnProperty('player')){
					return;
				}
				if(ws.impostorVote == '' && datas.cat == 'impostor'){
					rooms[ws.room_code].clients[datas.player].votesImpostor++;
					ws.impostorVote = datas.player;
				} else if(ws.bestVote == '' && datas.cat == 'best') {
					rooms[ws.room_code].clients[datas.player].votesBest++;
					ws.bestVote = datas.player;
				}

				let votesImpostor = { };
				let votesBest = { };
				let everyoneHasVoted = true;

				clients = rooms[ws.room_code].clients;
				for (let uuid in clients) {
					votesImpostor[uuid] = clients[uuid].votesImpostor;
					votesBest[uuid] = clients[uuid].votesBest;

					if(clients[uuid].impostorVote == '' || clients[uuid].bestVote == ''){
						everyoneHasVoted = false;
					}
				}
				if(everyoneHasVoted){

					let maxImpostor = Math.max.apply(Math, Object.keys(votesImpostor).map(function(o) { return votesImpostor[o]; }));
					let maxBest = Math.max.apply(Math, Object.keys(votesBest).map(function(o) { return votesBest[o]; }));

					let scores = { };

					for (let uuid in clients) {
						let combo = 0;
						if(clients[uuid].votesBest == maxBest){
							clients[uuid].detailsPoints.push({ msg: 'Meilleur dessin', points: 500 });
							combo++;
						}
						if(clients[uuid].isImpostor && clients[uuid].votesImpostor != maxImpostor){
							clients[uuid].detailsPoints.push({ msg: 'Passé inaperçu', points: 1000 });
							combo++;
						}
						if(clients[clients[uuid].impostorVote].isImpostor){
							clients[uuid].detailsPoints.push({ msg: 'C\'était bien lui', points: 200 });
						}
						if(combo == 2){
							clients[uuid].detailsPoints.push({ msg: 'Contrefaçon', points: 500 });
						}

						for (let i = 0; i < clients[uuid].detailsPoints.length; i++) {
							clients[uuid].score += clients[uuid].detailsPoints[i].points;
						}
						scores[uuid] = clients[uuid].score;
					}
					for (let uuid in clients) {

						obj = {
							type: "results",
							votesImpostor: votesImpostor,
							votesBest: votesBest,
							yourPoints: clients[uuid].detailsPoints,
							scores: scores
						};
						clients[uuid].send(JSON.stringify(obj));
					}
				}
				break;
		}
	});

	ws.on('close', function close() {
		console.log('disconnected');

		let obj = {
			type: 'leave',
			uuid: ws.uuid
		};

		if(rooms.hasOwnProperty(ws.room_code)){
			let clients = rooms[ws.room_code].clients;
			for (let uuid in clients) {
				if(ws.uuid != uuid){
					clients[uuid].send(JSON.stringify(obj));
					
					if(ws.hasOwnProperty('admin')){
						clients[uuid].admin = true;
						let obj2 = { type: 'admin' };
						clients[uuid].send(JSON.stringify(obj2));
						delete ws.admin;
					}
				}
			}
			delete clients[ws.uuid];
			if(Object.keys(clients).length === 0){
				delete rooms[ws.room_code];
			}
		}
	});
});

server.listen(8080);