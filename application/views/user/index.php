<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<div class="top-select">
		<?=$this->lang->line('page')?>
		<?php for($i = 1; $i <= $nb_pages; $i++){
			if($i == $page){
				echo $i;
			} else { ?>
				<a href="<?=base_url('user/index/'.$user->id.'/'.$i)?>"><?=$i?></a>
			<?php } ?>
			<?=$i%50==0?'<br>':''?>
		<?php } ?>
		<?php if($_SESSION['user_id'] == $user->id){
			echo '<a href="'.base_url('user/settings').'"><i class="fas fa-cog settings"></i></a>';
		}?>
	</div>

	<?php foreach ($drawings as $drawing) { ?>
		<div class="gallery">
			<a href="<?=base_url('gallery/details/'.$drawing->id)?>"><img src="<?=base_url('medias/drawings/'.$drawing->file)?>" alt="<?=$drawing->file?>"></a>
			<div class="desc"><?=$drawing->pseudo?><br><?=$drawing->date_drawing?></div>
		</div>
	<?php } ?>

</article>
