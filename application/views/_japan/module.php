<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<?=form_open('japan/module_validation')?>
		<?=form_hidden('id', $update?$data->id:set_value('id'))?>
		<table style="margin: auto;">
			<tr><td><?=form_label($this->lang->line('numero'), 'no')?></td>
			<td><?=form_input('no', $update?$data->no:set_value('no'), array('id' => 'no', 'class' => 'field'))?></td></tr>
			<tr><td><?=form_label($this->lang->line('module'), 'module')?></td>
			<td><?=form_input('module', $update?$data->module:set_value('module'), array('id' => 'module', 'class' => 'field'))?></td></tr>
		</table>
		<?=form_submit('sumbit', $this->lang->line('btn_save_jp'), array('class' => 'field'))?>
	<?=form_close()?>
</article>
