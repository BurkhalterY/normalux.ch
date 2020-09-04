<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<?=form_open('japan/form_validation')?>
		<?=form_hidden('id', $update?$data->id:set_value('id'))?>
		<table style="margin: auto;">
			<tr><td><?=form_label($this->lang->line('french'), 'french')?></td>
			<td><?=form_input('french', $update?$data->french:set_value('french'), array('id' => 'french', 'class' => 'field'))?></td></tr>
			<tr><td><?=form_label($this->lang->line('kana'), 'kana')?></td>
			<td><?=form_input('kana', $update?$data->kana:set_value('kana'), array('id' => 'kana', 'class' => 'field'))?></td></tr>
			<tr><td><?=form_label($this->lang->line('kanji'), 'kanji')?></td>
			<td><?=form_input('kanji', $update?$data->kanji:set_value('kanji'), array('id' => 'kanji', 'class' => 'field'))?></td></tr>
		</table>
		<?=form_submit('sumbit', $this->lang->line('btn_save_jp'), array('class' => 'field'))?>
	<?=form_close()?>
</article>
