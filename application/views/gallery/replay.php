<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="draw">

    <h1 id="s"></h1>

    <img id="model" src="<?=base_url('medias/'.(isset($drawing->picture->title)?'pictures':'drawings').'/'.$drawing->picture->file)?>" alt="<?=isset($drawing->picture->title)?$drawing->picture->title:$drawing->picture->pseudo?>" width="400" height="400" <?=$drawing->type==ROTATION_MODE?'class="rotation-canvas"':''?> />
    <canvas id="canvas" width="400" height="400" <?=$drawing->type==ROTATION_MODE?'class="rotation-model"':''?> <?=$drawing->type==BLINDED_MODE?'style="display: none;"':''?>></canvas>

    <input type="hidden" id="json" value="<?=base_url('medias/json/'.(is_null($drawing->json)?'default.json':$drawing->json))?>">

</div>
<script src="<?=base_url('assets/javascript/replay.js')?>"></script>
