<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<?=form_open('multi/propose_finale')?>
		<table>	
			<?php foreach ($words as $word) { ?>
				<tr>
					<td><?=form_label($word->word, 'words['.$word->id.']')?></td>
					<td><?=form_input('words['.$word->id.']', '', array('id' => 'words['.$word->id.']', 'size' => 50))?></td>
				</tr>
			<?php } ?>
			<?=form_submit('post', $this->lang->line('btn_submit'))?><br>
		</table>
	<?=form_close()?>
	<div>
		<h4><?=$this->lang->line('themes_list')?></h4>
		<?php foreach ($themes as $theme) {
			echo $theme->theme.'<br>';
		} ?>
	</div>
</article>