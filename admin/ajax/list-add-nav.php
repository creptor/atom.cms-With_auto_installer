<?php
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])!='xmlhttprequest'){
	$output=json_encode(array('type'=>'error','text'=>'Sorry Request must be Ajax POST'));
	die($output); //exit script outputting json data
}
include('../../config/dbconnection.php');
if(isset($_GET['list'])){
	$list=$_GET['list'];
	foreach($list as $position=>$openedid){
		if(!$data=$dbc->query("SELECT * FROM pages WHERE id = $openedid")){
			$output=json_encode(array('type'=>'error','text'=>"Query failed: (".$dbc->errno.") ".$dbc->error));
			die($output);
		}
		while($fetch = $data->fetch_assoc()){
			$url=$fetch['slug'];
			if(!$update=$dbc->query("INSERT INTO navigation (pageid, label, url, position) VALUES ('$openedid', '$fetch[label]', '$url', $position) ON DUPLICATE KEY UPDATE position=$position")){
				$output=json_encode(array('type'=>'error','text'=>"Update failed: (".$dbc->errno.") ".$dbc->error));
				die($output);
			}
			if(!$remove=$dbc->query("UPDATE pages SET on_field_editable = 0 WHERE id = $openedid")){
				$output=json_encode(array('type'=>'error','text'=>"Remove failed: (".$dbc->errno.") ".$dbc->error));
				die($output);
			}
		}
	}
}else{
	$output=json_encode(array('type'=>'error','text'=>'Invalid request'));
	return $output;
}
?>