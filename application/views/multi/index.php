<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<?=form_open('multi/room/')?>
		<?=form_submit('join', $this->lang->line('btn_join'), array('class' => 'button button-blue'))?><br>
		<br>
		<?=form_label($this->lang->line('pseudo'), 'pseudo')?><br>
		<?=form_input('pseudo', $this->session->pseudo, array('id' => 'pseudo'))?>

		<br><br>
		<?=$this->lang->line('room_code')?>
		<?=form_input('room_code', $this->session->room_code, array('id' => 'room_code', 'class' => 'field'))?>
	<?=form_close()?>
</article>
