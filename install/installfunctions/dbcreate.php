<?php
error_reporting(0);
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

//Checks if some information is missing
if($_POST['dbhost']==NULL||$_POST['dbname']==NULL||$_POST['dbuser']==NULL){
	$output=json_encode(array('type'=>'error','text'=>'You left some outputs blanks.'));
	die($output);
}

$dbhost=trim(stripslashes_deep($_POST['dbhost']));
$dbname=trim(stripslashes_deep($_POST['dbname']));
$dbuser=trim(stripslashes_deep($_POST['dbuser']));
$dbpass=trim(stripslashes_deep($_POST['dbpass']));

//directory where the database file will be created
$filename=$_SERVER["DOCUMENT_ROOT"].'/config/dbconnection.php';

//checks if with the information given the server can connect to the database
$conn=new mysqli($dbhost,$dbuser,$dbpass);
if($conn->connect_error){
	$output=json_encode(array('type'=>'error','text'=>'Connection failed: '.$conn->connect_error));
	die($output);
}

//Creates the database if it doesn't exists
if(!$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname`")){
	$output=json_encode(array('type'=>'error','text'=>'Error creating database: '.$conn->error));
	die($output);
}

//Saves the information in a file, for forward use
$sampleData=array('database'=>array('host'=>$dbhost,'user'=>$dbuser,'password'=>$dbpass,'database'=>$dbname));
if(!write_ini_file($sampleData,'dbdata.ini',true)){
	$output=json_encode(array('type'=>'error','text'=>'Cannot save info.'));
	die($output);
}

//creates the database file that the page will use
$somecontent='<?php $host="'.$dbhost.'";$database="'.$dbname.'";$user="'.$dbuser.'";$password="'.$dbpass.'";$dbc=mysqli_connect($host,$user,$password,$database)or die(\'<!DOCTYPE HTML><head><meta charset="UTF-8"></head><html lang="es"><body><h1>could not connect to the server</h1></body></html>\');?>';
if(!$handle=fopen($filename,'w')){
	$output=json_encode(array('type'=>'error','text'=>"Cannot create database config file."));
	die($output);
}else{
    if(fwrite($handle,$somecontent)===FALSE){
		$output=json_encode(array('type'=>'error','text'=>"Cannot write to file database config file, check the permissions of the folder."));
		die($output);
    }else{
		$output=json_encode(array('type'=>'success','proceed'=>'installfunctions/dbpopulate.php','ralert'=>'synchronizing data'));
		echo $output;
	}
    fclose($handle);
}
$conn->close();
?>