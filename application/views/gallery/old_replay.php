<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="draw">

	<h1 id="s">45</h1>

	<img id="model" src="<?=base_url('medias/'.(isset($drawing->picture->title)?'pictures':'drawings').'/'.$drawing->picture->file)?>" alt="<?=isset($drawing->picture->title)?$drawing->picture->title:$drawing->picture->pseudo?>" width="400" height="400" <?=$drawing->type==ROTATION_MODE?'class="rotation-canvas"':''?> />
	<canvas id="canvas" width="400" height="400" <?=$drawing->type==ROTATION_MODE?'class="rotation-model"':''?>></canvas>

</div>
<script>
	var started = false

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var myArr = JSON.parse(this.responseText);
			var j;
			for(j = 0; j < myArr.length; j++){
				setTimeout(drawAt, myArr[j][0], myArr[j][1], myArr[j][2], myArr[j][3], myArr[j][4], myArr[j][5]);
			}
		}
	};
	xmlhttp.open("GET", "<?=base_url('medias/json/'.(is_null($drawing->json)?'default.json':$drawing->json))?>", true);
	xmlhttp.send();

	var c = document.getElementById("canvas");
	var ctx = c.getContext("2d");

	ctx.lineWidth = 5;
	ctx.lineJoin = "round";
	ctx.lineCap = "round";

	function drawAt(x, y, color, painting, click){
		if(click){
			ctx.beginPath();
			ctx.moveTo(x,y);
			ctx.lineTo(x,y);
			ctx.strokeStyle = color;
			ctx.stroke();
		} else {
			if(painting){
				if (!started) {
					ctx.beginPath();
					ctx.moveTo(x,y);
					started = true;
				} else {
					ctx.lineTo(x,y);
					ctx.strokeStyle = color;
					ctx.stroke();
				}
			} else {
				started = false;
			}
		}
	}

	var s = document.getElementById("s").innerHTML;
	if(s == "∞"){
		
	} else {
		setInterval(timeDecrement, 1000);
	}

	function timeDecrement() {
		s--;
		if (s > 0){
			document.getElementById("s").innerHTML = s;
		} else if (s == 0){
			window.history.back();
		}
	}
</script>