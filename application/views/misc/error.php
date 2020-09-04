<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<img src="<?=base_url('assets/images/'.$error.'.png')?>" alt="<?=$title?>" class="error" />
	<h1><?=$this->lang->line('error_message')[$error]?></h1>
</article>