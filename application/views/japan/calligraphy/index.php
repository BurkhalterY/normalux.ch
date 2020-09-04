<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1 id="s"><?=$word->french?></h1>
<canvas id="canvas" width="400" height="400"></canvas>

<form action="<?=base_url('japan/post/'.$word->id)?>" method="post" id="form">
	<input type="hidden" name="image" id="image">
	<input type="hidden" name="json" id="json">
	<input type="button" id="save" value="<?=$this->lang->line('btn_validate')?>" onclick="validate()">
	<input type="button" id="reset" class="button" value="<?=$this->lang->line('btn_reset')?>" onclick="resetCanvas()">
</form>

<script src="<?=base_url('assets/javascript/japan.js')?>"></script>