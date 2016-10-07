<?php
session_start();
include'functions.php';

//checks the password
if($_POST['password_hash']==NULL){
	$output=json_encode(array('type'=>'error','text'=>"There's something not right with your entry, please go back."));
	die($output);
}else{
	if(!$pass_file=file_get_contents(realpath("../../password.txt"))){
		$output=json_encode(array('type'=>'error','text'=>"The password couldn't be fetch, please check your files."));
		die($output);
	}
	if($pass_file!=$_SESSION['install_pass']||$pass_file!=$_POST['password_hash']){
		$output=json_encode(array('type'=>'error','text'=>'You have an invalid master password.'));
		die($output);
	}
}

//read previusly saved data
if(!$array_ini=parse_ini_file("dbdata.ini")){
	$output=json_encode(array('type'=>'error','text'=>"Can't correctly pass data, please try again."));
	die($output);
}
$dbhost=$array_ini['host'];
$dbname=$array_ini['database'];
$dbuser=$array_ini['user'];
$dbpass=$array_ini['password'];

$conn=new mysqli($dbhost,$dbuser,$dbpass,$dbname);
if($conn->connect_error){
	$output=json_encode(array('type'=>'error','text'=>'Connection failed: '.$conn->connect_error));
	die($output);
}

//checks the parameters inputed by the form
$verify=false;
$email=prepare_fetch($_POST['usEmail'],'m');
if(isset($email['error'])){
	$output=json_encode(array('type'=>'error','text'=>'The email is not valid.'));
	die($output);
}
$name=prepare_fetch($_POST['usName'],'s');
if(isset($name['error'])){
	$output=json_encode(array('type'=>'error','text'=>'The name is not valid'));
	die($output);
}
$wbTitle=prepare_fetch($_POST['wbTitle'],'s');
if(isset($wbTitle['error'])){
	$output=json_encode(array('type'=>'error','text'=>'The web title is not valid'));
	die($output);
}
$password=$_POST['usPassword'];
$repeat_password=$_POST['usPasswordv'];
if($password!=NULL||$repeat_password!=NULL){
	if($password==$repeat_password){
		$verify=true;
	}else{
		$output=json_encode(array('type'=>'error','text'=>"The passwords don't match."));
		die($output);
	}
}else{	
	$output=json_encode(array('type'=>'error','text'=>"There's a blank password."));
	die($output);
}

//Upload initial page configuration to the database
if(!$conn->query("INSERT INTO settings (id, label, value) VALUES ('nombre_pagina', 'Titulo de la pagina', '$wbTitle') ON DUPLICATE KEY UPDATE value = '$wbTitle'")){
	$output=json_encode(array('type'=>'error','text'=>'Error updating the data: '.$conn->error));
	die($output);
}
if($verify!=false){
	if(!$conn->query("INSERT INTO users (name,email,password,permissions) VALUES ('$name','$email',SHA1('$password'),'4')")){
		$output=json_encode(array('type'=>'error','text'=>'Error updating the data: '.$conn->error));
		die($output);
	}else{
		$output=json_encode(array('type'=>'success','show'=>'remove-files.html','header'=>'Final Steps','text'=>'Data successfully updated.'));
		echo $output;
	}
}
$conn->close();
?>