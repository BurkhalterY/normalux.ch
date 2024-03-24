<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<img id="model" src="<?=base_url('medias/drawings/'.$drawing->file)?>" alt="<?=$drawing->pseudo?>" width="400" height="400">
	<div class="comments">
		<div>
			<table>
				<tr>
					<th><?=$this->lang->line('mode')?></th>
					<td><a href="<?=base_url('play/index/'.$drawing->type)?>"><?=$drawing->mode?></a></td>
					<td rowspan="5" style="text-align: right; font-size: 300%;">
						<a href="<?=base_url('gallery/like/'.$drawing->id)?>">👍</a>
					</td>
					<td rowspan="5" style="text-align: center; font-size: 250%;"><?=$likes?></td>
				</tr>
				<tr>
					<th><?=$this->lang->line('picture')?></th>
					<td>
						<?php if(isset($drawing->picture->title)){?>
							<a href="<?=base_url('gallery/index/'.$drawing->type.'/'.$drawing->picture->id)?>"><?=$drawing->picture->title?></a>
						<?php }else{ ?>
							<i><?=$this->lang->line('no_model')?></i>
						<?php }?>
					</td>
				</tr>
				<tr>
					<th><?=$this->lang->line('user')?></th>
					<td><?=$drawing->pseudo?></td>
				</tr>
				<tr>
					<th><?=$this->lang->line('date')?></th>
					<td><?=$drawing->date_drawing?></td>
				</tr>
				<?php if(!is_null($drawing->json)){ ?>
					<tr>
						<td colspan="2">
							<?='<a href="'.base_url('gallery/replay/'.$drawing->id).'">'.$this->lang->line('live_replay').'</a>'?>
						</td>
					</tr>
				<?php } ?>
				<?php if($drawing->deleted){ ?>
					<tr><td colspan="4" class="text-red"><b><?=$this->lang->line('is_censored')?></b></td></tr>
				<?php } ?>
				<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_MODO){ ?>
					<tr><td colspan="4">
						<?php if(!$drawing->deleted){ ?><a href="javascript:deleteDrawing(<?=$drawing->id?>)" class="text-red"><?=$this->lang->line('delete')?></a><?php }
											else { ?><a href="javascript:undeleteDrawing(<?=$drawing->id?>)" class="text-green"><?=$this->lang->line('undelete')?></a><?php } ?>
					</td></tr>
				<?php } ?>
			</table>
		</div>

		<hr>

		<?php foreach ($comments as $comment) { ?>
			<div <?=$comment->deleted?'class="deleted"':''?>>
				<h5><?=$comment->date_post?></h5>
				<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_MODO){ ?>
					<?php if(!$comment->deleted){ ?><a href="javascript:deleteComment(<?=$comment->id?>)" class="text-red"><?=$this->lang->line('delete')?></a><?php }
										else { ?><a href="javascript:undeleteComment(<?=$comment->id?>)" class="text-green"><?=$this->lang->line('undelete')?></a><?php } ?>
				<?php } ?>
				<h3><?=$comment->pseudo?></h3>
				<p><?=$comment->message?></p>
			</div>
		<?php } ?>

		<?=form_open('gallery/comment/'.$drawing->id)?>
			<h3><?=form_label($this->lang->line('new_comment'), 'message')?></h3>
			<?=form_label($this->lang->line('pseudo'), 'pseudo')?>
			<?=form_input('pseudo', set_value('pseudo'), array('id' => 'pseudo', 'class' => 'field', 'required' => ''))?>
			<?=form_textarea('message', set_value('message'), array('required' => ''))?>
			<br><br>
			<?=form_submit('send', $this->lang->line('send'), array('class' => 'field'))?>
			<br><br>
		<?=form_close()?>
	</div>
</article>

<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_MODO){ ?>
	<script>
		function deleteDrawing(id) {
			var r = confirm("<?=$this->lang->line('delete_drawing')?>");
			if (r == true) {
				window.location.href = "<?=base_url('modo/drawing/')?>"+id;
			}
		}
		function undeleteDrawing(id) {
			var r = confirm("<?=$this->lang->line('undelete_drawing')?>");
			if (r == true) {
				window.location.href = "<?=base_url('modo/drawing/')?>"+id+"/0";
			}
		}
		function deleteComment(id) {
			var r = confirm("<?=$this->lang->line('delete_comment')?>");
			if (r == true) {
				window.location.href = "<?=base_url('modo/comment/')?>"+id;
			}
		}
		function undeleteComment(id) {
			var r = confirm("<?=$this->lang->line('undelete_comment')?>");
			if (r == true) {
				window.location.href = "<?=base_url('modo/comment/')?>"+id+"/0";
			}
		}
	</script>
<?php } ?>
