<?php session_start();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<meta name="format-detection" content="telephone=no">
<title>Installation proccess</title>
<link rel="stylesheet" href="files/install.css">
<script src="../js/jquery-1.11.2.min.js"></script>
<script src="../js/jquery-migrate-1.2.1.min.js"></script>
<script src="files/strength.min.js"></script>
<script src="files/install.js"></script>
</head>
<body>
    <div id="page">
    	<div id="header">
        	<h1>Welcome</h1>
        </div>
        <div id="body">
        	<div id="main">
                <div id="content">
                    <div id="js-check">
                        <h2>Please wait...</h2>
                        <p>We're checking your host information and validating before proceeding.</p>
                        <quote>If nothing happens. please check that you have javascript enabled. If you don't have it, go <a href="?js=DOES-NOT-WORK-YET">here.</a></quote>
                    </div>
                </div>
			</div>
        </div>
	</div>
    <div id="alert"><div><div class="load"><div class="loader"></div></div><p>loading</p></div></div>
</body>
</html>