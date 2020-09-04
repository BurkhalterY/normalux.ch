<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
	<h1>Édition des unités</h1>
	<table class="table table-striped">
		<tr>
			<th><?=$this->lang->line('unit_no')?></th>
			<th><?=$this->lang->line('unit_name')?></th>
			<th><a href="<?=base_url('edit/unit_form')?>"><?=$this->lang->line('btn_add')?></a></th>
		</tr>
		<?php foreach ($units as $unit) { ?>
			<tr id="unit-<?=$unit->id?>">
				<td><?=$unit->no?></td>
				<td><?=$unit->unit?></td>
				<td><a href="<?=base_url('edit/unit_form/'.$unit->id)?>"><?=$this->lang->line('btn_update')?></a></td>
			</tr>
		<?php } ?>
	</table>
</div>