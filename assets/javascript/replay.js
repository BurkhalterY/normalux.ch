var painting = false;
var x = 0;
var y = 0;
var tile = 25;
var blindmode = false;

var c = document.getElementById("canvas");
var ctx = c.getContext("2d");

ctx.lineWidth = 5;
ctx.lineJoin = "round";
ctx.lineCap = "round";

var timer;

var colorLayer;
var startColor = Array(4);
var fillColor = Array(4);

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		var myArr = JSON.parse(this.responseText);
		for(var j = 0; j < myArr.length; j++){
			setTimeout(action, myArr[j].time, myArr[j]);
		}
	}
};
xmlhttp.open("GET", document.getElementById("json").value, true);
xmlhttp.send();

function action(params){
	switch(params.action){
		case "time":
			s = params.s;
			document.getElementById("s").innerHTML = s;
			if(s == "∞"){

			} else {
				if(s == 2){
					blindmode = true;
				}
				timer = setInterval(timeDecrement, 1000);
			}
			break;
		case "color":
			ctx.strokeStyle = params.color;
			ctx.fillStyle = params.color;
			break;
		case "width":
			ctx.lineWidth = params.width;
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
			x = params.x;
			y = params.y;
			bucketTool();
			break;
		case "reset":
			ctx.clearRect(0, 0, c.width, c.height);
			break;
		case "rect":
			drawRect(params.x, params.y);
			break;
		case "finish":
			window.history.back();
			break;
	}
}

function bucketTool(){
	colorLayer = ctx.getImageData(0, 0, c.width, c.height);

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

function drawRect(x1, y1) {
	ctx.fillRect(x1, y1, tile, tile);
	ctx.stroke();
}

function timeDecrement() {
	s--;
	document.getElementById("s").innerHTML = s;
	if(s == -1 && blindmode) {
		blindmode = false;
		s = 45;
		document.getElementById("s").innerHTML = s;
		document.getElementById("model").style.display = "none";
		c.style.display = "";
	}
}
