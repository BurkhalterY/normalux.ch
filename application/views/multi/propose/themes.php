<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<?=form_open('multi/propose_finale')?>
		<?=form_label($this->lang->line('common_theme'), 'common_theme')?>
		<?=form_input('common_theme', '', array('id' => 'common_theme', 'size' => 50))?>
		<table>
			<?php foreach ($words as $word) { ?>
				<tr>
					<td><?=form_label($word->word, 'words['.$word->id.']')?></td>
					<td><?=form_input('words['.$word->id.']', '', array('id' => 'words['.$word->id.']', 'size' => 50))?></td>
				</tr>
			<?php } ?>
			<?=form_submit('post', $this->lang->line('btn_submit'))?>
		</table>
	<?=form_close()?>
	<div>
		<h4><?=$this->lang->line('themes_list')?></h4>
		<?php foreach ($themes as $theme) {
			echo $theme->theme.'<br>';
		} ?>
	</div>
</article>