<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
	<head>
		<title><?=$title?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="description" content="<?=$this->lang->line('meta_description')?>" />
		<?php if(isset($online_mode)) { ?>
			<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/drawing.online.css')?>">
			<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/gallery.online.css')?>">
		<?php } else { ?>
			<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/drawing.css')?>">
			<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/gallery.css')?>">
		<?php } ?>
		<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/styles.css')?>">
		<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/menu.css')?>">
		<link rel="stylesheet" type="text/css" href="<?=base_url('assets/fontawesome/css/all.css')?>">
		<link rel="icon" type="image/png" href="<?=base_url('assets/images/favicon.png')?>" />
	</head>
<body>
