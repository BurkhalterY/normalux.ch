<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<article>
	<h1><?=$this->lang->line('words_selection')?></h1>
	<a href="<?=base_url('japan')?>"><?=$this->lang->line('btn_return')?></a>
	<table class="table-words">
		<tr>
			<th><?=$this->lang->line('unit_no')?></th>
			<th><?=$this->lang->line('unit_name')?></th>
			<th><a href="<?=base_url('japan/active/0/1')?>" class="btn btn-primary"><strong><?=$this->lang->line('activate_all')?></strong></a></th>
			<th><a href="<?=base_url('japan/active/0/-1')?>" class="btn btn-secondary"><strong><?=$this->lang->line('desactivate_all')?></strong></a></th>
		</tr>
		<?php foreach ($units as $unit) { ?>
			<tr id="unit-<?=$unit->id?>">
				<td><?=$unit->no?></td>
				<td><?=$unit->unit?></td>
				<td><a href="<?=base_url('japan/active/'.$unit->id.'/1')?>" class="btn btn-primary"><?=$this->lang->line('activate_all')?></a></td>
				<td><a href="<?=base_url('japan/active/'.$unit->id.'/-1')?>" class="btn btn-secondary"><?=$this->lang->line('desactivate_all')?></a></td>
			</tr>
		<?php } ?>
	</table>
	<table class="table-words">
		<tr>
			<th><?=$this->lang->line('french')?></th>
			<th><?=$this->lang->line('kana')?></th>
			<th><?=$this->lang->line('kanji')?></th>
			<th><?=$this->lang->line('unit')?></th>
			<th></th>
		</tr>
		<?php foreach ($units as $unit) {
			foreach ($unit->words as $word) {
				if($word->archive == 0) { ?>
					<tr id="word-<?=$word->id?>">
						<td><?=$word->french?></td>
						<td><?=$word->kana?></td>
						<td><?=$word->kanji?></td>
						<td title="<?=$unit->unit?>"><?=$unit->no?></td>
						<?php if($word->active){ ?>
							<td class="true"><a href="<?=base_url('japan/active/'.$word->id)?>" class="btn btn-primary"><?=$this->lang->line('activate')?></a></td>
						<?php } else { ?>
							<td class="false"><a href="<?=base_url('japan/active/'.$word->id)?>" class="btn btn-secondary"><?=$this->lang->line('desactivate')?></a></td>
						<?php } ?>
					</tr>
		<?php } } } ?>
	</table>
</article>