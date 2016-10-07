<?php
session_start();
include'functions.php';
//Checks the password
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

//Remove password.txt file
if(!unlink($_SERVER["DOCUMENT_ROOT"].'/password.txt')){
	$output=json_encode(array('type'=>'error','text'=>'An error ocurred.'));
	die($output);
}else{
	if(!rm_r($_SERVER["DOCUMENT_ROOT"].'/install')){
		$output=json_encode(array('type'=>'error','text'=>'An error ocurred.'));
		die($output);
	}else{
		$output=json_encode(array('type'=>'success','text'=>'Successfuly removed.','html'=>'<p>The installation was compleated, to continue just go to your website, or click <a href="'.$_SERVER['SERVER_NAME'].'">here</a><p>','header'=>'Done!'));
		echo $output;
	}
}
?>