<?php
session_start();
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
if(!$array_ini=parse_ini_file("dbdata.ini")){
	$output=json_encode(array('type'=>'error','text'=>"Can't correctly pass data, please try again."));
	die($output);
}
$dbhost=$array_ini['host'];
$dbname=$array_ini['database'];
$dbuser=$array_ini['user'];
$dbpass=$array_ini['password'];
$col_data=is_numeric($_POST['coldata']);
if($_POST['dbhost']!=$dbhost||$_POST['dbname']!=$dbname||$_POST['dbuser']!=$dbuser||$_POST['dbpass']!=$dbpass){
	$output=json_encode(array('type'=>'error','text'=>'An error ocurred while reading the data.'));
	die($output);
}
$conn=new mysqli($dbhost,$dbuser,$dbpass,$dbname);
if($conn->connect_error){
	$output=json_encode(array('type'=>'error','text'=>'Connection failed: '.$conn->connect_error));
	die($output);
}
if(!$sql=file_get_contents('../language/simple.sql')){
	$output=json_encode(array('type'=>'error','text'=>'Cannot load data for database.'));
	die($output);
}
if($col_data!=''){
	if(!$sql.=file_get_contents('../language/'.$col_data.'.sql')){
		$output=json_encode(array('type'=>'error','text'=>'Cannot load data for database.'));
		die($output);
	}
}
if(!$conn->multi_query($sql)) { 
    $output=json_encode(array('type'=>'error','text'=>'Cannot sync the database.'));
    die($output);
}else{
	$output=json_encode(array('type'=>'success','text'=>'Correctly sync with database.','show'=>'config-form.html'));
    echo $output;
}
$conn->close();
?>