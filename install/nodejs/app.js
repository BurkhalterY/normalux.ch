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
		let obj;
		switch (datas.type) {
			case 'join':
				console.log(datas.pseudo+" joins room "+datas.room_code);

				ws.uuid = datas.pseudo+"_"+Math.floor(Math.random() * 10000);
				ws.room_code = datas.room_code;

				if(!rooms.hasOwnProperty(ws.room_code)){
					rooms[ws.room_code] = { clients: [], positions: [] };
				}
				rooms[ws.room_code].clients.push(ws);

				obj = {
					type: 'sync',
					positions: rooms[ws.room_code].positions
				};
				ws.send(JSON.stringify(obj));

				obj = {
					type: 'join',
					uuid: ws.uuid
				}

				for (let i = 0; i < rooms[ws.room_code].clients.length; i++) {
					if(ws.uuid != rooms[ws.room_code].clients[i].uuid){
						rooms[ws.room_code].clients[i].send(JSON.stringify(obj));
					}
				}

				break;
			case 'position':
				datas.position.playerId = ws.uuid;
				rooms[ws.room_code].positions.push(datas.position);

				obj = {
					type: 'position',
					position: datas.position,
				};

				for (let i = 0; i < rooms[ws.room_code].clients.length; i++) {
					if(ws.uuid != rooms[ws.room_code].clients[i].uuid){
						rooms[ws.room_code].clients[i].send(JSON.stringify(obj));
					}
				}
				break;
		}
	});

	ws.on('close', function close() {
		console.log('disconnected');
		delete rooms[ws.room_code].clients[ws.uuid];
	});
});

server.listen(8080);