<?php
session_start();
if($_POST['allow']==NULL){
	$output=json_encode(array('type'=>'error','text'=>"You left the password blank."));
	die($output);
}else{
	$pass=hash('sha256',$_POST['allow']);
	$pass_file=file_get_contents(realpath("../../password.txt"));
	if($pass_file==$pass){
		$_SESSION['install_pass']=$pass;
		$output=json_encode(array('type'=>'success','text'=>'The password is correct, please wait.','show'=>'database-form.html','password'=>$pass));
		echo $output;
	}else{
		$output=json_encode(array('type'=>'error','text'=>'You have an invalid password.'));
		die($output);
	}
}
?>