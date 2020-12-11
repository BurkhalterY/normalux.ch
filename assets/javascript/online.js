var players = new Array();
var me = '';

var started = false;
var interval;
var voteCat = '';
var impostor = false;
var admin = false;

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
		case "welcome":
			document.getElementById('title').innerHTML = 'En attente d\'autres joueurs...';
			me = data.uuid;
			break;
		case "wait":
			document.getElementById('title').innerHTML = 'La partie a déjà commencé...';
			break;
		case "come":
			conn.onopen();
			break;
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
			admin = true;
			document.getElementById("btn-start").classList.remove('hidden');
			if(!started){
				document.getElementById("config").classList.remove('hidden');
			}
			break;
		case "start":
			if(!started){
				for (let player in players) {
					players[player].score = 0;
				}
			}
			started = true;
			positions.length = 0;
			initialTime = data.initialTime;
			ctx.strokeStyle = "black";
			ctx.lineWidth = 5;
			ctx.lineJoin = "round";
			ctx.lineCap = "round";
			refreshCursor();

			document.getElementById("btn-start").classList.add('hidden');
			document.getElementById("config").classList.add('hidden');
			document.getElementById("voting").classList.add('hidden');
			document.getElementById("in-game").classList.remove('hidden');

			document.getElementById("voting").innerHTML = "";
			document.getElementById("dashboard").innerHTML = "";
			ctx.clearRect(0, 0, c.width, c.height);

			impostor = data.impostor;
			if(impostor){
				document.getElementById('title').innerHTML = 'Plagiez les dessins des autres sans vous faire chopper !';

				document.getElementById("dashboard").classList.remove('hidden');
				document.getElementById("word").classList.add('hidden');
				document.getElementById("model").classList.add('hidden');

				document.getElementById('word').innerHTML = ''
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
				if(data.hasOwnProperty("picture")){

					document.getElementById('title').innerHTML = 'Reproduisez le modèle !';
					
					document.getElementById("model").classList.remove('hidden');
					document.getElementById("word").classList.add('hidden');
					document.getElementById("dashboard").classList.add('hidden');

					document.getElementById("model").src = data.picture.url;
					document.getElementById("model").alt = data.picture.title;

					document.getElementById("dashboard").innerHTML = '';

				} else if(data.hasOwnProperty("word")){
					
					document.getElementById('title').innerHTML = 'Illustrez le mot :';
					
					document.getElementById("word").classList.remove('hidden');
					document.getElementById("model").classList.add('hidden');
					document.getElementById("dashboard").classList.add('hidden');

					document.getElementById("word").innerHTML = data.word;

					document.getElementById("dashboard").innerHTML = '';
				}
			}

			document.getElementById("s").innerHTML = data.time;
			s = data.time;
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
			document.getElementById('voting').appendChild(gallery);
			break;
		case "model":
			let gallery2 = document.createElement('div');
			gallery2.classList.add('gallery');
			let title = '';
			if(data.hasOwnProperty("image")) {
				let img2 = document.createElement('img');
				img2.src = data.image.url;
				img2.alt = data.image.title;
				gallery2.appendChild(img2);
				title = data.image.title;
			} else if(data.hasOwnProperty("word")) {
				let svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
				svg.setAttribute('width', 400);
				svg.setAttribute('height', 400);
				let txt = document.createElementNS('http://www.w3.org/2000/svg', 'text');
				txt.setAttribute('x', "50%");
				txt.setAttribute('y', "50%");
				txt.setAttribute('text-anchor', "middle");
				txt.setAttribute('dominant-baseline', "middle");
				txt.setAttribute('font-size', "32");
				txt.setAttribute('font-family', "Arial");
				txt.appendChild(document.createTextNode(data.word));
				svg.appendChild(txt);
				gallery2.appendChild(svg);
				title = data.word;
			}
			let desc2 = document.createElement('div');
			let strong2 = document.createElement('strong');
			strong2.appendChild(document.createTextNode(title));
			desc2.appendChild(strong2);
			gallery2.appendChild(desc2);
			document.getElementById('voting').prepend(gallery2);
			break;
		case "voted":
			document.getElementById("drawing-"+data.player).classList.add("voted");
			break;
		case "results":
			document.getElementById('title').innerHTML = 'Résultats';

			let votedElements = document.getElementsByClassName('voted');
			while(votedElements.length > 0){
				votedElements[0].classList.remove('voted');
			}
			for (let i = 0; i < data.impostors.length; i++) {
				document.getElementById("drawing-"+data.impostors[i]).classList.add("impostor");
			}
			for (let i = 0; i < data.innocents.length; i++) {
				document.getElementById("drawing-"+data.innocents[i]).classList.add("innocent");
			}
			for (let i = 0; i < data.bests.length; i++) {
				document.getElementById("drawing-"+data.bests[i]).classList.add("best");
			}
			for (let player in data.votesImpostor) {
				document.getElementById("votes-"+player).innerHTML += "<br>"+"❌".repeat(data.votesImpostor[player]);
			}
			for (let player in data.votesBest) {
				document.getElementById("votes-"+player).innerHTML += "<br>"+"✔".repeat(data.votesBest[player])+"<br>";
			}
			
			for (let i = 0; i < data.yourPoints.length; i++) {
				console.log(data.yourPoints[i].msg, data.yourPoints[i].points);
			}
			let scores = Object.values(data.scores);
			let max = Math.max(...scores);
			let winner = null;
			for (let player in data.scores) {
				players[player].score = data.scores[player];
				if(max == data.scores[player]){
					winner = player;
				}
			}
			refreshPlayers();
			if(data.finish) {
				alert(players[winner].pseudo+' a gagné !');
				if(admin){
					started = false;
					document.getElementById("config").classList.remove("hidden");
				}
			}
			if(admin){
				document.getElementById("btn-start").classList.remove('hidden');
			}
	}
};

function refreshPlayers() {
	document.getElementById("players").innerHTML = '';
	for (let player in players) {
		document.getElementById("players").innerHTML += '<tr><td>'+players[player].pseudo+'</td><td id="score-'+player+'">'+players[player].score+'</td></tr>';
	}
}

function start() {
	if(!started){
		let obj = {
			type: "start",
			victoryCondition: document.getElementById("victory-condition").value,
			roundsNumber: document.getElementById("rounds-number").value,
			scoreGoal: document.getElementById("score-goal").value,
			time: document.getElementById("time").value,
			wordMode: document.getElementById("word-mode").checked
		};
		conn.send(JSON.stringify(obj));
	} else {
		let obj = { type: "restart" };
		conn.send(JSON.stringify(obj));
	}
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
			fill(params.x, params.y, player.ctx);
			break;
		case "eraser":
			player.ctx.globalCompositeOperation = params.active ? "destination-out" : "source-over";
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

finishAndSend = function() { //override
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
	document.getElementById('title').innerHTML = 'Quel est le meilleur dessin ?';
	voteCat = 'best';
}

function vote(uuid) {
	if(voteCat == 'best' && uuid == me) return;
	if(voteCat != ''){
		document.getElementById('drawing-'+uuid).classList.add("vote-"+voteCat);
		let obj = {
			type: 'vote',
			cat: voteCat,
			player: uuid
		};
		conn.send(JSON.stringify(obj));
		if(voteCat == 'best'){
			if(!impostor){
				document.getElementById('title').innerHTML = 'Qui est l\'imposteur ?';
				voteCat = 'impostor';
			} else {
				document.getElementById('title').innerHTML = 'En attente des autres votes...';
				voteCat = '';
			}
		} else if(voteCat == 'impostor'){
			document.getElementById('title').innerHTML = 'En attente des autres votes...';
			voteCat = '';
		}
	}
}

function victoiryConditionChange() {
	switch(document.getElementById("victory-condition").value){
		case "rounds":
			document.getElementById("section-rounds").classList.remove("hidden");
			document.getElementById("section-score").classList.add("hidden");
			break;
		case "score":
			document.getElementById("section-score").classList.remove("hidden");
			document.getElementById("section-rounds").classList.add("hidden");
			break;
	}
}