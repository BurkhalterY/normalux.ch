<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<article>
	<?=form_open('japan_admin/word_validation')?>
		<?=form_hidden('id', $update?$word->id:set_value('id'))?>
		<table>
			<tr><th colspan="2"><?=$update?$this->lang->line('edition').' : '.$word->french:$this->lang->line('add_word')?></th></tr>
			<tr>
				<td><?=form_label($this->lang->line('french'), 'french')?></td>
				<td><?=form_input('french', $update?$word->french:set_value('french'), array('id' => 'french'))?></td>
			</tr>
			<tr>
				<td><?=form_label($this->lang->line('kana'), 'kana')?></td>
				<td><?=form_input('kana', $update?$word->kana:set_value('kana'), array('id' => 'kana'))?></td>
			</tr>
			<tr>
				<td><?=form_label($this->lang->line('kanji'), 'kanji')?></td>
				<td><?=form_input('kanji', $update?$word->kanji:set_value('kanji'), array('id' => 'kanji'))?></td>
			</tr>
			<tr>
				<td><?=form_label($this->lang->line('unit'), 'unit')?></td>
				<td><?=form_dropdown('unit', $units, $update?$word->fk_unit:set_value('unit'), array('id' => 'unit'))?></td>
			</tr>
			<tr>
				<td><?=form_submit('save', $this->lang->line('btn_save'))?></td>
				<td><?=form_submit('delete', '✖')?></td>
			</tr>
		</table>
	<?=form_close()?>
</article>