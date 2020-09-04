<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<article style="text-align: justify; margin-right: 10px;">
	<div>
		<a href="<?=base_url('japan/kdlt/'.($kanji->id-1))?>" style="float: left;">Précédent</a>
		<a href="<?=base_url('japan/kdlt/'.($kanji->id+1))?>" style="float: right;">Suivant</a>
	</div>
	<?=$kanji->chapter?>:<?=is_null($kanji->no_kdlt)?'*':$kanji->no_kdlt?><font size="7">&nbsp;&nbsp;&nbsp;&nbsp;<?=$kanji->keyword?>&nbsp;&nbsp;&nbsp;&nbsp;<span id="kanji"><?=$kanji->kanji?></span></font>
	<p><?=$kanji->memo?></p>
	<div style="text-align: left;">
		<?=$kanji->lines_number.' trait'.($kanji->lines_number>1?'s':'').' : '?>
		<span id="trace"><?=$kanji->kanji?></span>
	</div>
	<p><?=$kanji->remarque?></p>
	<p><?=(empty($kanji->composant)?'':'* ').$kanji->composant?></p>
	<script>
		var imgs = document.getElementById('kanji').getElementsByTagName("IMG");
		if(imgs.length > 0){
			var splitedSrc = imgs[0].src.split('/');
			imgs[0].src = "<?=base_url('medias/kanji/')?>"+splitedSrc[splitedSrc.length-1];
		}

		var traces = document.getElementById('trace').getElementsByTagName("IMG");
		if(traces.length > 0){
			var splitedSrc = traces[0].src.split('/');
			traces[0].src = "<?=base_url('medias/kanji/')?>"+splitedSrc[splitedSrc.length-1];
			traces[0].src = traces[0].src.replace('.svg', '.png');
		} else {
			document.getElementById('trace').innerHTML = "";
			var img = document.createElement("img");
			img.src = '<?=base_url('medias/kanji/_'.$kanji->kanji.'.png')?>';
			img.style.verticalAlign = "middle"; 
			document.getElementById('trace').appendChild(img);
		}
	</script>
</article>