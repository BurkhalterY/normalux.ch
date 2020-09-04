<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1 id="s"><?=$tracing->word->kanji?><br><?=$tracing->word->kana?></h1>
<img id="model" src="<?=base_url('medias/drawings/'.$tracing->filename)?>" alt="<?=$tracing->word->french?>" width="400" height="400" />
<br>

<a href="<?=base_url('japan/validate/'.$tracing->id.'/1')?>" id="btn_yes"><?=$this->lang->line('yes')?></a>
<a href="<?=base_url('japan/validate/'.$tracing->id.'/0')?>" id="btn_no"><?=$this->lang->line('no')?></a>