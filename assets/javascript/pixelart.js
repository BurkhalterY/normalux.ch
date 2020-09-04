var painting = false;
var x = 0, y = 0;
var x1 = 0, y1 = 0;
var tile = 25;

var positions = new Array();
var initialTime = Date.now();

var c = document.getElementById("canvas");
var ctx = c.getContext("2d");

ctx.lineWidth = 5;
ctx.lineJoin = "round";
ctx.lineCap = "round";

var buttons = document.getElementsByClassName("color");
for (var i = 0; i < buttons.length; i++) {
	buttons[i].style.backgroundColor = buttons[i].getAttribute("data-color");
}

function setColor(id){
	for (var i = 0; i < buttons.length; i++) {
		buttons[i].classList.remove("active");
	}
	ctx.fillStyle = document.getElementById("color-"+id).getAttribute("data-color");
	document.getElementById("color-"+id).classList.add("active");
	positions.push({time:Date.now()-initialTime, action:"color", color:ctx.fillStyle});
}

function colorPicker(color){
	for (var i = 0; i < buttons.length; i++) {
		buttons[i].classList.remove("active");
	}
	ctx.fillStyle = color;
	positions.push({time:Date.now()-initialTime, action:"color", color:ctx.fillStyle});
}

document.addEventListener("mouseup", function (e) {
	painting = false;
});

c.addEventListener("mousedown", function (e) {
	painting = true;
});

c.addEventListener("mousemove", function (e) {
	if(painting){
		x = e.offsetX;
		y = e.offsetY;
		x1 = Math.ceil(x/tile) * tile - tile;
		y1 = Math.ceil(y/tile) * tile - tile;
		drawRect();
		positions.push({time:Date.now()-initialTime, action:"rect", x:x1, y:y1});
	}
});

c.addEventListener("click", function (e) {
	x = e.offsetX;
	y = e.offsetY;
	x1 = Math.ceil(x/tile) * tile - tile;
	y1 = Math.ceil(y/tile) * tile - tile;
	drawRect();
	positions.push({time:Date.now()-initialTime, action:"rect", x:x1, y:y1});
});

function drawRect() {
	ctx.fillRect(x1, y1, tile, tile);
	ctx.stroke();
}

var s = document.getElementById("s").innerHTML;
positions.push({time:Date.now()-initialTime, action:"time", s:s});
if(s == "∞"){
	
} else {
	setInterval(timeDecrement, 1000);
}

function timeDecrement() {
	s--;
	document.getElementById("s").innerHTML = s;
	if (s == 0){
		finishAndSend();
	}
}

function finishAndSend() {
	positions.push({time:Date.now()-initialTime, action:"finish"});
	var dataURL = c.toDataURL("image/png");
	document.getElementById("image").value = dataURL;
	document.getElementById("json").value = JSON.stringify(positions);
	document.getElementById("form").submit();
}
