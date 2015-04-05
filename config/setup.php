<?php
	ob_start();
	/*error_reporting(1);*/
	header('Cache-Control: cache, store, must-revalidate'); // HTTP 1.1.
	header('Pragma: cache'); // HTTP 1.0.
	header('Expires: 60'); // Proxies.
	//session
	session_start();
	if(file_exists($_SERVER["DOCUMENT_ROOT"].'/password.txt')){
		header("Location: install");
	}
	//mysql conection:
	include('config/dbconnection.php');
	//functions:
	include('functions/sandbox.php');
	include('functions/data.php');
	include('functions/template.php');
	/*ini_set('include_path', '/google/src');
	ini_set('include_path', '/facebook/src');
	require_once'google/autoload.php';
	require_once'facebook/autoload.php';*/
	//data:
	$path = get_path();
	$page = data_post($dbc, $path['call_parts'][0]);
	if($page['type']!=NULL){
		$view = data_post_type($dbc, $page['type']);
		$type = 'view/'.$view['label'].'.php';
	}
	//settings
		//site
		$siteTitle = data_setting_value($dbc, 'nombre_pagina');
		$debug = data_setting_value($dbc, 'debug_status');
		$inicio = data_setting_value($dbc, 'start_page');
		$logo = data_setting_value($dbc, 'logo');
		$footer = data_setting_value($dbc, 'footer');
		//pages
		$tiendaStatus = data_setting_value($dbc, 'shop_status');
		$storeItems = data_setting_value($dbc, 'store_items');
		$RangeItems = data_setting_value($dbc, 'range_items');
		$forumStatus = data_setting_value($dbc, 'forum_status');
		$blogStatus = data_setting_value($dbc, 'blog_status');
		$slideshow = data_setting_value($dbc, 'slider_pages');
		//users
		$usregister = data_setting_value($dbc, 'user_register');
		//google
		$googlelogin = data_setting_value($dbc, 'google_login');
		$googleclientid = data_setting_value($dbc, 'google_client_id');
		$googlesecretid = data_setting_value($dbc, 'google_secret_id');
		$googleappuri = data_setting_value($dbc, 'google_app_uri');
		//captcha
		$captchaPUBLIC = data_setting_value($dbc, 'captcha_public');
		$captchaPRIVATE = data_setting_value($dbc, 'captcha_private');
	//close settings
	//site setup:
	if($usregister!=1){
		if($path['call_parts'][0] == 'register'){
			header("Location: error");
		}
	}
	if(!isset($path['call_parts'][0]) || $path['call_parts'][0] == '' || isset($path['call_parts'][1])){
		if($path=='index.php'||$path['call_parts'][0]==''){
			header("Location: ".$inicio);
		}
	}else{
		if(($page['type']=='' || $view['status']==0) && ($path!='index.php' || $path['call_parts'][0] == $inicio)){
			header("Location: error");
		}
	}
	//user data:
	if(isset($_SESSION['email'])){
		$data = $dbc->query("SELECT email FROM users WHERE email = '$_SESSION[email]'");
		while ($user_data = $data->fetch_assoc()){
			$user = data_user($dbc, $user_data['email']);
		}
	}
	//facebook & google data:
/*	if($googlelogin==1){
		$client = new Google_Client();
		$client->setClientId($googleclientid);
		$client->setClientSecret($googlesecretid);
		$client->setRedirectUri($googleappuri);
		$client->setScopes('email');
	}
	FacebookSession::setDefaultApplication('582241671912177', '8e8862266f22dfa43b32810d7ce97d74');
	$face_id = $facebook->getUser();*/
	$infosquare=NULL;
	ob_end_flush();
?>