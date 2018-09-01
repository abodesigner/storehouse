<?php
	include 'dbcon.php';
	// Routes
	$tpl  = 'includes/templates/';
	$lang = 'includes/languages/';
	$func = 'includes/functions/';
	$css  = 'themes/css/';
	$js   = 'themes/js/';



	// Include Important files
	include $func . 'functions.php';
	include $lang . 'en.php';
	include $tpl  . 'header.inc.php';

	if (!isset($noNavbar)){ include $tpl . 'navbar.inc.php'; }
