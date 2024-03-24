<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<h1><?=$this->lang->line('login')?></h1>

	<?php if(isset($message)){ ?>
		<p class="alert"><?=$message?></p><br>
	<?php } ?>

	<?=form_open()?>
		<?=form_label($this->lang->line('pseudo'), 'pseudo')?><br>
		<?=form_input('pseudo', set_value('pseudo'), array('id' => 'pseudo', 'class' => 'field'))?><br><br>
		<?=form_label($this->lang->line('password'), 'password')?><br>
		<?=form_password('password', '', array('id' => 'password', 'class' => 'field'))?><br><br>

		<?=form_submit('login', $this->lang->line('login'), array('class' => 'field'))?>
	<?=form_close()?>
</article>
