<?php
function data_setting_value($dbc, $id){
	$stmt = $dbc->query("SELECT * FROM settings WHERE id = '$id'");
	$data = $stmt->fetch_assoc();
	return $data['value'];
}
function data_post_type($dbc, $id){
	$stmt = $dbc->query("SELECT * FROM post_types WHERE id = $id");
	$data = $stmt->fetch_assoc();
	return $data;
}
function data_post($dbc, $id){
	if(is_numeric($id)){
		$stmt = $dbc->prepare('SELECT * FROM pages WHERE id = ?');
		$stmt->bind_param('i', $id);
	}else{
		$stmt = $dbc->prepare('SELECT * FROM pages WHERE slug = ?');
		$stmt->bind_param('s', $id);
	}
	$stmt->execute();
	$res = $stmt->get_result();
	$data = $res->fetch_assoc();
	$data['body_nohtml'] = strip_tags($data['body']);
	if($data['body'] == $data['body_nohtml']){
		$data['body_formatted'] = '<p>'.$data['body'].'</p>';
	}else{
		$data['body_formatted'] = $data['body'];	
	}
	return $data;
}
function data_user($dbc, $id){
	if(is_numeric($id)){$cond = "WHERE id = '$id'";}else{$cond = "WHERE email = '$id'";}
	$stmt = $dbc->query("SELECT * FROM users $cond");
	$data = $stmt->fetch_assoc();
	return $data;
}
function prepare_fetch($val, $opt){
	if($opt!=NULL){
		if($opt=="i"){$data=filter_var($val, FILTER_VALIDATE_INT);}
		if($opt=="s"){$data=filter_var($val, FILTER_SANITIZE_STRING);}
		if($opt=="m"){$data=filter_var($val, FILTER_VALIDATE_EMAIL);}
	}else{
		die('error');
	}
	return $data;
}
?>