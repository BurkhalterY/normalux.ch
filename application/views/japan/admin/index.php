<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<article>
	<h1><?=$this->lang->line('edit')?></h1>
	<a href="<?=base_url('japan')?>"><?=$this->lang->line('btn_return')?></a>
	<h2><a href="<?=base_url('japan_admin/units_list')?>"><?=$this->lang->line('units')?> 🖍️</a></h2>
	<h2><a href="<?=base_url('japan_admin/words_list')?>"><?=$this->lang->line('words')?> 🖍️</a></h2>
	<br>
	<h2><?=$this->lang->line('import')?></h2>
	<form action="<?=base_url('japan_admin/import');?>" method="post">
		<textarea name="field"></textarea><br>
		<input type="submit">
	</form>
</article>