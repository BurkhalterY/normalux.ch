<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h1 id="s"><?=$drawing->japan->kanji?><br><?=$drawing->japan->kana?></h1>
<img id="model" src="<?=base_url('medias/drawings/'.$drawing->file)?>" alt="<?=$drawing->japan->kana?>" width="400" height="400" />
<br>

<a href="<?=base_url('japan/validate/'.$drawing->id.'/1')?>" id="btn_yes"><?=$this->lang->line('yes')?></a>
<a href="<?=base_url('japan/validate/'.$drawing->id.'/0')?>" id="btn_no"><?=$this->lang->line('no')?></a>