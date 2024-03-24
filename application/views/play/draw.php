<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1 id="s"><?=$time?></h1>

<img id="model" src="<?=base_url('medias/'.(isset($picture->title)?'pictures':'drawings').'/'.$picture->file)?>" alt="<?=isset($picture->title)?$picture->title:$picture->pseudo?>" width="400" height="400" <?=$mode==ROTATION_MODE?'class="rotation-canvas"':''?> />
<canvas id="canvas" width="400" height="400" <?=$mode==ROTATION_MODE?'class="rotation-model"':''?> <?=$mode==BLINDED_MODE?'style="display: none;"':''?>></canvas>

<ul id="colors">
	<li><a href="#" id="color-0" onclick="setColor(0)" class="color active" data-color="black"><?=$this->lang->line('color_black')?></a></li>
	<li><a href="#" id="color-1" onclick="setColor(1)" class="color" data-color="gray"><?=$this->lang->line('color_gray')?></a></li>
	<li><a href="#" id="color-2" onclick="setColor(2)" class="color" data-color="white"><?=$this->lang->line('color_white')?></a></li>
	<li><a href="#" id="color-3" onclick="setColor(3)" class="color" data-color="red"><?=$this->lang->line('color_red')?></a></li>
	<li><a href="#" id="color-4" onclick="setColor(4)" class="color" data-color="brown"><?=$this->lang->line('color_brown')?></a></li>
	<li><a href="#" id="color-5" onclick="setColor(5)" class="color" data-color="orange"><?=$this->lang->line('color_orange')?></a></li>
	<li><a href="#" id="color-6" onclick="setColor(6)" class="color" data-color="yellow"><?=$this->lang->line('color_yellow')?></a></li>
	<li><a href="#" id="color-7" onclick="setColor(7)" class="color" data-color="green"><?=$this->lang->line('color_green')?></a></li>
	<li><a href="#" id="color-8" onclick="setColor(8)" class="color" data-color="cyan"><?=$this->lang->line('color_cyan')?></a></li>
	<li><a href="#" id="color-9" onclick="setColor(9)" class="color" data-color="blue"><?=$this->lang->line('color_blue')?></a></li>
	<li><a href="#" id="color-10" onclick="setColor(10)" class="color" data-color="indigo"><?=$this->lang->line('color_indigo')?></a></li>
	<li><a href="#" id="color-11" onclick="setColor(11)" class="color" data-color="violet"><?=$this->lang->line('color_purple')?></a></li>
	<li><a href="#" id="color-12" onclick="setColor(12)" class="color" data-color="pink"><?=$this->lang->line('color_pink')?></a></li>
</ul>

<!--<div style="display: flex; justify-content: center;">
	<input type="color" id="colorPicker" onchange="colorPicker(this.value)" style="width: 50px; height: 50px; padding: 0;">
	<?php if($mode != PIXEL_ART_MODE){ ?>
		<button type="button" onclick="bucketTool()" id="bucketButton" style="width: 50px; height: 50px;"><i class="fas fa-fill-drip"></i></button>
	<?php } ?>
	<button type="button" onclick="setColor(2)" style="width: 50px; height: 50px;"><i class="fas fa-eraser"></i></button>
</div>
<?php if($mode != PIXEL_ART_MODE){ ?>
	<input type="range" min="1" max="100" value="5" id="lineWidth" class="slider" oninput="changeLineWidth(this.value)">
	<button type="button" onclick="resetLineWidth()" style="width: 40px; height: 40px;"><i class="fas fa-redo-alt"></i></button><br>
	<canvas id="lineDemo" width="120" height="120" style="border: 1px solid black;"></canvas>
<?php } ?>-->

<form action="<?=base_url('play/post/'.$mode.'/'.$id)?>" method="post" id="form">
	<input type="hidden" name="image" id="image">
	<input type="hidden" name="json" id="json">
	<input type="button" id="save" value="<?=$this->lang->line('save')?>" onclick="finishAndSend()" <?=$mode<>INFINITY_MODE?'style="display: none;"':''?>>
</form>

<?php if($mode == PIXEL_ART_MODE){ ?>
	<script src="<?=base_url('assets/javascript/pixelart.js')?>"></script>
<?php } else { ?>
	<script src="<?=base_url('assets/javascript/paint.js')?>"></script>
<?php } ?>
