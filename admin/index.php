<?php include 'config/setup.php';?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
<?php
if(!isset($_SESSION['email'])&&isset($_SESSION['value'])!=3) {
	echo'</head><body></body></html>';
	header("Location: login.php");
	die;
}?>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<title><?php echo $siteTitle;?> | Admin Panel</title>
    <!--[if lte IE 7]><div class="alert-ie7">
 The browser you are using is <strong>out of date</strong>. Please <strong><a href="http://browsehappy.com/">update your browser</a></strong> or <strong><a href="http://www.google.com/chromeframe/?redirect=true">enable Google Chrome Frame</a></strong>. </div><![endif]-->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="../css/jquery-ui.min.css" />
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/fontawesome-iconpicker.min.css"/>
    <link rel="stylesheet" href="css/default.css" />
    <script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="../js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/fontawesome-iconpicker.min.js"></script>
    <script type="text/javascript" src="../js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
    <script src="js/main.js"></script>
</head>
<body>
    <!--[if lte IE 7]><div class="alert-ie7">
 The browser you are using is <strong>out of date</strong>. Please <strong><a href="http://browsehappy.com/">update your browser</a></strong> or <strong><a href="http://www.google.com/chromeframe/?redirect=true">enable Google Chrome Frame</a></strong>. </div><![endif]-->
    <div>
		<div id="top">
			<?php include('objects/header.php'); ?>
		</div>
		<div id="content">
            <div id="left">
                <?php include('objects/navigation.php');?>
            </div>
        	<div id="body">
                <div>
                    <div id="main_body">
                    	<?php if(file_exists('view/'.$page.'.php')){include('view/'.$page.'.php');}else{echo"<h1>Invalid page</h1>";}?>
                    </div>
                </div>
            </div>
		</div>
	</div>
</body>
</html>