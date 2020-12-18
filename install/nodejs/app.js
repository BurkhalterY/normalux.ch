const fs = require('fs');

const http = require('http');
const https = require('https');
const server = fs.existsSync('key.pem') ?
	https.createServer({
		key: fs.readFileSync('key.pem'),
		cert: fs.readFileSync('cert.pem')
	}) : http.createServer();

const WebSocket = require('ws');


const rooms = { };
const wss = new WebSocket.Server({ server });
const specialsRules = [
	{
		name: 'Black & white',
		title: 'Noir & blanc',
		description: ''
	}, {
		name: 'Rotation',
		title: 'Rotation',
		description: ''
	}
];

function uuidv4() {
	return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
		let r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
		return v.toString(16);
	});
}

wss.on('connection', function connection(ws) {

	ws.on('message', function incoming(msg) {
		
		let datas;
		try {
			datas = JSON.parse(msg);
		} catch (e) {
			return;
		}
		if(!datas.hasOwnProperty('type')){
			return;
		}
		switch (datas.type) {
			case 'join':
				if(!datas.hasOwnProperty('pseudo') || !datas.hasOwnProperty('room_code')) return;
				join(datas.pseudo, datas.room_code);
				break;
			case 'start':
				if(!datas.hasOwnProperty('victoryCondition')
				|| !datas.hasOwnProperty('roundsNumber')
				|| !datas.hasOwnProperty('scoreGoal')
				|| !datas.hasOwnProperty('time')
				|| !datas.hasOwnProperty('impostors')
				|| !datas.hasOwnProperty('wordMode')
				|| !datas.hasOwnProperty('themes')
				|| !datas.hasOwnProperty('rulesByRounds'))
					return;
				start(datas.victoryCondition, datas.roundsNumber, datas.scoreGoal, datas.time, datas.impostors, datas.wordMode, datas.themes, datas.rulesByRounds);
				// absence de break volontaire
			case 'restart':
				restart();
				break;
			case 'position':
				if(!datas.hasOwnProperty('position')) return;
				position(datas.position);
				break;
			case 'post':
				if(!datas.hasOwnProperty('image') || !datas.hasOwnProperty('json')) return;
				post(datas.image, datas.json);
				break;
			case 'vote':
				if(!datas.hasOwnProperty('cat') || !datas.hasOwnProperty('player')) return;
				vote(datas.cat, datas.player);
				break;
			case 'kick':
				if(!datas.hasOwnProperty('uuid')) return;
				kick(datas.uuid);
				break;
		}
	});

	function join(pseudo, room_code) {

		ws.uuid = uuidv4();
		ws.pseudo = pseudo;
		ws.room_code = room_code;
		ws.score = 0;

		let obj = {
			type: 'welcome',
			uuid: ws.uuid
		};
		ws.send(JSON.stringify(obj));

		if(!rooms.hasOwnProperty(ws.room_code)){
			rooms[ws.room_code] = {
				clients: { },
				clientsWaitlist: { },
				round: 0,
				rules: { victoryCondition: 'rounds', roundsNumber: 5, scoreGoal: 10000, time: 45, impostors: 1, wordMode: false, themes: [], rulesByRounds: 4 },
				picture: { url: '', title: '' },
				word: '',
				state: 'waiting'
			};
			ws.admin = true;
			obj = { type: 'admin' };
			ws.send(JSON.stringify(obj));
		}
		if(rooms[ws.room_code].state == 'waiting') {
			rooms[ws.room_code].clients[ws.uuid] = ws;

			obj = {
				type: 'join',
				uuid: ws.uuid,
				pseudo: ws.pseudo
			}

			let clients = rooms[ws.room_code].clients;
			for (let uuid in clients) {
				clients[uuid].send(JSON.stringify(obj));

				let obj2 = {
					type: 'join',
					uuid: uuid,
					pseudo: clients[uuid].pseudo
				}
				ws.send(JSON.stringify(obj2));
			}
		} else {
			rooms[ws.room_code].clientsWaitlist[ws.uuid] = ws;
			obj = { type: 'wait' };
			ws.send(JSON.stringify(obj));
		}

		console.log(pseudo+" joins room "+room_code+" ["+Object.keys(rooms[ws.room_code].clients).length+"]");
	}

	function start(victoryCondition, roundsNumber, scoreGoal, time, impostors, wordMode, themes, rulesByRounds) {
		if(ws.hasOwnProperty('admin')){

			if(victoryCondition != 'rounds' && victoryCondition != 'score') return;
			if(isNaN(roundsNumber) || isNaN(scoreGoal) || isNaN(time) || isNaN(impostors) || isNaN(rulesByRounds)) return;
			if(roundsNumber <= 0 || scoreGoal <= 0 || time <= 0 || impostors <= 0 || rulesByRounds < 0) return;
			if(typeof wordMode !== "boolean" || !Array.isArray(themes)) return;

			rooms[ws.room_code].rules.victoryCondition = victoryCondition;
			rooms[ws.room_code].rules.roundsNumber = roundsNumber;
			rooms[ws.room_code].rules.scoreGoal = scoreGoal;
			rooms[ws.room_code].rules.time = time;
			rooms[ws.room_code].rules.impostors = impostors;
			rooms[ws.room_code].rules.wordMode = wordMode;
			rooms[ws.room_code].rules.themes = themes;
			rooms[ws.room_code].rules.rulesByRounds = rulesByRounds;

			rooms[ws.room_code].round = 0;

			let clients = rooms[ws.room_code].clients;
			for (let uuid in clients) {
				clients[uuid].score = 0;
			}
		}
	}

	function restart() {
		if(ws.hasOwnProperty('admin')){

			function sendToPlayers() {
				let clients = rooms[ws.room_code].clients;
				let keys = Object.keys(clients);
				for (let i = 0; i < rooms[ws.room_code].rules.impostors; i++) {
					let impostorUUID = keys[Math.floor(Math.random() * keys.length)];
					while(clients[impostorUUID].isImpostor){
						impostorUUID = keys[Math.floor(Math.random() * keys.length)];
					}
					clients[impostorUUID].isImpostor = true;
				}

				let rule = rooms[ws.room_code].round % rooms[ws.room_code].rules.rulesByRounds == 0 ? specialsRules[Math.floor(Math.random() * specialsRules.length)] : null;

				for (let uuid in clients) {
					let obj = {
						'type': 'start',
						'time': rooms[ws.room_code].rules.time,
						'initialTime': Date.now(),
						'impostor': clients[uuid].isImpostor,
						'specialRule': rule
					}
					if(rooms[ws.room_code].rules.wordMode){
						obj.word = rooms[ws.room_code].word;
					} else {
						obj.picture = rooms[ws.room_code].picture;
					}
					clients[uuid].send(JSON.stringify(obj));
				}
			}

			rooms[ws.room_code].round++;
			
			rooms[ws.room_code].state = 'in-game';

			let clients = rooms[ws.room_code].clients;
			for (let uuid in clients) {
				clients[uuid].isImpostor = false;
				clients[uuid].votesImpostor = clients[uuid].votesBest = 0;
				clients[uuid].impostorVote = clients[uuid].bestVote = '';
				clients[uuid].voteForTrustImpostor = false;
				clients[uuid].detailsPoints = [];
			}

			if(!rooms[ws.room_code].rules.wordMode){
				//http.get('http://localhost/normalux.ch/multi/random', function(res){
				https.get('https://www.normalux.ch/multi/random', function(res){
					let body = '';

					res.on('data', function(chunk){
						body += chunk;
					});

					res.on('end', function(){
						rooms[ws.room_code].picture = JSON.parse(body);
						sendToPlayers();
					});
				});
			} else {
				https.get('https://www.normalux.ch/multi/word?themes='+rooms[ws.room_code].rules.themes, function(res){
					let body = '';

					res.on('data', function(chunk){
						body += chunk;
					});

					res.on('end', function(){
						rooms[ws.room_code].word = body;
						sendToPlayers();
					});
				});
			}
		}
	}

	function position(position) {
		position.playerId = ws.uuid;

		let obj = {
			type: 'position',
			position: position,
		};

		let clients = rooms[ws.room_code].clients;
		for (let uuid in clients) {
			if(clients[uuid].isImpostor){
				clients[uuid].send(JSON.stringify(obj));
			}
		}
	}

	function post(image, json) {
		let file = ws.room_code+'_'+ws.uuid+'_'+Math.floor(Math.random() * 10000);
		fs.writeFile('archives/'+file+'.png', image.split(';base64,').pop(), {encoding: 'base64'}, function(err) { });
		fs.writeFile('archives/'+file+'.json', JSON.stringify(json), {encoding: 'utf8'}, function(err) { });

		if(ws.hasOwnProperty('admin')){
			rooms[ws.room_code].state = 'voting';

			let obj = { type: 'finish-bordel' };
			let clients = rooms[ws.room_code].clients;
			for (let uuid in clients) {
				if(ws.uuid != uuid){
					clients[uuid].send(JSON.stringify(obj));
				}
			}
		}

		let obj = { type: 'model' };
		if(rooms[ws.room_code].rules.wordMode){
			obj.word = rooms[ws.room_code].word;
		} else {
			obj.image = rooms[ws.room_code].picture;
		}

		ws.send(JSON.stringify(obj));

		obj = {
			type: 'post',
			image: image,
			from: ws.uuid
		};
		let clients = rooms[ws.room_code].clients;
		for (let uuid in clients) {
			clients[uuid].send(JSON.stringify(obj));
		}
	}

	function vote(cat, player) {
		if(ws.impostorVote == '' && !ws.isImpostor && cat == 'impostor'){
			rooms[ws.room_code].clients[player].votesImpostor++;
			ws.voteForTrustImpostor = rooms[ws.room_code].clients[player].isImpostor;
			ws.impostorVote = player;
		} else if(ws.bestVote == '' && ws.uuid != player && cat == 'best') {
			rooms[ws.room_code].clients[player].votesBest++;
			ws.bestVote = player;
		}

		let voted = ws.bestVote != '' && (ws.impostorVote != '' || ws.isImpostor);

		if(voted){
			let obj = {
				type: 'voted',
				player: ws.uuid
			};

			let clients = rooms[ws.room_code].clients;
			for (let uuid in clients) {
				clients[uuid].send(JSON.stringify(obj));
			}
		}
		checkVotes();
	}

	function checkVotes() {

		let votesImpostor = { };
		let votesBest = { };
		let everyoneHasVoted = true;

		let clients = rooms[ws.room_code].clients;
		for (let uuid in clients) {
			votesImpostor[uuid] = clients[uuid].votesImpostor;
			votesBest[uuid] = clients[uuid].votesBest;

			if(!(clients[uuid].bestVote != '' && (clients[uuid].impostorVote != '' || clients[uuid].isImpostor))){
				everyoneHasVoted = false;
			}
		}
		if(everyoneHasVoted){

			let maxImpostor = Math.max.apply(Math, Object.keys(votesImpostor).map(function(o) { return votesImpostor[o]; }));
			let maxBest = Math.max.apply(Math, Object.keys(votesBest).map(function(o) { return votesBest[o]; }));

			let scores = { };
			let bests = [];
			let impostorsWin = [];
			let impostorsLoose = [];
			let innocents = [];

			let win = false;
			if(rooms[ws.room_code].rules.victoryCondition == 'rounds' && rooms[ws.room_code].round == rooms[ws.room_code].rules.roundsNumber){
				win = true;
			}

			for (let uuid in clients) {
				let combo = 0;
				if(clients[uuid].votesBest == maxBest){
					bests.push(uuid);
					clients[uuid].detailsPoints.push({ msg: 'Meilleur dessin', points: 500 });
					combo++;
				}
				if(clients[uuid].isImpostor && clients[uuid].votesImpostor != maxImpostor){
					clients[uuid].detailsPoints.push({ msg: 'Passé inaperçu', points: 1000 });
					combo++;
				}
				if(!clients[uuid].isImpostor && clients[uuid].voteForTrustImpostor){
					clients[uuid].detailsPoints.push({ msg: 'C\'était bien lui', points: 200 });
				}
				if(combo == 2){
					clients[uuid].detailsPoints.push({ msg: 'Contrefaçon', points: 500 });
				}

				for (let i = 0; i < clients[uuid].detailsPoints.length; i++) {
					clients[uuid].score += clients[uuid].detailsPoints[i].points;
				}
				if(rooms[ws.room_code].rules.victoryCondition == 'score' && clients[uuid].score >= rooms[ws.room_code].rules.scoreGoal){
					win = true;
				}
				scores[uuid] = clients[uuid].score;

				if(clients[uuid].votesImpostor < maxImpostor && clients[uuid].isImpostor){
					impostorsWin.push(uuid);
				}
				if(clients[uuid].votesImpostor == maxImpostor && clients[uuid].isImpostor){
					impostorsLoose.push(uuid);
				}
				if(clients[uuid].votesImpostor == maxImpostor && !clients[uuid].isImpostor){
					innocents.push(uuid);
				}
			}
			for (let uuid in clients) {

				let obj = {
					type: "results",
					impostorsWin: impostorsWin,
					impostorsLoose: impostorsLoose,
					innocents: innocents,
					bests: bests,
					votesImpostor: votesImpostor,
					votesBest: votesBest,
					yourPoints: clients[uuid].detailsPoints,
					scores: scores,
					finish: win
				};
				clients[uuid].send(JSON.stringify(obj));
			}

			rooms[ws.room_code].state = 'waiting';
			comeWaiters();
		}
	}

	function comeWaiters(){
		if(rooms[ws.room_code].state == 'waiting'){
			waitList = rooms[ws.room_code].clientsWaitlist;
			for (let uuid in waitList) {
				let obj = { type: 'come' };
				waitList[uuid].send(JSON.stringify(obj));
			}
		}
	}

	function kick(uuid) {
		if(ws.hasOwnProperty('admin') && rooms[ws.room_code].clients.hasOwnProperty(uuid)){
			let obj = { type: 'kicked' };
			rooms[ws.room_code].clients[uuid].send(JSON.stringify(obj));
			rooms[ws.room_code].clients[uuid].close();
		}
	}

	ws.on('close', function close() {

		if(rooms.hasOwnProperty(ws.room_code)){
			let obj = {
				type: 'leave',
				uuid: ws.uuid
			};

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
			if(rooms[ws.room_code].state == 'voting'){
				checkVotes();
			}
			console.log(ws.pseudo+' disconnected ['+Object.keys(clients).length+']');
			if(Object.keys(clients).length === 0){
				delete rooms[ws.room_code];
			}
		}
	});
});

server.listen(8080);