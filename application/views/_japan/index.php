<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<a href="<?=base_url('japan/train')?>" class="button button-green"><?=$this->lang->line('btn_train')?></a>

	<br><br>
	<a href="<?=base_url('japan/list')?>">🖍</a><br>

	<div class="top-select">
		<?php
		$sum = 0;
		foreach ($prec as $element) {
			$sum += $element->correct;
		}
		$moy = round($sum / count($prec) * 100); ?>
		<h3><?=$moy?>%</h3>
		<?=$this->lang->line('page')?>
		<?php for($i = 1; $i <= $nb_pages; $i++){
			if($i == $page){
				echo $i;
			} else { ?>
				<a href="<?=base_url('japan/index/'.$i)?>"><?=$i?></a>
			<?php } ?>
			<?=$i%50==0?'<br>':''?>
		<?php } ?>
	</div>
	<?php foreach ($prec as $element) { ?>
		<div class="gallery <?=is_null($element->correct) ?'': ($element->correct == 1 ?'true':'false')?>">
			<a href="<?=base_url('japan/validate/'.$element->id)?>"><img src="<?=base_url('medias/drawings/'.$element->file)?>" alt="<?=$element->file?>">
			<hr>
			<div class="desc" style="line-height: 1.2;"><?=$element->japan->kanji?><br><?=$element->japan->kana?></div>
		</div>
	<?php } ?>
</article>
