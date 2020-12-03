var conn = new WebSocket('ws://localhost:8080');

positions.push = function(e) {
	Array.prototype.push.call(positions, e);

	let obj = { broadcast: true };
	obj.type = "position";
	obj.position = positions[positions.length-1];
	conn.send(JSON.stringify(obj));
};

conn.onmessage = function(e) {
	let data = JSON.parse(e.data);
	switch(data.type){
		case "position":
			action(data.position);
			break;
	}
};

function action(params) {
	switch(params.action){
		case "time":
			// Illegal
			break;
		case "color":
			ctx.strokeStyle = params.color;
			ctx.fillStyle = params.color;
			break;
		case "width":
			break;
		case "start":
			x = params.x;
			y = params.y;
			break;
		case "paint":
			ctx.beginPath();
			ctx.moveTo(x, y);
			x = params.x;
			y = params.y;
			ctx.lineTo(x, y);
			ctx.stroke();
			ctx.closePath();
			break;
		case "point":
			x = params.x;
			y = params.y;
			ctx.beginPath();
			ctx.moveTo(x, y);
			ctx.lineTo(x, y);
			ctx.stroke();
			ctx.closePath();
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
