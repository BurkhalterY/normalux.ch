<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<nav class="sidebar">
		<ul>
			<li class="sidebar"><a href="https://www.youtube.com/channel/UCbv1uNvn53SHwSSY19luZvQ" target="_blank"><span style="color: #C4302B; font-size: 24px;"><i class="fab fa-youtube"></i></span></a></li>
			<li class="sidebar"><a href="https://discord.gg/z67yZjh" target="_blank"><span style="color: #7289DA; font-size: 24px;"><i class="fab fa-discord"></i></span></a></li>
		</ul>
	</nav>

	<p><?=$this->lang->line('contact_text')?></p>
	<a href="mailto:info@normalux.ch">info@normalux.ch</a>
	<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){ ?>
		<p><?=$this->lang->line('suggestion_link')[0]?><a href="<?=base_url('misc/suggestion')?>"><?=$this->lang->line('suggestion_link')[1]?></a></p>
	<?php } ?>
</article>
