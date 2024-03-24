<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<div class="error">
		<img src="<?=base_url('assets/images/'.$error.'.png')?>" alt="<?=$title?>"/>
		<h1><?=$this->lang->line('error_message')[$error]?></h1>
	</div>
</article>