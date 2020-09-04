<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<ul style="float: right; text-align: left;">
		<?php foreach ($modules as $module) { ?>
			<li><a href="<?=base_url('japan/module/'.$module->id)?>"><?=$module->module?></a></li>
		<?php } ?>
	</ul>
	<table>
		<tr>
			<th><?=$this->lang->line('french')?></th>
			<th><?=$this->lang->line('kana')?></th>
			<th><?=$this->lang->line('kanji')?></th>
			<th><a href="<?=base_url('japan')?>" style="float: left;"><?=$this->lang->line('btn_return')?></a></th>
		</tr>
		<?php foreach ($data as $row) { ?>
			<tr>
				<td><?=$row->french?></td>
				<td><?=$row->kana?></td>
				<td><?=$row->kanji?></td>
				<td>
					<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_ADMIN){ ?>
						<a href="<?=base_url('japan/form/'.$row->id)?>">🖍</a>
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
		<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_ADMIN){ ?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td><a href="<?=base_url('japan/form')?>">+</a><td>
			</tr>
		<?php } ?>
	</table>
</article>
