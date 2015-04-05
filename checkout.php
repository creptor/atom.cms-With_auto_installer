<?php
include('config/setup.php');
include('objects/login&register.php');
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo $checkoutTitle?></title>
    <!--[if lte IE 7]><div class="alert-ie7">
The browser you are using is <strong>out of date</strong>. Please <strong><a href="http://browsehappy.com/">update your browser</a></strong> or <strong><a href="http://www.google.com/chromeframe/?redirect=true">enable Google Chrome Frame</a></strong>. </div><![endif]-->
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery-migrate-1.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://apis.google.com/js/plusone.js"></script>
    <script src="https://apis.google.com/js/plus.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
  <div style="
    width: 80%;
    margin: auto;
    padding: 40px;
    background: #f0f0f0;
">
    <div><img alt="logo"><div style="float: right;">day <?php echo date(); ?></div></div>
    <div style="
    margin-top: 40px;
">
      <p>info for shoppping on this store, notes and the other relevant stuff</p>
      <ul>
        <li>data etc...... cost</li>
      </ul>
    <strong style="float: right;margin-right:100px;">$XXXXX.XX</strong></div>
  </div>
</body>
</html>