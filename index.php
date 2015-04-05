<?php
include('config/setup.php');
include('objects/login-register.php');
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo $siteTitle." | ".$page['header'];?></title>
    <!--[if lte IE 7]><div class="alert-ie7">
The browser you are using is <strong>out of date</strong>. Please <strong><a href="http://browsehappy.com/">update your browser</a></strong> or <strong><a href="http://www.google.com/chromeframe/?redirect=true">enable Google Chrome Frame</a></strong>. </div><![endif]-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/fontawesome-iconpicker.min.css">
    <link rel="stylesheet" href="css/default.css">
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery-migrate-1.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/fontawesome-iconpicker.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/minified/jquery.sceditor.bbcode.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://apis.google.com/js/plusone.js"></script>
    <script src="https://apis.google.com/js/plus.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
    <div id="view">
		<div id="top">
        	<?php include('objects/header.php');?>
		</div>
        <?php if(isset($ad_d)==1 and isset($ad_key)){ ?>
        <div id="bottom">
        	<div class="ad_diagonal">
				<?php include('objects/ad_bottom.php'); ?>
            </div>
        </div>
        <?php } ?>
		<div id="content">
        	<div id="slider"></div>
            <div id="left">
                <?php include('objects/navigation.php');?>
            </div>
        	<div id="right">
            	<div class="ad_vertical">
					<?php if(isset($ad_v)==1 and isset($ad_key)){ include('objects/ad_vertical.php');} ?>
                </div>
                <div class="info_square">
                	<div>
						<?php echo $infosquare['body']; ?>
                    </div>
                </div>
            </div>
        	<div id="body">
                <?php include($type);?>
            </div>
		</div>
	</div>
	<div id="footer">
		<?php include('objects/footer.php');?>
	</div>
    <?php if(!isset($_SESSION['email'])){ ?>
	<a id="black-background" class="close-lg"></a>
	<div id="login-conteiner">
    	<?php include('objects/form_login.php'); ?>
	</div>
    <?php } ?>
</body>
</html>