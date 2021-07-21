<?php defined('BASEPATH') OR exit('No direct script access allowed');

Global $uri;
$uri = $this->uri;

function check_active($p1 = '', $p2 = '', $p3 = '1'){
	global $uri;
	return $uri->segment(1, 'play') == $p1 && $uri->segment(2, 'index') == $p2 && $uri->segment(3, '1') == $p3;
}

?>
<nav>
	<ul class="menu">
		<li class="menu"><a <?=check_active('play', 'index', '1')?'class="active green"':''?> href="<?=base_url()?>"><?=$this->lang->line('menu_normal_mode')?></a></li>
		<li class="menu"><a <?=check_active('gallery', 'index', '1')?'class="active green"':''?> href="<?=base_url('gallery')?>"><?=$this->lang->line('menu_gallery')?></a></li>
		<br>
		<li class="menu"><a <?=check_active('play', 'index', '2')?'class="active red"':''?> href="<?=base_url('play/index/2')?>"><?=$this->lang->line('menu_chain_mode')?></a></li>
		<li class="menu"><a <?=check_active('gallery', 'index', '2')?'class="active red"':''?> href="<?=base_url('gallery/index/2')?>"><?=$this->lang->line('menu_gallery')?></a></li>
		<br>
		<li class="menu"><a <?=check_active('play', 'index', '5')?'class="active purple"':''?> href="<?=base_url('play/index/5')?>"><?=$this->lang->line('menu_rotation_mode')?></a></li>
		<li class="menu"><a <?=check_active('gallery', 'index', '5')?'class="active purple"':''?> href="<?=base_url('gallery/index/5')?>"><?=$this->lang->line('menu_gallery')?></a></li>
		<br>
		<li class="menu"><a <?=check_active('play', 'index', '6')?'class="active black"':''?> href="<?=base_url('play/index/6')?>"><?=$this->lang->line('menu_pixel_art')?></a></li>
		<li class="menu"><a <?=check_active('gallery', 'index', '6')?'class="active black"':''?> href="<?=base_url('gallery/index/6')?>"><?=$this->lang->line('menu_gallery')?></a></li>
		<br>
		<li class="menu"><a <?=check_active('play', 'index', '7')?'class="active gray"':''?> href="<?=base_url('play/index/7')?>"><?=$this->lang->line('menu_blind_mode')?></a></li>
		<li class="menu"><a <?=check_active('gallery', 'index', '7')?'class="active gray"':''?> href="<?=base_url('gallery/index/7')?>"><?=$this->lang->line('menu_gallery')?></a></li>
		<br>
		<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){ ?>
			<li class="menu"><a <?=check_active('user', 'index')?'class="active blue"':''?> href="<?=base_url('user')?>"><?=$this->lang->line('menu_my_account')?></a></li>
			<li class="menu"><a <?=check_active('user', 'logout')?'class="active blue"':''?> href="<?=base_url('user/logout')?>"><?=$this->lang->line('menu_logout')?></a></li>
		<?php } else { ?>
			<li class="menu"><a <?=check_active('user', 'login')?'class="active blue"':''?> href="<?=base_url('user/login')?>"><?=$this->lang->line('menu_login')?></a></li>
			<li class="menu"><a <?=check_active('user', 'register')?'class="active blue"':''?> href="<?=base_url('user/register')?>"><?=$this->lang->line('menu_register')?></a></li>
		<?php } ?>
		<br>
		<li class="menu"><a <?=check_active('misc', 'contact')?'class="active yellow"':''?> href="<?=base_url('misc/contact')?>"><?=$this->lang->line('menu_contact')?></a></li>
		<li class="menu"><a <?=check_active('bd')?'class="active yellow"':''?> href="<?=base_url('bd')?>"><?=$this->lang->line('menu_comics')?></a></li>
		<li class="menu ee"><a <?=check_active('play', 'index', '4')?'class="active yellow"':''?> href="<?=base_url('play/index/4')?>"><?=$this->lang->line('menu_yo')?></a></li>
	</ul>
</nav>
