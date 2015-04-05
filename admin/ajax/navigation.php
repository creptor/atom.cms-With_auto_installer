<?php
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	$output = json_encode(array('type'=>'error','text'=>'Sorry Request must be Ajax POST'));
	die($output); //exit script outputting json data
}
include('../../config/dbconnection.php');
if(isset($_POST['label'])||isset($_POST['icon'])||isset($_POST['url'])||isset($_POST['status'])){
	$label=$_POST['label'];
	$icon=$_POST['icon'];
	$url=$_POST['url'];
	if($_POST['status']!=1){$status=0;}else{$status=1;}
	if(!$query=$dbc->query("UPDATE navigation SET label = '$label', icon = '$icon', url = '$url', status = '$status' WHERE pageid = '$_POST[openedid]'")){							
		$output=json_encode(array('type'=>'error','text'=>'No se pudo actualizar el item.'));
		die($output);
	}else{
		$output=json_encode(array('type'=>'valid','text'=>'Editado correctamente.'));
		return $output;
	}
}else{
	$output=json_encode(array('type'=>'error','text'=>'Invalid request'));
	return $output;
}
?>