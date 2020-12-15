<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
	<nav class="sidebar">
		<ul>
			<!--<li class="sidebar"><a href="https://www.facebook.com/Normaluxch-436521113523643" target="_blank"><span style="color: #3B5998; font-size: 24px;"><i class="fab fa-facebook-f"></i></span></a></li>-->
			<li class="sidebar"><a href="https://twitter.com/NormaluxC" target="_blank"><span style="color: #00ACEE; font-size: 24px;"><i class="fab fa-twitter"></i></span></a></li>
			<!--<li class="sidebar"><a href="https://plus.google.com/b/113542416065572213469/113542416065572213469" target="_blank"><span style="color: #DB4A39; font-size: 24px;"><i class="fab fa-google-plus-g"></i></span></a></li>-->
			<li class="sidebar"><a href="https://www.youtube.com/channel/UCbv1uNvn53SHwSSY19luZvQ" target="_blank"><span style="color: #C4302B; font-size: 24px;"><i class="fab fa-youtube"></i></span></a></li>
			<!--<li class="sidebar"><a href="https://wiki.normalux.ch" target="_blank"><span style="color: #F6F6F6; font-size: 24px;"><i class="fab fa-wikipedia-w"></i></span></a></li>-->
			<li class="sidebar"><a href="https://discord.gg/z67yZjh" target="_blank"><span style="color: #7289DA; font-size: 24px;"><i class="fab fa-discord"></i></span></a></li>
		</ul>
	</nav>

	<p><?=$this->lang->line('contact_text')?></p>
	<a href="mailto:info@normalux.ch">info@normalux.ch</a>
	<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){ ?>
		<p><?=$this->lang->line('suggestion_link')[0]?><a href="<?=base_url('misc/suggestion')?>"><?=$this->lang->line('suggestion_link')[1]?></a></p>
	<?php } ?>

	<div style="text-align: initial;">
		<br><br>
		<h2><?=$this->lang->line('our_other_projects')?></h2>
		<div class="gallery" style="float: none; display: inline-block;">
			<a href="https://github.com/BurkhalterY/EPSIC_Bataille_Navale/releases" target="_blank"><img src="<?=base_url('assets/images/thumbails/battleship.png')?>" alt="Bataille Navale C#"></a>
			<div class="desc">Bataille Navale C#</div>
		</div>
		<h3>Collection de BD :</h2>
		<div class="gallery" style="float: none; display: inline-block;">
			<a href="<?=base_url('medias/divers/TRUMP - L\'intégrale/TRUMP - La revanche de l_Univers.pdf')?>" target="_blank"><img src="<?=base_url('assets/images/thumbails/TRUMP - La revanche de l_Univers.png')?>" alt="TRUMP - La revanche de l'Univers"></a>
			<div class="desc">TRUMP - La revanche de l'Univers</div>
		</div>
		<div class="gallery" style="float: none; display: inline-block;">
			<a href="<?=base_url('medias/divers/TRUMP - L\'intégrale/TRUMP - Tome2.pdf')?>" target="_blank"><img src="<?=base_url('assets/images/thumbails/TRUMP - Tome2.png')?>" alt="TRUMP - Tome 2"></a>
			<div class="desc">TRUMP - Tome 2</div>
		</div>
		<div class="gallery" style="float: none; display: inline-block;">
			<a href="<?=base_url('medias/divers/TRUMP - L\'intégrale/Tome 3 - Spécial anime !.pdf')?>" target="_blank"><img src="<?=base_url('assets/images/thumbails/Tome 3 - Spécial anime !.jpg')?>" alt="TRUMP - Tome3 : Spécial anime !"></a>
			<div class="desc">TRUMP - Tome3 : Spécial anime !</div>
		</div>
		<div class="gallery" style="float: none; display: inline-block;">
			<a href="<?=base_url('medias/divers/TRUMP - L\'intégrale/Trump 4 dans l\'espace.pdf')?>" target="_blank"><img src="<?=base_url('assets/images/thumbails/Trump 4 dans l\'espace.png')?>" alt="Trump 4 dans l'espace"></a>
			<div class="desc">Trump 4 dans l'espace</div>
		</div>
	</div>
</article>
