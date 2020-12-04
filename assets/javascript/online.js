var conn = new WebSocket('ws://online.normalux.ch');

var players = new Array();

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
		case "position":
			action(data.position);
			break;
		case "sync":
			for (let i = 0; i < data.positions.length; i++) {
				action(data.positions[i]);
			}
			break;
		case "join":
			players.push(data.uuid);
			break;
	}
};

function action(params) {
	if(players[params.playerId] === undefined){
		players[params.playerId] = {
			x: 0,
			y: 0,
			color: "black",
		}
	}
	player = players[params.playerId];
	let color;
	switch(params.action){
		case "time":
			// Illegal
			break;
		case "color":
			player.color = params.color;
			break;
		case "width":
			// Illegal
			break;
		case "start":
			player.x = params.x;
			player.y = params.y;
			break;
		case "paint":
			color = ctx.strokeStyle;
			ctx.strokeStyle = player.color;

			ctx.beginPath();
			ctx.moveTo(player.x, player.y);
			player.x = params.x;
			player.y = params.y;
			ctx.lineTo(player.x, player.y);
			ctx.stroke();
			ctx.closePath();

			ctx.strokeStyle = color;
			break;
		case "point":
			color = ctx.strokeStyle;
			ctx.strokeStyle = player.color;

			player.x = params.x;
			player.y = params.y;
			ctx.beginPath();
			ctx.moveTo(player.x, player.y);
			ctx.lineTo(player.x, player.y);
			ctx.stroke();
			ctx.closePath();

			ctx.strokeStyle = color;
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
		players[params.playerId] = player;
	}
}
