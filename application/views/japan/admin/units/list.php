<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<article>
	<h1><?=$this->lang->line('units_edition')?></h1>
	<a href="<?=base_url('japan')?>"><?=$this->lang->line('btn_return')?></a>
	<table>
		<tr>
			<th><?=$this->lang->line('unit_no')?></th>
			<th><?=$this->lang->line('unit_name')?></th>
			<th><a href="<?=base_url('japan_admin/unit_form')?>"><?=$this->lang->line('btn_add')?></a></th>
		</tr>
		<?php foreach ($units as $unit) { ?>
			<tr id="unit-<?=$unit->id?>">
				<td><?=$unit->no?></td>
				<td><?=$unit->unit?></td>
				<td><a href="<?=base_url('japan_admin/unit_form/'.$unit->id)?>"><?=$this->lang->line('btn_update')?></a></td>
				<td><a target="_blank" href="<?=base_url('japan_admin/export/'.$unit->id)?>"><?=$this->lang->line('btn_export')?></a></td>
			</tr>
		<?php } ?>
	</table>
</article>