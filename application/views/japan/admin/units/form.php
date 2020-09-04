<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<article>
	<?=form_open('japan_admin/unit_validation')?>
		<?=form_hidden('id', $update?$unit->id:set_value('id'))?>
		<table>
			<tr><th colspan="2"><?=$update?$this->lang->line('edition').' : '.$unit->unit:$this->lang->line('add_unit')?></th></tr>
			<tr>
				<td><?=form_label($this->lang->line('unit_no'), 'unit_no')?></td>
				<td><?=form_input('unit_no', $update?$unit->no:set_value('unit_no'), array('id' => 'unit_no'))?></td>
			</tr>
			<tr>
				<td><?=form_label($this->lang->line('unit_name'), 'unit_name')?></td>
				<td><?=form_input('unit_name', $update?$unit->unit:set_value('unit_name'), array('id' => 'unit_name'))?></td>
			</tr>
			<tr>
				<td><?=form_submit('save', $this->lang->line('btn_save'))?></td>
				<td><?=form_submit('delete', '✖')?></td>
			</tr>
		</table>
	<?=form_close()?>
</article>