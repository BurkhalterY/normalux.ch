<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<?=form_open('multi/propose_themes')?>
		<?=form_label($this->lang->line('words'), 'words')?><br>
		<?=form_textarea('words', null, array('id' => 'words', 'placeholder' => $this->lang->line('words_placeholder')))?>
		<br>
		<?=form_submit('post', $this->lang->line('btn_submit'))?><br>
	<?=form_close()?>
</article>
