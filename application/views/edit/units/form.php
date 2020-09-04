<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
	<h1><?=$update?$this->lang->line('edition').' : '.$unit->unit:'Ajout d\'une unité'?></h1>
	<div class="col-md-6">
		<?=form_open('edit/unit_validation')?>
			<?=form_hidden('id', $update?$unit->id:set_value('id'))?>
			<div class="form-group">
				<div class="row">
					<div class="col-md-3"><?=form_label($this->lang->line('unit_no'), 'unit_no')?></div>
					<div class="col-md-3"><?=form_input('unit_no', $update?$unit->no:set_value('unit_no'), array('id' => 'unit_no', 'class' => 'form-control'))?></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-3"><?=form_label($this->lang->line('unit_name'), 'unit_name')?></div>
					<div class="col-md-9"><?=form_input('unit_name', $update?$unit->unit:set_value('unit_name'), array('id' => 'unit_name', 'class' => 'form-control'))?></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-6 offset-md-3"><?=form_submit('save', $this->lang->line('btn_save'), array('class' => 'btn btn-primary btn-block'))?></div>
					<div class="col-md-3"><?=form_submit('delete', '✖', array('class' => 'btn btn-danger btn-block'))?></div>
				</div>
			</div>
		<?=form_close()?>
	</div>
</div>
