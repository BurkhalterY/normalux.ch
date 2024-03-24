<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article class="gallery">
	<div class="top-bar">
		<?php if(isset($mode)){ ?>
			<a href="<?=base_url('play/index/'.$mode)?>"><?=$this->lang->line('replay')?></a>
			<?=$mode==CHAIN_MODE?' | <a href="'.base_url('gallery/story').'">'.$this->lang->line('story').'</a>':''?>
			| <?=$this->lang->line('picture')?>
			<select onchange="location.href=this.value">
				<option value="<?=base_url('gallery/index/'.$mode)?>" selected disabled hidden ></option>
				<?php foreach ($pictures as $picture) { ?>
					<option value="<?=base_url('gallery/index/'.$mode.'/'.$picture->id)?>"><?=$picture->title?></option>
				<?php } ?>
			</select><br><br>
		<?php } ?>

		<?=$this->lang->line('page')?>
		<?php for($i = 1; $i <= $nb_pages; $i++){
			if($i == $page){
				echo $i;
			} else { 
				if(isset($censored)){ ?>
					<a href="<?=base_url('gallery/censored/'.$i)?>"><?=$i?></a>
				<?php } else { ?>
					<a href="<?=base_url('gallery/index/'.$mode.'/'.$picture_id.'/'.$i)?>"><?=$i?></a>
				<?php } ?>
			<?php } ?>
			<?=$i%50==0?'<br>':''?>
		<?php } ?>
	</div>

	<?php foreach ($drawings as $drawing) { ?>
		<div class="case">
			<?php if(isset($drawing->pseudo)){ ?>
				<?php if(isset($censored)){ ?>
					<a href="<?=base_url('gallery/details/'.$drawing->id)?>"><img src="<?=base_url('medias/drawings/'.$drawing->file)?>" alt="<?=$drawing->file?>"></a>
				<?php } else { ?>
					<a href="<?=$picture_id!=0?base_url('gallery/details/'.$drawing->id):base_url('gallery/index/'.$mode.'/'.$drawing->fk_picture)?>"><img src="<?=base_url('medias/drawings/'.$drawing->file)?>" alt="<?=$drawing->file?>"></a>
				<?php } ?>
				<div class="desc"><?=$drawing->pseudo?><br><small><?=$drawing->date_drawing?></small></div>
			<?php } else { ?>
				<img src="<?=base_url('medias/pictures/'.$drawing->file)?>" alt="<?=$drawing->file?>">
				<div class="desc"><?=$drawing->title?></div>
			<?php } ?>
		</div>
	<?php } ?>
</article>
