<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<article>
	<h1><?=$this->lang->line('words_edition')?></h1>
	<a href="<?=base_url('japan')?>"><?=$this->lang->line('btn_return')?></a>
	<table>
		<tr>
			<th><?=$this->lang->line('french')?></th>
			<th><?=$this->lang->line('kana')?></th>
			<th><?=$this->lang->line('kanji')?></th>
			<th><?=$this->lang->line('unit')?></th>
			<th><a href="<?=base_url('japan_admin/word_form')?>"><?=$this->lang->line('btn_add')?></a></th>
		</tr>
		<?php foreach ($units as $unit) { ?>
			<?php foreach ($unit->words as $word) {
				if($word->archive == 0) { ?>
					<tr id="word-<?=$word->id?>">
						<td><?=$word->french?></td>
						<td><?=$word->kana?></td>
						<td><?=$word->kanji?></td>
						<td title="<?=$unit->unit?>"><?=$unit->no?></td>
						<td><a href="<?=base_url('japan_admin/word_form/'.$word->id)?>"><?=$this->lang->line('btn_update')?></a></td>
					</tr>
		<?php } } } ?>
	</table>
</article>