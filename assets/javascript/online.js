var conn = new WebSocket('wss://online.normalux.ch');
//var conn = new WebSocket('ws://localhost:8080');

var players = new Array();

var interval;
var voteCat = '';


positions.push = function(e) {
	Array.prototype.push.call(positions, e);

	let obj = {
		type: "position",
		position: positions[positions.length-1]
	}
	conn.send(JSON.stringify(obj));
};

conn.onopen = function(e) {
	let obj = {
		type: "join",
		pseudo: pseudo,
		room_code: window.location.pathname.split("/").pop()
	}
	conn.send(JSON.stringify(obj));
};

conn.onmessage = function(e) {
	let data = JSON.parse(e.data);
	switch(data.type){
		case "join":
			players[data.uuid] = {
				pseudo: data.pseudo,
				score: 0
			};
			refreshPlayers();
			break;
		case "leave":
			delete players[data.uuid];
			refreshPlayers();
			break;
		case "admin":
			document.getElementById("btn-start").classList.remove('hidden');
			break;
		case "start":
			positions.length = 0;
			initialTime = data.initialTime;
			ctx.strokeStyle = "black";
			ctx.lineWidth = 5;
			ctx.lineJoin = "round";
			ctx.lineCap = "round";
			refreshCursor();

			document.getElementById("wait-room").classList.add('hidden');
			document.getElementById("voting").classList.add('hidden');
			document.getElementById("in-game").classList.remove('hidden');

			document.getElementById("arts").innerHTML = "";
			document.getElementById("dashboard").innerHTML = "";
			ctx.clearRect(0, 0, c.width, c.height);

			if(data.impostor){
				document.getElementById("dashboard").classList.remove('hidden');
				document.getElementById("model").classList.add('hidden');

				document.getElementById("model").src = '';
				document.getElementById("model").alt = '???';

				for (let player in players) {
					let node = document.createElement('canvas');
					node.id = 'canvas-'+player;
					node.width = 400;
					node.height = 400;
					node.classList.add('model');
					document.getElementById("dashboard").appendChild(node);

					players[player].x = players[player].y = 0;
					let ctx = document.getElementById("canvas-"+player).getContext("2d");
					ctx.lineWidth = 5;
					ctx.lineJoin = "round";
					ctx.lineCap = "round";
					players[player].ctx = ctx;
				}
			} else {
				document.getElementById("model").classList.remove('hidden');
				document.getElementById("dashboard").classList.add('hidden');

				document.getElementById("model").src = data.picture.url;
				document.getElementById("model").alt = data.picture.title;

				document.getElementById("dashboard").innerHTML = '';
			}

			document.getElementById("s").innerHTML = 45;
			s = document.getElementById("s").innerHTML;
			interval = setInterval(timeDecrement, 1000);

			break;
		case "position":
			action(data.position);
			break;
		case "post":
			let gallery = document.createElement('div');
			gallery.id = "drawing-"+data.from;
			gallery.classList.add('gallery');
			gallery.onclick = function(){ vote(data.from) };
			let img = document.createElement('img');
			img.src = data.image;
			img.alt = players[data.from].pseudo;
			gallery.appendChild(img);
			let desc = document.createElement('div');
			desc.id = "votes-"+data.from;
			desc.appendChild(document.createTextNode(players[data.from].pseudo));
			gallery.appendChild(desc);
			document.getElementById('arts').appendChild(gallery);
			break;
		case "results":
			for (let player in data.votesImpostor) {
				document.getElementById("votes-"+player).innerHTML += "<br>Votes imposteur : "+data.votesImpostor[player];
			}
			for (let player in data.votesBest) {
				document.getElementById("votes-"+player).innerHTML += "<br>Votes meilleur dessin : "+data.votesBest[player];
			}
			for (let i = 0; i < data.yourPoints.length; i++) {
				console.log(data.yourPoints[i].msg, data.yourPoints[i].points);
			}
			for (let player in data.scores) {
				players[player].score = data.scores[player];
			}
			refreshPlayers();
			document.getElementById("wait-room").classList.remove("hidden");
	}
};

function refreshPlayers() {
	document.getElementById("players").innerHTML = '';
	for (let player in players) {
		document.getElementById("players").innerHTML += '<tr><td>'+players[player].pseudo+'</td><td id="score-'+player+'">'+players[player].score+'</td></tr>';
	}
}

function start() {
	let obj = { type: "start" }
	conn.send(JSON.stringify(obj));
}

function action(params) {
	let player = players[params.playerId];
	switch(params.action){
		case "time":
			// Illegal
			break;
		case "color":
			player.ctx.strokeStyle = params.color;
			break;
		case "width":
			player.ctx.lineWidth = params.width;
			break;
		case "start":
			player.x = params.x;
			player.y = params.y;
			break;
		case "paint":
			player.ctx.beginPath();
			player.ctx.moveTo(player.x, player.y);
			player.x = params.x;
			player.y = params.y;
			player.ctx.lineTo(player.x, player.y);
			player.ctx.stroke();
			player.ctx.closePath();
			break;
		case "point":
			player.x = params.x;
			player.y = params.y;
			player.ctx.beginPath();
			player.ctx.moveTo(player.x, player.y);
			player.ctx.lineTo(player.x, player.y);
			player.ctx.stroke();
			player.ctx.closePath();
			break;
		case "fill":
			// Illegal
			break;
		case "reset":
			// Illegal
			break;
		case "rect":
			// Illegal
			break;
		case "finish":
			// Illegal
			break;
	}
}

finishAndSend = function() {
	clearInterval(interval);
	positions.push({time:Date.now()-initialTime, action:"finish"});
	let obj = {
		type: 'post',
		image: c.toDataURL("image/png"),
		json: positions
	}
	conn.send(JSON.stringify(obj));

	document.getElementById('in-game').classList.add("hidden");
	document.getElementById('voting').classList.remove("hidden");
	document.getElementById('title').innerHTML = 'Qui est l\'imposteur ?';
	voteCat = 'impostor';
}

function vote(uuid) {
	if(voteCat != ''){
		document.getElementById('drawing-'+uuid).classList.add(voteCat);
		let obj = {
			type: 'vote',
			cat: voteCat,
			player: uuid
		};
		conn.send(JSON.stringify(obj));
		if(voteCat == 'impostor'){
			document.getElementById('title').innerHTML = 'Quel est le meilleur dessin ?';
			voteCat = 'best';
		} else if(voteCat == 'best'){
			document.getElementById('title').innerHTML = 'En attente des autres votes...';
			voteCat = '';
		}
	}
}