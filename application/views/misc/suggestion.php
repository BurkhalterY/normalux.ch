<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<?=isset($ok)?$this->lang->line('suggestion_thanks'):''?>
	<?=form_open_multipart()?>
		<h1><?=$title?></h1>
		<?=form_textarea('message', set_value('message'), array('placeholder' => $this->lang->line('suggestion_message')))?><br><br>
		<?=form_label($this->lang->line('suggestion_files'), 'files')?><br>
		<?=form_upload('files[]', null, array('id' => 'files', 'multiple' => 'multiple'))?><br><br>
		<?=form_submit('send', $this->lang->line('btn_send'), array('class' => 'button button-green'))?>
	<?=form_close()?>
	<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_ADMIN){ ?>
		<br><a href="<?=base_url('misc/suggestions')?>"><?=$this->lang->line('suggestions_admin')?></a>
	<?php } ?>
</article>
