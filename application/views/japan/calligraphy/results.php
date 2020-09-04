<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<article>
	<div class="top-select"><strong><a href="<?=base_url('japan/calligraphy')?>"><?=$this->lang->line('btn_restart')?></a></strong><br><br><a href="<?=base_url('japan')?>"><?=$this->lang->line('btn_return')?></a><br><br><?=$moy?></div>
	<?php foreach ($tracings as $tracing) { ?>
		<div class="gallery <?=is_null($tracing->correct) ?'': ($tracing->correct == 1 ?'true':'false')?>" title="<?=$tracing->french?>">
			<a href="<?=base_url('japan/validate/'.$tracing->id)?>"><img src="<?=base_url('medias/drawings/'.$tracing->filename)?>" alt="<?=$tracing->filename?>"></a>
			<hr>
			<div class="desc" style="line-height: 1.2;"><?=$tracing->kanji?>&nbsp;<br><?=$tracing->kana?>&nbsp;</div>
		</div>
	<?php } ?>
</article>