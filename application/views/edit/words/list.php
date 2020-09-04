<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="container">
	<h1>Édition des mots</h1>
	<table class="table table-striped">
		<tr>
			<th><?=$this->lang->line('word_french')?></th>
			<th><?=$this->lang->line('word_kana')?></th>
			<th><?=$this->lang->line('word_kanji')?></th>
			<th><?=$this->lang->line('word_unit')?></th>
			<th><a href="<?=base_url('edit/word_form')?>"><?=$this->lang->line('btn_add')?></a></th>
		</tr>
		<?php foreach ($words as $word) { ?>
			<tr id="word-<?=$word->id?>">
				<td><?=$word->french?></td>
				<td><?=$word->kana?></td>
				<td><?=$word->kanji?></td>
				<td title="<?=$word->unit->unit?>"><?=$word->unit->no?></td>
				<td><a href="<?=base_url('edit/word_form/'.$word->id)?>"><?=$this->lang->line('btn_update')?></a></td>
			</tr>
		<?php } ?>
	</table>
</div>