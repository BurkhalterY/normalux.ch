<?php defined('BASEPATH') OR exit('No direct script access allowed');

Global $uri;
$uri = $this->uri;

function check_active($p1 = '', $p2 = '', $p3 = '1'){
	global $uri;
	return $uri->segment(1, 'play') == $p1 && $uri->segment(2, 'index') == $p2 && $uri->segment(3, '1') == $p3;
}

?>
<nav>
	<ul>
		<li><a <?=check_active('play', 'index', '1')?'class="active green"':''?> href="<?=base_url()?>"><?=$this->lang->line('normal_mode')?></a></li>
		<li><a <?=check_active('gallery', 'index', '1')?'class="active green"':''?> href="<?=base_url('gallery')?>"><?=$this->lang->line('gallery')?></a></li>
		<br>
		<li><a <?=check_active('play', 'index', '2')?'class="active red"':''?> href="<?=base_url('play/index/2')?>"><?=$this->lang->line('chain_mode')?></a></li>
		<li><a <?=check_active('gallery', 'index', '2')?'class="active red"':''?> href="<?=base_url('gallery/index/2')?>"><?=$this->lang->line('gallery')?></a></li>
		<br>
		<li><a <?=check_active('play', 'index', '5')?'class="active purple"':''?> href="<?=base_url('play/index/5')?>"><?=$this->lang->line('rotation_mode')?></a></li>
		<li><a <?=check_active('gallery', 'index', '5')?'class="active purple"':''?> href="<?=base_url('gallery/index/5')?>"><?=$this->lang->line('gallery')?></a></li>
		<br>
		<li><a <?=check_active('play', 'index', '6')?'class="active black"':''?> href="<?=base_url('play/index/6')?>"><?=$this->lang->line('pixel_art_mode')?></a></li>
		<li><a <?=check_active('gallery', 'index', '6')?'class="active black"':''?> href="<?=base_url('gallery/index/6')?>"><?=$this->lang->line('gallery')?></a></li>
		<br>
		<li><a <?=check_active('play', 'index', '7')?'class="active gray"':''?> href="<?=base_url('play/index/7')?>"><?=$this->lang->line('blind_mode')?></a></li>
		<li><a <?=check_active('gallery', 'index', '7')?'class="active gray"':''?> href="<?=base_url('gallery/index/7')?>"><?=$this->lang->line('gallery')?></a></li>
		<br>
		<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){ ?>
			<li><a <?=check_active('user', 'logout')?'class="active blue"':''?> href="<?=base_url('user/logout')?>"><?=$this->lang->line('logout')?></a></li>
		<?php } else { ?>
			<li><a <?=check_active('user', 'login')?'class="active blue"':''?> href="<?=base_url('user/login')?>"><?=$this->lang->line('login')?></a></li>
		<?php } ?>
		<li><a <?=check_active('misc', 'contact')?'class="active yellow"':''?> href="<?=base_url('misc/contact')?>"><?=$this->lang->line('contact')?></a></li>
		<li>
			<a href="<?=base_url('misc/lang/en')?>" class="lang">🇺🇸</a>
			<a href="<?=base_url('misc/lang/fr')?>" class="lang">🇫🇷</a>
			<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){ ?>
				<a href="<?=base_url('user/settings')?>" class="lang">⚙️</a>
			<?php } ?>
			<a class="<?=check_active('play', 'index', '4')?'active yellow':'ee'?>" href="<?=base_url('play/index/4')?>"><?=$this->lang->line('easter_egg')?></a>
		</li>
	</ul>
</nav>
<div id="start"></div>
