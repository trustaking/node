<!DOCTYPE HTML>
<html>
	<head>
		<title>trustaking.com</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src='https://www.google.com/recaptcha/api.js?render=<?php echo $captcha_site_key; ?>'></script>
        <script>
            grecaptcha.ready(function () {
                grecaptcha.execute('<?php echo $captcha_site_key; ?>', { action: 'payment' }).then(function (token) {
                    var recaptchaResponse = document.getElementById('recaptchaResponse');
					console.log(recaptchaResponse)
                    recaptchaResponse.value = token;
                });
            });
        </script>
	</head>
	<body class="landing is-preload">
	<!-- Page Wrapper -->
	<div id="page-wrapper">
