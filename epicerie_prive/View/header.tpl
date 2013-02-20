<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr-FR" lang="fr-FR">
<head>
	<title><?php echo $title; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<style media="all" type="text/css">@import "<?php echo $_SERVER['HTTP_ROOT']; ?>css/all.css";</style>
	<style media="print" type="text/css">@import "<?php echo $_SERVER['HTTP_ROOT']; ?>css/print.css";</style>
	<style media="all" type="text/css">@import "<?php echo $_SERVER['HTTP_ROOT']; ?>css/jquery.autocomplete.css";</style>
	<style media="all" type="text/css">@import "<?php echo $_SERVER['HTTP_ROOT']; ?>css/jquery.jqplot.min.css";</style>
	<script src="<?php echo $_SERVER['HTTP_ROOT']; ?>js/jquery-1.7.2.min.js"></script>
	<script src="<?php echo $_SERVER['HTTP_ROOT']; ?>js/jquery-add2cart.js"></script>
	<script src="<?php echo $_SERVER['HTTP_ROOT']; ?>js/jquery.jqplot.min.js"></script>
	<script src="<?php echo $_SERVER['HTTP_ROOT']; ?>js/jqplot.pieRenderer.min.js"></script>
	<script src="<?php echo $_SERVER['HTTP_ROOT']; ?>js/jquery.autocomplete-min.js"></script>
	<script src="<?php echo $_SERVER['HTTP_ROOT']; ?>js/jquery.validate.js"></script>
	<script src="<?php echo $_SERVER['HTTP_ROOT']; ?>js/script.js"></script>
</head>
<body>
	<a href="https://github.com/otomatik/epicerie"><img style="position: absolute; top: 0; left: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_left_green_007200.png" alt="Fork me on GitHub"></a>
    <div id="page">
	<div id="header">
	    <div id="menu" class="background">
		<h1><a href="<?php url(''); ?>" title="Accueil">Accueil</a></h1>
		<ul>
		    <?php menu($GLOBALS['menu']); ?>
		</ul>
	    </div>
	    <?php require 'ardoise.tpl'; ?>
	</div>
	<div id="content">
	    <div id="leftcol">
		<div class="block">
		    <div class="block-top"></div>
		    <div class="block-content">
			<h2><?php echo $title; ?></h2>

<?php //var_dump( $_SERVER); ?>