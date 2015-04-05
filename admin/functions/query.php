<?php
switch($page){
	case 'blog_posts':
		if(isset($_GET['id'])){$opened = data($dbc, $_GET['id'], 'blog_posts');}
	break;
	case 'forum':
		if(isset($_GET['categories'])){
			if(isset($_GET['id'])){$opened = data($dbc, $_GET['id'], 'forum_categories');}
		}
		if(isset($_GET['topics'])){
			if(isset($_GET['id'])){$opened = data($dbc, $_GET['id'], 'forum_topics');}
		}
	break;
	case 'pages':
		if(isset($_POST['submitted']) == 1){
			$title = mysqli_real_escape_string($dbc, $_POST['title']);
			$label = mysqli_real_escape_string($dbc, $_POST['label']);
			$header = mysqli_real_escape_string($dbc, $_POST['header']);
			$body = mysqli_real_escape_string($dbc, $_POST['body']);
			$username = mysqli_real_escape_string($dbc, $user['id']);
			$string = preg_replace('/\s+/', '-', $_POST['title']);
			$slug = mysqli_real_escape_string($dbc, strtolower($string));
			
			if(isset($_POST['id']) != '') {
				$action = 'actualizada';
				$q = "UPDATE pages SET title = '$title', label = '$label', header = '$header', body = '$body', user = '$username', slug = '$slug', type = '1' WHERE id = '$_POST[id]'";
			} else {
				$action = 'a&#241;adida';
				$q = "INSERT INTO pages (title, label, header, body, user, slug) VALUES ('$title', '$label', '$header', '$body', '$username', '$slug')";
			}
			$r = mysqli_query($dbc, $q);
											
			if($r){ 
				$message = '<div class="alert alert-success" role="alert">Pagina '.$action.'!</div>';
			} else {
				$message = '<div class="alert alert-warning" role="alert">La pagina no pudo ser '.$action.'.</div>';
			}
		}
		if(isset($_GET['id'])){$opened = data($dbc, $_GET['id'], 'pages');}
	break;
	case 'store':
		if(isset($_GET['id'])){$opened = data($dbc, $_GET['id'], 'store', 'store_item_id');}
	break;
	case 'users':
		if(isset($_POST['submitted']) == 1) {
			$allOK= 1;
			$id = $_GET['id'];
			$nickname = mysqli_real_escape_string($dbc, $_POST['nickname']);
			$name = mysqli_real_escape_string($dbc, $_POST['name']);
			$permissions=is_numeric($_POST['permissions']);
			if($_POST['password'] != ''){
				if($_POST['password'] == $_POST['passwordv']) {
					$pass = " password = SHA1('$_POST[password]'),";
					$verify = true;
				} else {
					$verify = false;
				}
			} else {	
				$verify = false;	
			}
			if(isset($id) && $id != '') {
				$action = 'updated';
				$stmt = $dbc->query("UPDATE users SET nickname = '$nickname', name = '$name', email = '$_POST[email]',$pass permissions = '$permissions' WHERE id = $id");			
			} else {
				if($verify == true) {
					$action = 'add';
					$stmt = $dbc->query("INSERT INTO users (username, name, email, password, coins, value) VALUES ('$username', '$name', '$_POST[email]', SHA1('$_POST[password]'), '$_POST[coins]', '$_POST[value]')");
				}
			}
			if(isset($_FILES['fileToUpload'])){
				$ds = DIRECTORY_SEPARATOR;
				$storeFolder = 'userIcons';
				$target_file = basename($_FILES["fileToUpload"]["name"]);
				$ext = pathinfo($target_file,PATHINFO_EXTENSION);
				$newname = time();
				$random = rand(100,999);
				$name = $newname.$random.'.'.$ext;
				$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				 
				if($check == false) {
					$error .= "File is not an image.";
					$allOK = 0;
				}
				if ($_FILES["fileToUpload"]["size"] > 500000) {
					$error .= "Sorry, your file is too large.";
					$allOK = 0;
				}
				// Allow certain file formats
				if($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif" ) {
					$error .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
					$allOK = 0;
				}
				if ($allOK == 0) {
					$error .= "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
				} else {
					if (!empty($_FILES)) {
						$get = $dbc->query("SELECT img FROM users WHERE id = $id");
						$old = $stmt->fetch_assoc();
						$upload = $dbc->query("UPDATE users SET img = 'userIcons/$name' WHERE id = $id");
					 
						$tempFile = $_FILES['fileToUpload']['tmp_name'];
						$targetPath = $_SERVER['HTTP_HOST'].$ds;
						$targetFile =  $targetPath.$storeFolder.$ds.$name;
						
						move_uploaded_file($tempFile,$targetFile);
						
						if($old != 'images/user.jpg') {
							$deleteFile = $targetPath.$storeFolder.$ds.$old;
							if(!is_dir($deleteFile)) {
								unlink($deleteFile);
							}
						}
					}
				}
			}
			if($allOK == 1){
				$message = '<div class="alert alert-success">User was '.$action.'!</div>';
			} else {
				if(isset($_POST['id']) != '') {
					$message = '<div class="alert alert-danger">User could not be '.$action.' because: '.mysqli_error($dbc).'</div>';
				}
				if($error != NULL){
					$message = '<div class="alert alert-danger">User could not be '.$action.' because: '.$error.'</div>';
					}
				if($verify == false and !isset($_POST['id'])) {
					$message = '<div class="alert alert-danger">Password fields empty and/or do not match.</div>';
				}
			}
		}
		if(isset($_GET['id'])) { $opened = data_user($dbc, $_GET['id']); }
		echo mysqli_error($dbc);
	break;
	case 'settings':
		if(isset($_POST['submitted']) == 1) {
			
			$label = mysqli_real_escape_string($dbc, $_POST['label']);
			$value = $_POST['value'];
			$action = 'updated';
			
			if(isset($_POST['openedid']) != '') {
				$q = "UPDATE setting SET label = '$label', value = '$value' WHERE id = '$_POST[openedid]'";
				$r = mysqli_query($dbc, $q);	
			} 
			if($r){
				$message = '<div class="alert alert-success">Setting was '.$action.'!</div>';
			} else {
				$message = '<div class="alert alert-danger">Setting could not be '.$action.' because: '.mysqli_error($dbc).'</div>';	
			}			
		}
	case 'navigation':
		if(isset($_POST['submitted']) == 1){
			$label=mysqli_real_escape_string($dbc,$_POST['label']);
			$img=$_POST['icon'];
			$url=$_POST['url'];
			if($_POST['status']!=1){
				$status=0;
			}else{
				$status=1;
			}
			if(isset($_POST['openedid']) != '') {
				$action = 'actualizado';
				if(!$query = $dbc->query("UPDATE navigation SET label = '$label', icon = '$icon', url = '$url', status = '$status' WHERE id = '$_POST[openedid]'")){
					$output='<div class="alert alert-warning" role="alert">El item no pudo ser '.$action.'.</div>';
				}else{
					$output='<div class="alert alert-success" role="alert">Item '.$action.'!</div>';
				}
				return($output);
			}else{
				die("NULL id");
			}
		}
	break;
	default:
	break;
}
?>