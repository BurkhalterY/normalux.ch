<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="stats">
	<table id="players"></table>
</div>

<div id="in-game" class="hidden">
	<h1 id="s">∞</h1>

	<div id="dashboard"></div>
	<img id="model" src="" alt="" width="400" height="400" />
	<canvas id="canvas" width="400" height="400"></canvas>

	<ul id="colors">
		<li><a href="#" id="color-0" onclick="setColor(0)" class="color active" data-color="black"><?=$this->lang->line('color-black')?></a></li>
		<li><a href="#" id="color-1" onclick="setColor(1)" class="color" data-color="gray"><?=$this->lang->line('color-gray')?></a></li>
		<li><a href="#" id="color-2" onclick="setColor(2)" class="color" data-color="white"><?=$this->lang->line('color-white')?></a></li>
		<li><a href="#" id="color-3" onclick="setColor(3)" class="color" data-color="red"><?=$this->lang->line('color-red')?></a></li>
		<li><a href="#" id="color-4" onclick="setColor(4)" class="color" data-color="brown"><?=$this->lang->line('color-brown')?></a></li>
		<li><a href="#" id="color-5" onclick="setColor(5)" class="color" data-color="orange"><?=$this->lang->line('color-orange')?></a></li>
		<li><a href="#" id="color-6" onclick="setColor(6)" class="color" data-color="yellow"><?=$this->lang->line('color-yellow')?></a></li>
		<li><a href="#" id="color-7" onclick="setColor(7)" class="color" data-color="green"><?=$this->lang->line('color-green')?></a></li>
		<li><a href="#" id="color-8" onclick="setColor(8)" class="color" data-color="cyan"><?=$this->lang->line('color-cyan')?></a></li>
		<li><a href="#" id="color-9" onclick="setColor(9)" class="color" data-color="blue"><?=$this->lang->line('color-blue')?></a></li>
		<li><a href="#" id="color-10" onclick="setColor(10)" class="color" data-color="indigo"><?=$this->lang->line('color-indigo')?></a></li>
		<li><a href="#" id="color-11" onclick="setColor(11)" class="color" data-color="violet"><?=$this->lang->line('color-violet')?></a></li>
		<li><a href="#" id="color-12" onclick="setColor(12)" class="color" data-color="pink"><?=$this->lang->line('color-pink')?></a></li>
	</ul>
</div>

<div id="voting" class="hidden">
	<h2 id="title"></h2>
	<div id="arts"></div>
</div>

<div id="wait-room">
	<button id="btn-start" class="button button-green hidden" onclick="start();"><?=$this->lang->line('btn_start')?></button>
</div>

<script>var pseudo = "<?=$_SESSION['pseudo']?>";</script>
<script src="<?=base_url('assets/javascript/paint.js')?>"></script>
<script src="<?=base_url('assets/javascript/online.js')?>"></script>
