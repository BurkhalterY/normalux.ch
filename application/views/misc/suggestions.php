<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<?php foreach ($suggestions as $suggestion) { ?>
		<fieldset>
			<legend><?=$suggestion->user->pseudo?></legend>
			<p><?=$suggestion->content?></p>
		</fieldset>
	<?php } ?>
</article>
