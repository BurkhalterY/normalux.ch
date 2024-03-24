<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<?=form_open('play/draw/'.$mode)?>
		<?=form_submit('play', $this->lang->line('play'), array('class' => get_css_color($mode)))?><br>
		<br>
		<?=form_label($this->lang->line('pseudo'), 'pseudo')?><br>
		<?=form_input('pseudo', $this->session->pseudo, array('id' => 'pseudo'))?>

		<?php if($mode == INFINITY_MODE){
			echo '<br><br>'.$this->lang->line('model').'<br>'.form_dropdown('model', $models);
		} ?>
	<?=form_close()?>
</article>

<?php

function get_css_color($mode){
	switch($mode){
		case NORMAL_MODE: return 'button button-green';
		case CHAIN_MODE: return 'button button-red';
		case ROTATION_MODE: return 'button button-purple';
		case PIXEL_ART_MODE: return 'button button-black';
		case BLINDED_MODE: return '';
		case INFINITY_MODE: return 'button button-sayan';
		default: return 'button button-green';
	}
}

?>