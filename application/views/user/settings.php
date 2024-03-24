<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<h2><?=$this->lang->line('change_password')?></h2>

	<?php if(isset($message)){ ?>
		<p class="alert <?=isset($success)?'success':''?>"><?=$message?></p>
	<?php } ?>

	<?=form_open()?>
		<?=form_label($this->lang->line('old_password'), 'old_password')?><br>
		<?=form_password('old_password', '', array('id' => 'old_password', 'class' => 'field'))?><br><br>
		<?=form_label($this->lang->line('new_password'), 'new_password')?><br>
		<?=form_password('new_password', '', array('id' => 'new_password', 'class' => 'field'))?><br><br>
		<?=form_label($this->lang->line('passconf'), 'passconf')?><br>
		<?=form_password('passconf', '', array('id' => 'passconf', 'class' => 'field'))?><br><br>

		<?=form_submit('submit', $this->lang->line('confirm'), array('class' => 'field'))?>
	<?=form_close()?>
</article>
