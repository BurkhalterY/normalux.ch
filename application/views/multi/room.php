<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="stats">
	<table id="players"></table>
</div>

<h3 id="title"></h3>

<div id="config" class="hidden">
	<label for="victory-condition">Condition de victoire :</label>
	<select name="victory-condition" id="victory-condition"	onchange="victoiryConditionChange();">
		<option value="rounds" selected>Nombre de manches</option>
		<option value="score">Score maximum</option>
	</select>
	<br>
	<div id="section-rounds">
		<label for="rounds-number">Nombre de manches :</label>
		<input type="number" name="rounds-number" id="rounds-number" class="field" value="5">
		<br>
	</div>
	<div id="section-score" class="hidden">
		<label for="score-goal">Score à atteindre :</label>
		<input type="number" name="score-goal" id="score-goal" class="field" value="10000">
		<br>
	</div>
	<label for="time">Temps (en secondes) :</label>
	<input type="number" name="time" id="time" class="field" value="45">
	<br>
	<label for="word-mode">Mode mots :</label>
	<input type="checkbox" id="word-mode" name="word-mode" onclick="changeMode();">
	<div id="section-themes" class="hidden">
		<select id="themes" multiple>
			<?php foreach ($themes as $theme) { ?>
				<option value="<?=$theme->id?>"><?=$theme->theme?></option>
			<?php } ?>
		</select>
	</div>
	<br>
</div>

<div id="in-game" class="hidden">
	<h2 id="word"></h2>
	<h2 id="s">∞</h2>

	<div id="dashboard"></div>
	<img id="model" src="" alt="" width="400" height="400" />
	<canvas id="canvas" width="400" height="400"></canvas>

	<ul id="colors" class="colors-multi">
		<li><a href="#" id="color-0" onclick="setColor(0)" class="color" data-color="#FF0000"></a></li>
		<li><a href="#" id="color-1" onclick="setColor(1)" class="color" data-color="#FF9020"></a></li>
		<li><a href="#" id="color-2" onclick="setColor(2)" class="color" data-color="#FFD800"></a></li>
		<li><a href="#" id="color-3" onclick="setColor(3)" class="color" data-color="#B6FF00"></a></li>
		<li><a href="#" id="color-4" onclick="setColor(4)" class="color" data-color="#00E400"></a></li>
		<li><a href="#" id="color-5" onclick="setColor(5)" class="color" data-color="#00FFAF"></a></li>
		<li><a href="#" id="color-6" onclick="setColor(6)" class="color" data-color="#00FFB0"></a></li>
		<li><a href="#" id="color-7" onclick="setColor(7)" class="color" data-color="#0090FF"></a></li>
		<li><a href="#" id="color-8" onclick="setColor(8)" class="color" data-color="#0010D0"></a></li>
		<li><a href="#" id="color-9" onclick="setColor(9)" class="color" data-color="#9800D0"></a></li>
		<li><a href="#" id="color-10" onclick="setColor(10)" class="color" data-color="#FF30B0"></a></li>
		<li><a href="#" id="pencil" onclick="setPencil()" class="fas fa-pen active"></a></li>
		<br>
		<li><a href="#" id="color-11" onclick="setColor(11)" class="color" data-color="#C4002F"></a></li>
		<li><a href="#" id="color-12" onclick="setColor(12)" class="color" data-color="#994B16"></a></li>
		<li><a href="#" id="color-13" onclick="setColor(13)" class="color" data-color="#C4A216"></a></li>
		<li><a href="#" id="color-14" onclick="setColor(14)" class="color" data-color="#6DAC26"></a></li>
		<li><a href="#" id="color-15" onclick="setColor(15)" class="color" data-color="#107726"></a></li>
		<li><a href="#" id="color-16" onclick="setColor(16)" class="color" data-color="#00C1A8"></a></li>
		<li><a href="#" id="color-17" onclick="setColor(17)" class="color" data-color="#0086C1"></a></li>
		<li><a href="#" id="color-18" onclick="setColor(18)" class="color" data-color="#00209C"></a></li>
		<li><a href="#" id="color-19" onclick="setColor(19)" class="color" data-color="#00004E"></a></li>
		<li><a href="#" id="color-20" onclick="setColor(20)" class="color" data-color="#61006D"></a></li>
		<li><a href="#" id="color-21" onclick="setColor(21)" class="color" data-color="#9F0077"></a></li>
		<li><a href="#" id="eraser" onclick="setEraser()" class="fas fa-eraser"></a></li>
		<br>
		<li><a href="#" id="color-22" onclick="setColor(22)" class="color" data-color="#FFD8C0"></a></li>
		<li><a href="#" id="color-23" onclick="setColor(23)" class="color" data-color="#E0B088"></a></li>
		<li><a href="#" id="color-24" onclick="setColor(24)" class="color" data-color="#A07018"></a></li>
		<li><a href="#" id="color-25" onclick="setColor(25)" class="color" data-color="#804E00"></a></li>
		<li><a href="#" id="color-26" onclick="setColor(26)" class="color active" data-color="#000000"></a></li>
		<li><a href="#" id="color-27" onclick="setColor(27)" class="color" data-color="#2B2B2B"></a></li>
		<li><a href="#" id="color-28" onclick="setColor(28)" class="color" data-color="#545454"></a></li>
		<li><a href="#" id="color-29" onclick="setColor(29)" class="color" data-color="#7F7F7F"></a></li>
		<li><a href="#" id="color-30" onclick="setColor(30)" class="color" data-color="#AAAAAA"></a></li>
		<li><a href="#" id="color-31" onclick="setColor(31)" class="color" data-color="#D3D3D3"></a></li>
		<li><a href="#" id="color-32" onclick="setColor(32)" class="color" data-color="#FFFFFF"></a></li>
		<li><a href="#" id="bucket" onclick="setBucket()" class="fas fa-fill-drip"></a></li>
		<br>
		<br>
		<input type="range" min="1" max="50" value="5" class="slider" oninput="setSize(this.value)" onchange="setSize(this.value)">
	</ul>
</div>

<div id="voting" class="hidden"></div>
<button id="btn-start" class="button button-green hidden" onclick="start();"><?=$this->lang->line('btn_start')?></button>

<script>
	var pseudo = "<?=$_SESSION['pseudo']?>";
	var conn = new WebSocket('<?=ONLINE_URL?>');
</script>
<script src="<?=base_url('assets/javascript/paint.js')?>"></script>
<script src="<?=base_url('assets/javascript/online.js')?>"></script>
