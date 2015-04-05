<?php include ("config/setup.php");
include ("../objects/login-register.php");?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Login</title>
    <!--[if lte IE 7]><div class="alert-ie7">
The browser you are using is <strong>out of date</strong>. Please <strong><a href="http://browsehappy.com/">update your browser</a></strong> or <strong><a href="http://www.google.com/chromeframe/?redirect=true">enable Google Chrome Frame</a></strong>. </div><![endif]-->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="css/login.min.css">
    <script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="../js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script src="https://apis.google.com/js/plusone.js"></script>
    <script src="https://apis.google.com/js/plus.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
    <div id="black-background"></div>
    <div id="login-conteiner">
    	<?php include ("objects/form_login.php");?>
	</div>
</body>
</html>