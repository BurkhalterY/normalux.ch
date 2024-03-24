<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<?=form_open('play/draw/'.$mode)?>
		<?=form_submit('play', $this->lang->line('play'), array('class' => 'button '.get_css_class($mode)))?><br>
		<br>
		<?=form_label($this->lang->line('pseudo'), 'pseudo')?><br>
		<?=form_input('pseudo', $this->session->pseudo, array('id' => 'pseudo', 'class' => 'field'))?>

		<?php if($mode == INFINITY_MODE){
			echo $this->lang->line('model').'<br>'.form_dropdown('model', $models, array(), array('class' => 'field'));
		} ?>
	<?=form_close()?>
</article>

<?php

function get_css_class($mode){
	switch($mode){
		case NORMAL_MODE: return 'button-green';
		case CHAIN_MODE: return 'button-red';
		case ROTATION_MODE: return 'button-purple';
		case PIXEL_ART_MODE: return 'button-black';
		case BLINDED_MODE: return '';
		case INFINITY_MODE: return 'button-sayan';
		default: return 'button-green';
	}
}

?>