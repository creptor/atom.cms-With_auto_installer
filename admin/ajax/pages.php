<?php
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	$output = json_encode(array('type'=>'error','text'=>'Sorry Request must be Ajax POST'));
	die($output); //exit script outputting json data
}
include('../../config/dbconnection.php');

$id = $_GET['id'];		
$q = "DELETE FROM pages WHERE id = $id";
$r = mysqli_query($dbc,$q);

if($r) {
	echo 'Page Deleted';
} else {
	
	echo 'There was an error...<br>';
	echo $q.'<br>';
	echo mysqli_error($dbc);
	
}
?>