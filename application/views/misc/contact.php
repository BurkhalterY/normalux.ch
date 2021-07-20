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

	<div style="text-align: initial;">
		<br><br>
		<h2><?=$this->lang->line('sponso')?></h2>
		<div class="gallery modal-btn" style="float: none; display: inline-block;" data-modal="ouloul">
			<img src="<?=base_url('medias/sponso/ouloul.jpg')?>" alt="Ouloul">
			<div class="desc">Ouloul</div>
		</div>
	</div>
</article>
<div id="ouloul" class="modal">
	<div class="modal-content">
		🔒 ⠂𝐔𝐧 𝐬𝐲𝐬𝐭𝐞̀𝐦𝐞 𝐝𝐞 𝐯𝐚𝐥𝐢𝐝𝐚𝐭𝐢𝐨𝐧 𝐝𝐮 𝐫𝐞̀𝐠𝐥𝐞𝐦𝐞𝐧𝐭 !<br><br>
		😇 ⠂𝐔𝐧𝐞 𝐜𝐨𝐦𝐦𝐮𝐧𝐚𝐮𝐭𝐞́ 𝐬𝐲𝐦𝐩𝐚𝐭𝐡𝐢𝐪𝐮𝐞 𝐞𝐭 𝐚𝐜𝐭𝐢𝐯𝐞 𝐪𝐮𝐢 𝐚𝐢𝐦𝐞 𝐩𝐚𝐫𝐥𝐞𝐫 𝐞𝐭 𝐩𝐚𝐫𝐭𝐚𝐠𝐞𝐫 𝐬𝐚 𝐩𝐚𝐬𝐬𝐢𝐨𝐧<br><br>
		🏅 ⠂𝐔𝐧 𝐬𝐲𝐬𝐭𝐞̀𝐦𝐞 𝐝𝐞 𝐠𝐫𝐚𝐝𝐞 𝐬𝐞𝐥𝐨𝐧 𝐯𝐨𝐭𝐫𝐞 𝐚𝐜𝐭𝐢𝐯𝐢𝐭𝐞́ 𝐞𝐭 𝐯𝐨𝐭𝐫𝐞 𝐟𝐢𝐝𝐞́𝐥𝐢𝐭𝐞́ 𝐬𝐮𝐫 𝐥𝐞 𝐬𝐞𝐫𝐯𝐞𝐮𝐫<br><br>
		🎉 ⠂𝐃𝐞𝐬 𝐚𝐧𝐢𝐦𝐚𝐭𝐢𝐨𝐧𝐬 𝐫𝐞́𝐠𝐮𝐥𝐢𝐞̀𝐫𝐞𝐬 𝐞𝐭 𝐯𝐚𝐫𝐢𝐞́𝐞𝐬 !<br><br>
		🔰 ⠂𝐔𝐧 𝐒𝐭𝐚𝐟𝐟 𝐚𝐜𝐭𝐢𝐟, 𝐚𝐭𝐭𝐞𝐧𝐭𝐢𝐨𝐧𝐧𝐞́ 𝐞𝐭 𝐚̀ 𝐥'𝐞́𝐜𝐨𝐮𝐭𝐞 !<br><br>
		✏ ⠂𝐃𝐞 𝐬𝐨𝐦𝐩𝐭𝐮𝐞𝐮𝐱 𝐞́𝐦𝐨𝐣𝐢𝐬 !<br><br>
		🎥 ⠂𝐔𝐧 𝐬𝐞𝐫𝐯𝐞𝐮𝐫 𝐛𝐚𝐬𝐞́ 𝐬𝐮𝐫 𝐮𝐧 𝐘𝐨𝐮𝐭𝐮𝐛𝐞𝐮𝐫 𝐚𝐜𝐭𝐢𝐟 𝐚𝐯𝐞𝐜 𝐮𝐧𝐞 𝐜𝐨𝐦𝐦𝐮𝐧𝐚𝐮𝐭𝐞́ 𝐭𝐨𝐮𝐣𝐨𝐮𝐫𝐬 𝐩𝐫𝐞́𝐬𝐞𝐧𝐭𝐞 !<br><br>
		🤖 ⠂𝐃𝐞𝐬 𝐛𝐨𝐭𝐬 𝐮𝐭𝐢𝐥𝐞𝐬, 𝐛𝐢𝐞𝐧 𝐜𝐨𝐧𝐟𝐢𝐠𝐮𝐫𝐞́𝐬 𝐞𝐭 𝐝𝐢𝐯𝐞𝐫𝐬.<br><br>
		⌨ ⠂𝐃𝐞𝐬 𝐬𝐚𝐥𝐨𝐧𝐬 𝐯𝐚𝐫𝐢𝐞́𝐬 !<br><br>
		🎶 ⠂𝐔𝐧 𝐬𝐚𝐥𝐨𝐧 𝐦𝐮𝐬𝐢𝐪𝐮𝐞 𝐩𝐨𝐮𝐫 𝐬𝐞 𝐝𝐞́𝐭𝐞𝐧𝐝𝐫𝐞 !<br><br>
		───────────────➤<br><br>
		📺 • Youtube (<a target="_blank" href="https://www.youtube.com/c/Ouloul">https://www.youtube.com/c/Ouloul</a>)<br>
		💻 • Twitch (<a target="_blank" href="https://www.twitch.tv/ou_loul">https://www.twitch.tv/ou_loul</a>)<br>
		👑 • Lien d'invitation (<a target="_blank" href="https://discord.gg/dz9TsbXHz2">https://discord.gg/dz9TsbXHz2</a>)<br>
	</div>
</div>
<script>
	const btn = document.getElementsByClassName("modal-btn");
	var modal;

	for (let i = 0; i < btn.length; i++) {
		btn[i].onclick = () => {
			modal = document.getElementById(btn[i].dataset.modal);
			modal.style.display = "block";
		};
	}

	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
</script>
<style>
	.modal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 1; /* Sit on top */
		padding-top: 100px; /* Location of the box */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	.modal-content {
		background-color: #fefefe;
		margin: auto;
		padding: 20px;
		border: 1px solid #888;
		width: 400px;
		text-align: left;
		position: relative;
		box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
		animation-name: animatetop;
		animation-duration: 0.4s
	}

	@keyframes animatetop {
		from {top: -300px; opacity: 0}
		to {top: 0; opacity: 1}
	}
</style>