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

var buttons = document.getElementsByClassName("color");
for (let i = 0; i < buttons.length; i++) {
	buttons[i].style.backgroundColor = buttons[i].getAttribute("data-color");
}

refreshCursor();

function disableAll(){
	ctx.globalCompositeOperation = "source-over";
	bucketMode = false;
	positions.push({time:Date.now()-initialTime, action:"eraser", active:false});

	document.getElementById("pencil").classList.remove("active");
	document.getElementById("eraser").classList.remove("active");
	document.getElementById("bucket").classList.remove("active");
}

function setColor(id){
	for (let i = 0; i < buttons.length; i++) {
		buttons[i].classList.remove("active");
	}
	ctx.strokeStyle = document.getElementById("color-"+id).getAttribute("data-color");
	document.getElementById("color-"+id).classList.add("active");
	refreshCursor();
	positions.push({time:Date.now()-initialTime, action:"color", color:ctx.strokeStyle});
}

function setPencil(){
	disableAll();
	document.getElementById("pencil").classList.add("active");
	refreshCursor();
}

function setEraser(){
	disableAll();
	document.getElementById("eraser").classList.add("active");
	ctx.globalCompositeOperation = "destination-out";
	refreshCursor();
	positions.push({time:Date.now()-initialTime, action:"eraser", active:true});
}

function setBucket(){
	disableAll();
	document.getElementById("bucket").classList.add("active");
	bucketMode = true;
	refreshCursor();
}

function mouseUp(){
	painting = false;
}

function mouseDown(ex, ey){
	if(!bucketMode){
		painting = true;
		x = ex;
		y = ey;
		positions.push({time:Date.now()-initialTime, action:"start", x:x, y:y});
	}
}

function mouseMove(ex, ey){
	if(painting && !bucketMode){
		ctx.beginPath();
		ctx.moveTo(x, y);
		x = ex;
		y = ey;
		ctx.lineTo(x, y);
		ctx.stroke();
		ctx.closePath();
		positions.push({time:Date.now()-initialTime, action:"paint", x:x, y:y});
	}
}

function click(ex, ey){
	x = ex;
	y = ey;
	if(!bucketMode) {
		ctx.beginPath();
		ctx.moveTo(x, y);
		ctx.lineTo(x, y);
		ctx.stroke();
		ctx.closePath();
		positions.push({time:Date.now()-initialTime, action:"point", x:x, y:y});
	} else {
		x = Math.round(x);
		y = Math.round(y);
		fill(x, y, ctx);
		positions.push({time:Date.now()-initialTime, action:"fill", x:x, y:y});
	}
}

function wheel(delta){
	ctx.lineWidth = Math.min(ctx.lineWidth - delta, 50);
	refreshCursor();
	positions.push({time:Date.now()-initialTime, action:"width", width: ctx.lineWidth});
}

function setSize(size){
	ctx.lineWidth = size;
	refreshCursor();
	positions.push({time:Date.now()-initialTime, action:"width", width: ctx.lineWidth});
}

document.addEventListener("mouseup", function (e) {
	mouseUp();
});

c.addEventListener("mousedown", function (e) {
	let ex = e.offsetX / c.clientWidth * c.width;
	let ey = e.offsetY / c.clientHeight * c.height;
	mouseDown(ex, ey);
});

c.addEventListener("mousemove", function (e) {
	let ex = e.offsetX / c.clientWidth * c.width;
	let ey = e.offsetY / c.clientHeight * c.height;
	mouseMove(ex, ey);
});

c.addEventListener("click", function (e) {
	let ex = e.offsetX / c.clientWidth * c.width;
	let ey = e.offsetY / c.clientHeight * c.height;
	click(ex, ey);
});

c.addEventListener("wheel", function (e) {
	wheel(e.deltaY);
});

document.addEventListener("touchend", function (e) {
	mouseUp();
});

document.addEventListener("touchcancel", function (e) {
	mouseUp();
});

c.addEventListener("touchstart", function (e) {
	let rect = e.target.getBoundingClientRect();
	let ex = (e.targetTouches[0].pageX - rect.left) / c.clientWidth * c.width;
	let ey = (e.targetTouches[0].pageY - rect.top) / c.clientHeight * c.height;
	mouseDown(ex, ey);
});

c.addEventListener("touchmove", function (e) {
	let rect = e.target.getBoundingClientRect();
	let ex = (e.targetTouches[0].pageX - rect.left) / c.clientWidth * c.width;
	let ey = (e.targetTouches[0].pageY - rect.top) / c.clientHeight * c.height;
	mouseMove(ex, ey);
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

function refreshCursor() {
	if(!bucketMode){
		let size = ctx.lineWidth * c.clientWidth / c.width;
		let color = ctx.globalCompositeOperation == "destination-out" ? "#ffffff" : ctx.strokeStyle;
		let svg = '<svg height="'+size+'" width="'+size+'" xmlns="http://www.w3.org/2000/svg"><circle cx="'+(size/2)+'" cy="'+(size/2)+'" r="'+(size/2)+'" fill="'+color+'" /></svg>';
		c.style.cursor = 'url(\'data:image/svg+xml;utf8,'+encodeURIComponent(svg)+'\')'+(size/2)+' '+(size/2)+',auto';
	} else {
		c.style.cursor = 'url(\'/assets/css/bucket.cur\') 0 16,auto';
	}
}

window.onresize = refreshCursor;

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

/*   _____________
 *  |FILL FUNCTION|
 *
 */


function fill(x, y, context) {
	let colorLayer = context.getImageData(0, 0, c.width, c.height);
	let fillColor = hexToRgb(context.strokeStyle);
	let startColor = new Array(3);

	if(colorLayer.data[x*4 + y*c.width*4 + 3] == 0){
		startColor = [255, 255, 255];
	} else {
		for(let i = 0; i < 3; i++){
			startColor[i] = colorLayer.data[x*4 + y*c.width*4 + i];
		}
	}
	

	if(!matchColor(fillColor, (y*c.width + x) * 4)){
		
		pixelStack = [[x, y]];

		while(pixelStack.length)
		{
			let newPos, pixelPos, reachLeft, reachRight;
			newPos = pixelStack.pop();
			x = newPos[0];
			y = newPos[1];
			
			pixelPos = (y*c.width + x) * 4;
			while(y-- >= 0/*drawingBoundTop*/ && matchColor(startColor, pixelPos))
			{
				pixelPos -= c.width * 4;
			}
			pixelPos += c.width * 4;
			y++;
			reachLeft = false;
			reachRight = false;
			while(y++ < c.height-1 && matchColor(startColor, pixelPos))
			{
				colorPixel(pixelPos);

				if(x > 0) {
					if(matchColor(startColor, pixelPos - 4)) {
						if(!reachLeft){
							pixelStack.push([x - 1, y]);
							reachLeft = true;
						}
					} else if(reachLeft) {
						reachLeft = false;
					}
				}
			
				if(x < c.width-1) {
					if(matchColor(startColor, pixelPos + 4)) {
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
		context.putImageData(colorLayer, 0, 0);
	}

	function matchColor(color, pixelPos) {

		let colorLayerPixel = new Array(3);

		if(colorLayer.data[pixelPos+3] == 0){
			colorLayerPixel = [255, 255, 255];
		} else {
			for (let i = 0; i < colorLayerPixel.length; i++) {
				colorLayerPixel[i] = colorLayer.data[pixelPos+i];
			}
		}

		let r = Math.pow(color[0] - colorLayerPixel[0], 2);
		let g = Math.pow(color[1] - colorLayerPixel[1], 2);
		let b = Math.pow(color[2] - colorLayerPixel[2], 2);

		return r + g + b < Math.pow(64, 2);
	}

	function colorPixel(pixelPos) {
		colorLayer.data[pixelPos] = fillColor[0];
		colorLayer.data[pixelPos+1] = fillColor[1];
		colorLayer.data[pixelPos+2] = fillColor[2];
		colorLayer.data[pixelPos+3] = 255;
	}

	function hexToRgb(hex) {
		let bigint = parseInt(hex.substring(1), 16);
		let r = (bigint >> 16) & 255;
		let g = (bigint >> 8) & 255;
		let b = bigint & 255;

		return [r, g, b];
	}
}
