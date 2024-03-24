<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<table>
		<?php foreach ($pictures as $picture) { ?>
			<tr>
				<td>
					<div class="case">
						<a href="<?=base_url('gallery/index/2/'.$picture->id)?>"><img src="<?=base_url('medias/pictures/'.$picture->file)?>" alt="<?=$picture->title?>" width="400" height="400"></a>
						<div class="desc"><strong><?=$picture->title?></strong></div>
					</div>
				</td>
				<td width="100%"><p style="text-align: center;"><?=$picture->count?></p><hr class="arrow"></td><td>
					<?php if(isset($picture->drawing)){ ?>
						<div class="case">
							<a href="<?=base_url('gallery/details/'.$picture->drawing->id)?>"><img src="<?=base_url('medias/drawings/'.$picture->drawing->file)?>" alt="<?=$picture->drawing->pseudo?>" width="400" height="400"></a>
							<div class="desc"><?=$picture->drawing->pseudo?><br><?=$picture->drawing->date_drawing?></div>
						</div>
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
	</table>
</article>