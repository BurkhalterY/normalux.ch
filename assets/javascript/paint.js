var painting = false;
var bucketMode = false;
var x = 0;
var y = 0;

var positions = new Array();
var initialTime = Date.now();

var c = document.getElementById("canvas");
var ctx = c.getContext("2d");

ctx.lineWidth = 5;
ctx.lineJoin = "round";
ctx.lineCap = "round";

var startColor = Array(4);
var fillColor = Array(4);

var buttons = document.getElementsByClassName("color");
for (var i = 0; i < buttons.length; i++) {
	buttons[i].style.backgroundColor = buttons[i].getAttribute("data-color");
}

function setColor(id){
	for (var i = 0; i < buttons.length; i++) {
		buttons[i].classList.remove("active");
	}
	ctx.strokeStyle = document.getElementById("color-"+id).getAttribute("data-color");
	document.getElementById("color-"+id).classList.add("active");
	positions.push({time:Date.now()-initialTime, action:"color", color:ctx.strokeStyle});
}

document.addEventListener("mouseup", function (e) {
	painting = false;
});

c.addEventListener("mousedown", function (e) {
	painting = true;
	x = e.offsetX;
	y = e.offsetY;
	positions.push({time:Date.now()-initialTime, action:"start", x:x, y:y});
});

c.addEventListener("mousemove", function (e) {
	if(painting){
		ctx.beginPath();
		ctx.moveTo(x, y);
		x = e.offsetX;
		y = e.offsetY;
		ctx.lineTo(x, y);
		ctx.stroke();
		ctx.closePath();
		positions.push({time:Date.now()-initialTime, action:"paint", x:x, y:y});
	}
});

c.addEventListener("click", function (e) {
	x = e.offsetX;
	y = e.offsetY;

	ctx.beginPath();
	ctx.moveTo(x, y);
	ctx.lineTo(x, y);
	ctx.stroke();
	ctx.closePath();
	positions.push({time:Date.now()-initialTime, action:"point", x:x, y:y});
});

var blindmode = false;
var s = document.getElementById("s").innerHTML;
positions.push({time:Date.now()-initialTime, action:"time", s:s});
if(s == "∞"){
	
} else {
	if(s == 2){
		blindmode = true;
	}
	setInterval(timeDecrement, 1000);
}

function timeDecrement() {
	s--;
	document.getElementById("s").innerHTML = s;
	if (s == 0 && !blindmode){
		finishAndSend();
	} else if(s == -1 && blindmode) {
		blindmode = false;
		s = 45;
		document.getElementById("s").innerHTML = s;
		document.getElementById("model").style.display = "none";
		c.style.display = "";
	}
}

function finishAndSend() {
	positions.push({time:Date.now()-initialTime, action:"finish"});
	var dataURL = c.toDataURL("image/png");
	document.getElementById("image").value = dataURL;
	document.getElementById("json").value = JSON.stringify(positions);
	document.getElementById("form").submit();
}
