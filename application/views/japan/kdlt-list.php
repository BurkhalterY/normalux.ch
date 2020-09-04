<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<article style="text-align: justify; margin-right: 10px;">
	<a href="https://maniette.fr/">https://maniette.fr/</a>	
	<br><br>
	<table>
		<tr>
			<th><?=$this->lang->line('kdlt_chapter')?></th>
			<th><?=$this->lang->line('kdlt_number')?></th>
			<th><?=$this->lang->line('kdlt_kanji')?></th>
			<th><?=$this->lang->line('kdlt_keyword')?></th>
		</tr>
		<?php foreach($list as $item){ ?>
			<tr>
				<td><?=$item->chapter?></td>
				<td><a href="<?=base_url('japan/kdlt/'.$item->id)?>"><?=$item->no_kdlt?></a></td>
				<td><?=$item->kanji?></td>
				<td><?=$item->keyword?></td>
			</tr>
		<?php } ?>
	</table>
</article>