<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<div>
		<img id="model" src="<?=base_url('medias/drawings/'.$drawing->file)?>" alt="<?=$drawing->pseudo?>" width="400" height="400">
	</div>
	<div class="comment">
		<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_MODO){ ?>
			<a href="javascript:deleteDrawing(<?=$drawing->id?>)">[x]</a>
		<?php } ?>
		<table style="width:100%">
			<tr>
				<th><?=$this->lang->line('table_mode')?></th>
				<td>
					<?php switch ($drawing->type) {
						case NORMAL_MODE:
							echo $this->lang->line('normal_mode');
							break;
						case CHAIN_MODE:
							echo $this->lang->line('chain_mode');
							break;
						case PROFILE_PICTURE:
							echo $this->lang->line('profile_picture');
							break;
						case ROTATION_MODE:
							echo $this->lang->line('rotation_mode');
							break;
						case BLINDED_MODE:
							echo $this->lang->line('blind_mode');
							break;
						case PIXEL_ART_MODE:
							echo $this->lang->line('pixel_art_mode');
							break;
						case INFINITY_MODE:
							echo $this->lang->line('unlimited_mode');
							break;
						case 8:
							echo $this->lang->line('unlimited_pixel_art');
							break;
						case 9:
							echo $this->lang->line('zoom_mode');
							break;
						case 10:
							echo $this->lang->line('wtf_mode');
							break;
						default:
							echo $this->lang->line('unknown');
							break;
					} ?>
				</td>
				<td rowspan="5" style="text-align: right;">
					<a href="<?=base_url('gallery/like/'.$drawing->id)?>"><img src="<?=base_url('assets/images/thumb.png')?>" alt="Like"/></a>
				</td>
				<td rowspan="5">
					<?=$likes?>
				</td>
			</tr>
			<tr>
				<th><?=$this->lang->line('table_picture')?></th>
				<td>
					<?php if(isset($drawing->picture->title)){?>
						<a href="<?=base_url('gallery/index/'.$drawing->type.'/'.$drawing->picture->id)?>">
							<?=$drawing->picture->title?>
						</a>
					<?php }else{ ?>
						<i>'.$this->lang->line('no_model').'</i>'?>
					<?php }?>
				</td>
			</tr>
			<tr>
				<th><?=$this->lang->line('table_user')?></th>
				<td><?=$drawing->pseudo?></td>
			</tr>
			<tr>
				<th><?=$this->lang->line('table_date')?></th>
				<td><?=$drawing->date_drawing?></td>
			</tr>
			<tr>
				<td colspan="2">
					<?php
						if(!is_null($drawing->json)){
							echo '<a href="'.base_url('gallery/replay/'.$drawing->id).'">'.$this->lang->line('live_route').'</a>';
						}
					?>
				</td>
			</tr>
			<?php if($drawing->deleted){ ?>
				<tr><td colspan="4" style="color: red;"><b><?=$this->lang->line('censored_drawing')?></b></td></tr>
			<?php } ?>
		</table>
	</div>

	<hr class="line">

	<?php foreach ($comments as $comment) { ?>
		<div class="comment">
			<h5 class="date"><?=$comment->date_post?></h5>
			<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_MODO){ ?>
				<a href="javascript:deleteComment(<?=$comment->id?>)">[x]</a>
			<?php } ?>
			<h3><?=$comment->pseudo?></h3>
			<p><?=$comment->message?></p>
		</div>
	<?php } ?>

	<div class="comment">
		<?=form_open('gallery/comment/'.$drawing->id, array('style' => 'text-align:center;'))?>
			<h3><?=form_label($this->lang->line('message'), 'message')?></h3>
			<?=form_label($this->lang->line('pseudo'), 'pseudo')?>
			<?=form_input('pseudo', set_value('pseudo'), array('id' => 'pseudo', 'class' => 'field', 'required' => ''))?>
			<?=form_textarea('message', set_value('message'), array('required' => '', 'style' => 'width: 99%; height:80px;'))?>
			<br><br>
			<?=form_submit('send', $this->lang->line('btn_send'))?>
			<br><br>
		<?=form_close()?>
	</div>

	<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_MODO){ ?>
		<script>
			function deleteComment(id) {
				var r = confirm("<?=$this->lang->line('delete_comment')?>");
				if (r == true) {
					window.location.href = "<?=base_url('modo/comment/')?>"+id;
				}
			}
			function deleteDrawing(id) {
				var r = confirm("<?=$this->lang->line('delete_drawing')?>");
				if (r == true) {
					window.location.href = "<?=base_url('modo/drawing/')?>"+id;
				}
			}
		</script>
	<?php } ?>
</article>