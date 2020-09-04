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

var lpv = document.getElementById("lineDemo");
var lpc = lpv.getContext("2d");

lpc.lineWidth = 5;
lpc.lineJoin = "round";
lpc.lineCap = "round";
refreshLpv();

var colorLayer;
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
	lpc.strokeStyle = document.getElementById("color-"+id).getAttribute("data-color");
	document.getElementById("color-"+id).classList.add("active");
	refreshLpv();
	positions.push({time:Date.now()-initialTime, action:"color", color:ctx.strokeStyle});
}

function changeLineWidth(lineWidth){
	ctx.lineWidth = lineWidth;
	lpc.lineWidth = lineWidth;
	refreshLpv();
	positions.push({time:Date.now()-initialTime, action:"width", width:ctx.lineWidth});
}

function resetLineWidth(){
	changeLineWidth(5);
	document.getElementById("lineWidth").value = ctx.lineWidth;
}

function colorPicker(color){
	for (var i = 0; i < buttons.length; i++) {
		buttons[i].classList.remove("active");
	}
	ctx.strokeStyle = color;
	lpc.strokeStyle = color;
	refreshLpv();
	positions.push({time:Date.now()-initialTime, action:"color", color:ctx.strokeStyle});
}

function bucketTool(){
	if(bucketMode){
		bucketMode = false;
		document.getElementById("bucketButton").style.backgroundColor = "";
		document.getElementById("canvas").classList.remove("bucket");
	} else {
		bucketMode = true;
		document.getElementById("bucketButton").style.backgroundColor = "cyan";
		document.getElementById("canvas").classList.add("bucket");
	}
}

function refreshLpv(){
	lpc.clearRect(0, 0, lpv.width, lpv.height);
	lpc.beginPath();
	lpc.moveTo(lpc.lineWidth/2, lpv.height / 2);
	lpc.lineTo(lpv.width - lpc.lineWidth/2, lpv.height / 2);
	lpc.stroke();
	lpc.closePath();
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

	if(bucketMode){
		colorLayer = ctx.getImageData(0, 0, c.width, c.height);

		startColor = nameToHex(ctx.strokeStyle);
		if(!matchStartColor((y*c.width + x) * 4)){

			positions.push({time:Date.now()-initialTime, action:"fill", x:x, y:y});

			for(var i = 0; i < 4; i++){
				startColor[i] = colorLayer.data[x*4 + y*c.width*4 + i];
			}
			fillColor = nameToHex(ctx.strokeStyle);
			pixelStack = [[x, y]];

			while(pixelStack.length)
			{
				var newPos, pixelPos, reachLeft, reachRight;
				newPos = pixelStack.pop();
				x = newPos[0];
				y = newPos[1];
				
				pixelPos = (y*c.width + x) * 4;
				while(y-- >= 0/*drawingBoundTop*/ && matchStartColor(pixelPos))
				{
					pixelPos -= c.width * 4;
				}
				pixelPos += c.width * 4;
				y++;
				reachLeft = false;
				reachRight = false;
				while(y++ < c.height-1 && matchStartColor(pixelPos))
				{
					colorPixel(pixelPos);

					if(x > 0) {
						if(matchStartColor(pixelPos - 4)) {
							if(!reachLeft){
								pixelStack.push([x - 1, y]);
								reachLeft = true;
							}
						} else if(reachLeft) {
							reachLeft = false;
						}
					}
				
					if(x < c.width-1) {
						if(matchStartColor(pixelPos + 4)) {
							if(!reachRight) {
								pixelStack.push([x + 1, y]);
								reachRight = true;
							}
						} else if(reachRight) {
							reachRight = false;
						}
					}
						
					pixelPos += c.width * 4;
				}
			}
			ctx.putImageData(colorLayer, 0, 0);
		}
	} else {
		ctx.beginPath();
		ctx.moveTo(x, y);
		ctx.lineTo(x, y);
		ctx.stroke();
		ctx.closePath();
		positions.push({time:Date.now()-initialTime, action:"point", x:x, y:y});
	}
});

function matchStartColor(pixelPos) {

	let threshold = 4;

	var r = Math.abs(startColor[0] - colorLayer.data[pixelPos+0]) <= threshold;
	var g = Math.abs(startColor[1] - colorLayer.data[pixelPos+1]) <= threshold;
	var b = Math.abs(startColor[2] - colorLayer.data[pixelPos+2]) <= threshold;
	var a = Math.abs(startColor[3] - colorLayer.data[pixelPos+3]) <= threshold;

	return (r && g && b && a);
}

function colorPixel(pixelPos) {
	colorLayer.data[pixelPos] = fillColor[0];
	colorLayer.data[pixelPos+1] = fillColor[1];
	colorLayer.data[pixelPos+2] = fillColor[2];
	if(colorLayer.data[pixelPos+3] == 0){
		colorLayer.data[pixelPos+3] = 255;
	}
}

function nameToHex(name) {

	let fakeDiv = document.createElement("div");
	fakeDiv.style.color = name;
	document.body.appendChild(fakeDiv);

	let cs = window.getComputedStyle(fakeDiv),
	pv = cs.getPropertyValue("color");

	document.body.removeChild(fakeDiv);

	let rgb = pv.substr(4).split(")")[0].split(",");

	return [rgb[0], rgb[1], rgb[2], 0xFF];
}

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
