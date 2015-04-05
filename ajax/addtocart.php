<?php
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {  
	$output = json_encode(array('type'=>'error','text' => 'Sorry Request must be Ajax POST'));
	die($output);
}
if($_POST){ 
	include "../config/dbconnection.php"; 
	//variables
	$date = new DateTime('NOW');
	//clean the data: 
	if(!is_numeric($_POST['id'])){ 
		$output = json_encode(array('type'=>'error','text' => 'El id del objeto seleccionado no es valido'));
		die($output);
	}else{ 
		$itemID = mysqli_escape_string($dbc, $_POST['id']);
	} 
	if(!isset($_POST['qty'])){ 
		$qty = 1;
	}else{
		if(!is_numeric($_POST['qty'])){
			$output = json_encode(array('type'=>'error','text' => 'La cantidad del objeto seleccionado no es valida'));
			die($output);
		}else{
			$qty = mysqli_escape_string($_POST['qty']);
		}
	}
	//fetch data:
	$check = $dbc->prepare("SELECT store_item_id FROM store WHERE store_item_id = :id"); 
	$check->bind_param(':id', $itemID);
	$check->execute();
	$check->store_result();
	$numrows = $check->num_rows();
	if($numrows!=1){ 
		$output = json_encode(array('type'=>'error','text' => 'El objeto especificado no exciste'));
		die($output);
	}
	$check->close();
	//connection
	if(!$error){ 
		$stmt = $dbc->prepare("INSERT INTO cart (item_id, quantity, date_added, session_id) VALUES (':item', ':qty', ':date', ':session') ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(:qty)");
		$stmt->bind_param(':item', $itemID);
		$stmt->bind_param(':qty', $qty);
		$stmt->bind_param(':date', $date->format(DateTime::ISO8601));
		$stmt->bind_param(':session', $_POST['sessionid']);
		$stmt->execute();
		$output = json_encode(array('type'=>'success','text' => 'Objeto agregado correctamente'));
		return $output;
	}
}
?> 