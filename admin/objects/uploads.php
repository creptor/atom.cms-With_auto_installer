<?php
include('../config/dbconection.php');
$ds = DIRECTORY_SEPARATOR;  //1
$storeFolder = '../../userIcons';
$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$newname = time();
$random = rand(100,999);
$name = $newname.$random.'.'.$ext;
$q = "SELECT img FROM users WHERE id = $_GET[id]";
$r = mysqli_query($dbc, $q);
$old = mysqli_fetch_assoc($r);
$q = "UPDATE users SET img = 'userIcons/$name' WHERE id = $_GET[id]";
$r = mysqli_query($dbc, $q);
 
echo $q.'<br>';
echo mysqli_error($dbc);
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname( __FILE__ ).$ds.$storeFolder.$ds;
    $targetFile =  $targetPath. $name;
	
    move_uploaded_file($tempFile,$targetFile);
	
    $deleteFile = $targetPath.$old;
    if($old != 'images/user.jpg') {
		if(!is_dir($deleteFile)) {
			unlink($deleteFile);
		}
    }
}
?> 