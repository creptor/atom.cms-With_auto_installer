<?php
function data_settings_value($dbc, $id){
	$stmt = $dbc->query("SELECT * FROM settings WHERE id = '$id'");
	$data = $stmt->fetch_assoc();
	return $data['value'];
}
function data_user($dbc, $id){
	if(is_numeric($id)){
		$cond = "WHERE id = '$id'";
	} else {
		$cond = "WHERE email = '$id'";
	}
	$stmt = $dbc->query("SELECT * FROM users $cond");
	
	$data = $stmt->fetch_assoc();
	return $data;
}
function data($dbc, $id, $tb, $col = NULL) {
	if($dbc==NULL){die('no database to retrive from');}
	if($tb==NULL){die('no table to retrive from');}
	if(!is_numeric($id)){die('NULL id');}
	if($col==NULL){$col='id';}else{mysqli_real_escape_string($dbc,$col);}
	if(!$stmt = $dbc->query("SELECT * FROM $tb WHERE $col = '$id'")){
		die("Update failed: (".$dbc->errno.") ".$dbc->error);
	}
	$data = $stmt->fetch_assoc();	

	return $data;
}
?>