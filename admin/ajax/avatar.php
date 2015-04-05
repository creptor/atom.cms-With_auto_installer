<?php
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	$output = json_encode(array('type'=>'error','text'=>'Sorry Request must be Ajax POST'));
	die($output); //exit script outputting json data
}
include('../../config/dbconnection.php');

if(!$query = $dbc->prepare("SELECT img FROM users WHERE id = ?")){
	$output =  json_encode(array('type'=>'error','text'=>"Query failed: (".$dbc->errno.") ".$dbc->error));
	die($output);
}
$query->bind_param('i',$_GET['id']);
if(!$query->execute){
	$output =  json_encode(array('type'=>'error','text'=>"Execute failed: (".$dbc->errno.") ".$dbc->error));
	die($output);
}
$data = $query->fetch_assoc();
?>
<div id="avatar" class="user_icon_menu" style="background-size: 48px;background-image:url(../<?php echo $data['img'];?>);"></div>