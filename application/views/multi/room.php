<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1 id="s"><?=$time?></h1>

<img id="model" src="<?=base_url('medias/pictures/'.$picture->file)?>" alt="<?=$picture->title?>" width="400" height="400" />
<canvas id="canvas" width="400" height="400"></canvas>

<ul id="colors">
	<li><a href="#" id="color-0" onclick="setColor(0)" class="color active" data-color="black"><?=$this->lang->line('black')?></a></li>
	<li><a href="#" id="color-1" onclick="setColor(1)" class="color" data-color="gray"><?=$this->lang->line('gray')?></a></li>
	<li><a href="#" id="color-2" onclick="setColor(2)" class="color" data-color="white"><?=$this->lang->line('white')?></a></li>
	<li><a href="#" id="color-3" onclick="setColor(3)" class="color" data-color="red"><?=$this->lang->line('red')?></a></li>
	<li><a href="#" id="color-4" onclick="setColor(4)" class="color" data-color="brown"><?=$this->lang->line('brown')?></a></li>
	<li><a href="#" id="color-5" onclick="setColor(5)" class="color" data-color="orange"><?=$this->lang->line('orange')?></a></li>
	<li><a href="#" id="color-6" onclick="setColor(6)" class="color" data-color="yellow"><?=$this->lang->line('yellow')?></a></li>
	<li><a href="#" id="color-7" onclick="setColor(7)" class="color" data-color="green"><?=$this->lang->line('green')?></a></li>
	<li><a href="#" id="color-8" onclick="setColor(8)" class="color" data-color="cyan"><?=$this->lang->line('cyan')?></a></li>
	<li><a href="#" id="color-9" onclick="setColor(9)" class="color" data-color="blue"><?=$this->lang->line('blue')?></a></li>
	<li><a href="#" id="color-10" onclick="setColor(10)" class="color" data-color="indigo"><?=$this->lang->line('indigo')?></a></li>
	<li><a href="#" id="color-11" onclick="setColor(11)" class="color" data-color="violet"><?=$this->lang->line('violet')?></a></li>
	<li><a href="#" id="color-12" onclick="setColor(12)" class="color" data-color="pink"><?=$this->lang->line('pink')?></a></li>
</ul>


<?php /* <form action="<?=base_url('play/post/'.$mode.'/'.$id)?>" method="post" id="form">
	<input type="hidden" name="image" id="image">
	<input type="hidden" name="json" id="json">
	<input type="button" id="save" value="<?=$this->lang->line('btn_save')?>" onclick="finishAndSend()" <?=$mode<>INFINITY_MODE?'style="display: none;"':''?>>
</form> */ ?>

<script src="<?=base_url('assets/javascript/paint.js')?>"></script>
<script src="<?=base_url('assets/javascript/online.js')?>"></script>