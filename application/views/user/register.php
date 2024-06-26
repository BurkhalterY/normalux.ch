<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<h1><?=$this->lang->line('register')?></h1>

	<?php if(isset($message)){ ?>
		<p class="alert"><?=$message?></p><br>
	<?php } ?>

	<?=form_open()?>
		<?=form_label($this->lang->line('pseudo'), 'pseudo')?><br>
		<?=form_input('pseudo', set_value('pseudo'), array('id' => 'pseudo', 'class' => 'field'))?><br><br>
		<?=form_label($this->lang->line('email'), 'email')?><br>
		<?php $email = array(
			'type'	=> 'email',
			'name'	=> 'email',
			'value'	=> set_value('email'),
			'id'	=> 'email',
			'class'	=> 'field',
			'placeholder' => $this->lang->line('optional')
		); ?>
		<?=form_input($email)?><br>
		<?=form_label($this->lang->line('password'), 'password')?><br>
		<?=form_password('password', '', array('id' => 'password', 'class' => 'field'))?><br><br>
		<?=form_label($this->lang->line('passconf'), 'passconf')?><br>
		<?=form_password('passconf', '', array('id' => 'passconf', 'class' => 'field'))?><br><br>

		<?=form_submit('register', $this->lang->line('register'), array('class' => 'field'))?>
	<?=form_close()?>
</article>
