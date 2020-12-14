<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<?=form_open()?>
		<table>
			<tr>
				<th><?=$this->lang->line('word')?></th>
				<th><?=$this->lang->line('theme')?></th>
				<th></th>
			</tr>
			<?php foreach ($entries as $entry) { ?>
				<tr>
					<td><?=$entry->word->word?></td>
					<td><?=$entry->theme->theme?></td>
					<td><?=form_checkbox('validate['.$entry->id.']')?></td>
				</tr>
			<?php } ?>
		</table>
		<?=form_submit('post', $this->lang->line('btn_confirm'))?>
	<?=form_close()?>
</article>
<script>
	function checkAll(checked){
		let checkboxes = document.querySelectorAll('input[type="checkbox"]');
		for (let i = 0; i < checkboxes.length; i++) {
			checkboxes[i].checked = checked;
		}
	}
</script>