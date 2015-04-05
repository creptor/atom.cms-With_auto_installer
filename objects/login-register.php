<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
	if($captchaState==1){
		$recaptcha=$_POST['g-recaptcha-response'];
		if(!empty($recaptcha)){
			$google_url="https://www.google.com/recaptcha/api/siteverify";
			$secret=$captchaPRIVATE;
			$ip=$_SERVER['REMOTE_ADDR'];
			$url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
			$res=getCurlData($url);
			$res= json_decode($res, true);
			//reCaptcha success check 
			if($res['success']){
			//Include login check code
				$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
				if(isset($_GET['login'])){//begins login
					if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //email validation
						$output = json_encode(array('type'=>'error', 'text' => 'Ingrese un email valido.'));
						die($output);
					}
					$stmt = $dbc->query("SELECT id, name, email, permissions, nickname FROM users WHERE email = '$email' AND password = SHA2('$_POST[password]',256)");
					if($stmt->num_rows == 1){
						$data = $stmt->fetch_assoc();
						$_SESSION = $data;
						header('Location: index.php');
					}else{
						echo 'The user or the password are incorrect.';
					}//end for login
				}else{//begins register
					$username = filter_var($_POST["nickname"], FILTER_SANITIZE_STRING);
					$name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
					$password  = filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS);
					$passwordv = filter_var($_POST["passwordv"], FILTER_SANITIZE_SPECIAL_CHARS);
					$errors = array();
					
					if(strlen($username)<4){
						$errors[] = 'El nombre de usuario es muy corto o esta vacio.';
					}else{
						if(!ctype_alnum($username)){
							$errors[] = 'The username can only contain letters and digits.';
						}
						if(strlen($username) > 30){
							$errors[] = 'The username cannot be longer than 30 characters.';
						}
					}
					if(strlen($name)<3){
						$errors[] = 'El nombre es muy corto o esta vacio.';
					}else{
						if(!ctype_alpha($name)){
							$errors[] = 'The name can only contain letters and digits.';
						}
						if(strlen($name) > 30){
							$errors[] = 'The username cannot be longer than 30 characters.';
						}
					}
					if(isset($password)){
						if($password != $passwordv){
							$errors[] = 'The two passwords did not match.';
						}
					}else{
						$errors[] = 'The password field cannot be empty.';
					}
					if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
						$errors[] = 'The email is not valid.';
					}
					if(!empty($errors)){
						$message = '<div class="alert alert-warning">Uh-oh.. a couple of fields are not filled in correctly..';
						$message += '<ul>';
						foreach($errors as $key => $value){
							$message += '<li>' . $value . '</li>';
						}
						$message += '</ul></div>';
					}else{
						$sql = "INSERT INTO users(name, password, email ,date) VALUES('$name', SHA1('$_POST[password]'), '$email', NOW())";
										 
						$result = mysqli_query($dbc, $sql);
						if(!$result){
							$message = '<div class="alert alert-warning">Something went wrong while registering. Please try again later.</div>';
						}
						else{
							$message = '<div class="alert alert-success">registrado satifactoriamente. Ahora puede ingresar a la pagina.</div>';
						}
					}
				}//end for register
			}else{
			$message='<div class="alert alert-warning">Please re-enter your reCAPTCHA.</div>';
			}	
		}else{
			$message='<div class="alert alert-warning">Please re-enter your reCAPTCHA.</div>';
		}
	}else{
		$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
		if(isset($_GET['login'])){//begins login
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //email validation
				$output = json_encode(array('type'=>'error', 'text' => 'Ingrese un email valido.'));
				die($output);
			}
			$stmt = $dbc->query("SELECT id, name, email, permissions, nickname FROM users WHERE email = '$email' AND password = SHA2('$_POST[password]',256)");
			if($stmt->num_rows == 1){
				$data = $stmt->fetch_assoc();
				$_SESSION = $data;
				header('Location: index.php');
			}else{
				echo 'The user or the password are incorrect.';
			}//end for login
		}else{//begins register
			$username = filter_var($_POST["nickname"], FILTER_SANITIZE_STRING);
			$name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
			$password  = filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS);
			$passwordv = filter_var($_POST["passwordv"], FILTER_SANITIZE_SPECIAL_CHARS);
			$errors = array();
			
			if(strlen($username)<4){
				$errors[] = 'El nombre de usuario es muy corto o esta vacio.';
			}else{
				if(!ctype_alnum($username)){
					$errors[] = 'The username can only contain letters and digits.';
				}
				if(strlen($username) > 30){
					$errors[] = 'The username cannot be longer than 30 characters.';
				}
			}
			if(strlen($name)<3){
				$errors[] = 'El nombre es muy corto o esta vacio.';
			}else{
				if(!ctype_alpha($name)){
					$errors[] = 'The name can only contain letters and digits.';
				}
				if(strlen($name) > 30){
					$errors[] = 'The username cannot be longer than 30 characters.';
				}
			}
			if(isset($password)){
				if($password != $passwordv){
					$errors[] = 'The two passwords did not match.';
				}
			}else{
				$errors[] = 'The password field cannot be empty.';
			}
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors[] = 'The email is not valid.';
			}
			if(!empty($errors)){
				$message = '<div class="alert alert-warning">Uh-oh.. a couple of fields are not filled in correctly..';
				$message += '<ul>';
				foreach($errors as $key => $value){
					$message += '<li>' . $value . '</li>';
				}
				$message += '</ul></div>';
			}else{
				$sql = "INSERT INTO users(name, password, email ,date) VALUES('$name', SHA1('$_POST[password]'), '$email', NOW())";
								 
				$result = mysqli_query($dbc, $sql);
				if(!$result){
					$message = '<div class="alert alert-warning">Something went wrong while registering. Please try again later.</div>';
				}
				else{
					$message = '<div class="alert alert-success">registrado satifactoriamente. Ahora puede ingresar a la pagina.</div>';
				}
			}
		}//end for register
	}
}
if(isset($message)){return $message;}
?>