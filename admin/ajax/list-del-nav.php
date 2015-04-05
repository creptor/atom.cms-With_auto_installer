<?php
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])!='xmlhttprequest'){
	$output=json_encode(array('type'=>'error','text'=>'Sorry Request must be Ajax POST'));
	die($output); //exit script outputting json data
}
include('../../config/dbconnection.php');
if(isset($_GET['list'])){
	$list=$_GET['list'];
	foreach($list as $position=>$openedid){
		if(!$data=$dbc->query("DELETE FROM navigation WHERE pageid = $openedid")){
			$output=json_encode(array('type'=>'error','text'=>"Remove failed: (".$dbc->errno.") ".$dbc->error));
			die($output);
		}
		if(!$update=$dbc->query("UPDATE pages SET on_field_editable = 1 WHERE id = $openedid")){
			$output=json_encode(array('type'=>'error','text'=>"Update failed: (".$dbc->errno.") ".$dbc->error));
			die($output);
		}
	}
}else{
	$output=json_encode(array('type'=>'error','text'=>'Invalid request'));
	return $output;
}
?>