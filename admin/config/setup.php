<?php
	session_start();
	//page setup:
	if(isset($_GET['page'])){$page = $_GET['page'];}else{$page = 'dashboard';}
	//mysql conection:
	include('../config/dbconnection.php');
	//functions:
	include('functions/sandbox.php');
	include('functions/data.php');
	include('functions/query.php');
	//settings
		//site
		$siteTitle = data_settings_value($dbc, 'nombre_pagina');;
		$logo = data_settings_value($dbc, 'logo');
		//users
		$usregister = data_settings_value($dbc, 'user_register');
		//google
		$googlelogin = data_settings_value($dbc, 'google_login');
		$googleclientid = data_settings_value($dbc, 'google_client_id');
		$googlesecretid = data_settings_value($dbc, 'google_secret_id');
		$googleappuri = data_settings_value($dbc, 'google_app_uri');
		//captcha
		$captchaPUBLIC = data_settings_value($dbc, 'captcha_public');
		$captchaPRIVATE = data_settings_value($dbc, 'captcha_private');
	//extra -for now-
	if(isset($_SESSION['email'])){
		$data = $dbc->query("SELECT email FROM users WHERE email = '$_SESSION[email]'");
		while ($user_data = $data->fetch_assoc()){
			$user = data_user($dbc, $user_data['email']);
		}
	}
	if(!isset($opened)){$opened=NULL;}
?>