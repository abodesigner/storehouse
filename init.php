<?php

	// error_reporting
	ini_set('display_errors','on');
	error_reporting(E_ALL);

	$sessionUser = '';
	if(isset($_SESSION['user'])){
			$sessionUser = $_SESSION['user'];
	}


	// Connect to database from admin
	include 'admin/dbcon.php';
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
