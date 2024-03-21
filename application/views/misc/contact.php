<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<article>
https://github.com/BurkhalterY/normalux.ch

<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){ ?>
    <a href="<?=base_url('user/settings')?>" style="position: fixed; right: 20px; bottom: 10px;">
        <img src="<?=base_url('assets/images/s_cog.png')?>" alt="Settings"/>
    </a>
<?php } ?>
</article>
