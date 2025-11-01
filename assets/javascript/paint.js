var painting = false;
var x = 0;
var y = 0;

var positions = new Array();
var initialTime = Date.now();

var c = document.getElementById("canvas");
var ctx = c.getContext("2d");
ctx.lineWidth = 5;
ctx.lineJoin = "round";
ctx.lineCap = "round";

var buttons = {};
for (let button of document.getElementsByClassName("color")) {
	buttons[button.id] = button;
	button.style.backgroundColor = button.getAttribute("data-color");
}

function addPosition(action, param) {
	positions.push({ time: Date.now() - initialTime, action: action, ...param });
}

function setColor(id) {
	for (let i in buttons) {
		buttons[i].classList.remove("active");
	}
	let button = buttons["color-" + id];
	ctx.strokeStyle = button.getAttribute("data-color");
	button.classList.add("active");
	addPosition("color", { color: ctx.strokeStyle });
}

function touchHandler(event) {
	/*	Function to map touch events to mouse events
		Source: https://stackoverflow.com/questions/1517924/javascript-mapping-touch-events-to-mouse-events
		Updated according to: https://developer.mozilla.org/en-US/docs/Web/API/MouseEvent/MouseEvent
	*/
	let touches = event.changedTouches,
		first = touches[0],
		type = "";
	switch (event.type) {
		case "touchstart":
			type = "mousedown";
			break;
		case "touchmove":
			type = "mousemove";
			break;
		case "touchend":
			type = "mouseup";
			break;
		default:
			return;
	}

	let simulatedEvent = new MouseEvent(type, {
		screenX: first.screenX,
		screenY: first.screenY,
		clientX: first.clientX,
		clientY: first.clientY,
	});

	first.target.dispatchEvent(simulatedEvent);
	event.preventDefault();
}

document.addEventListener("mouseup", function (e) {
	painting = false;
});
document.addEventListener("touchcancel", touchHandler, true);

c.addEventListener("mousedown", function (e) {
	painting = true;
	x = e.offsetX;
	y = e.offsetY;
	addPosition("start", { x: x, y: y });
});
c.addEventListener("touchstart", touchHandler, true);

c.addEventListener("mousemove", function (e) {
	if (painting) {
		ctx.beginPath();
		ctx.moveTo(x, y);
		x = e.offsetX;
		y = e.offsetY;
		ctx.lineTo(x, y);
		ctx.stroke();
		ctx.closePath();
		addPosition("paint", { x: x, y: y });
	}
});
c.addEventListener("touchmove", touchHandler, true);

c.addEventListener("click", function (e) {
	x = e.offsetX;
	y = e.offsetY;

	ctx.beginPath();
	ctx.moveTo(x, y);
	ctx.lineTo(x, y);
	ctx.stroke();
	ctx.closePath();
	addPosition("point", { x: x, y: y });
});

var blindmode = false;
var s = document.getElementById("s").innerHTML;

addPosition("time", { s: s });
if (s != "∞") {
	if (s == 2) {
		blindmode = true;
	}
	setInterval(timeDecrement, 1000);
}

function timeDecrement() {
	s--;
	document.getElementById("s").innerHTML = s;
	if (s == 0 && !blindmode) {
		//finishAndSend();
	} else if (s == -1 && blindmode) {
		blindmode = false;
		s = 45;
		document.getElementById("s").innerHTML = s;
		document.getElementById("model").style.display = "none";
		c.style.display = "";
	}
}

function finishAndSend() {
	addPosition("finish", {});
	let dataURL = c.toDataURL("image/png");
	document.getElementById("image").value = dataURL;
	document.getElementById("json").value = JSON.stringify(positions);
	document.getElementById("form").submit();
}
