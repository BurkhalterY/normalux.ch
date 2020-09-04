<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
	<h1><?=$update?$this->lang->line('edition').' : '.$word->french:'Ajout d\'un mot'?></h1>
	<div class="col-md-6">
		<?=form_open('edit/word_validation')?>
			<?=form_hidden('id', $update?$word->id:set_value('id'))?>
			<div class="form-group">
				<div class="row">
					<div class="col-md-3"><?=form_label($this->lang->line('word_french'), 'word_french')?></div>
					<div class="col-md-9"><?=form_input('word_french', $update?$word->french:set_value('word_french'), array('id' => 'word_french', 'class' => 'form-control'))?></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-3"><?=form_label($this->lang->line('word_kana'), 'word_kana')?></div>
					<div class="col-md-9"><?=form_input('word_kana', $update?$word->kana:set_value('word_kana'), array('id' => 'word_kana', 'class' => 'form-control'))?></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-3"><?=form_label($this->lang->line('word_kanji'), 'word_kanji')?></div>
					<div class="col-md-9"><?=form_input('word_kanji', $update?$word->kanji:set_value('word_kanji'), array('id' => 'word_kanji', 'class' => 'form-control'))?></div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-3"><?=form_label($this->lang->line('word_unit'), 'word_unit')?></div>
					<div class="col-md-9"><?=form_dropdown('word_unit', $units, $update?$word->fk_unit:set_value('word_unit'), array('id' => 'word_unit', 'class' => 'form-control'))?></div>
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
