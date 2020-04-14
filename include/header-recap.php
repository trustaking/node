<?php
$bannerAd[1] = '<a href="https://www.liberstad.com/" target="_blank"><img src="images/banner_liberstad.png" border="0" class="img-responsive"></a>';
//$bannerAd[3] = 'code for ad 3';
//$bannerAd[4] = 'code for ad 4';
//$bannerAd[5] = 'code for ad 5';
$adCount = 0;
if (isset($bannerAd)) {
	$adCount = count($bannerAd);
	$randomAdNumber = mt_rand(1, $adCount);
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>trustaking.com</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/css/app.css" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src='https://www.google.com/recaptcha/api.js?render=<?php echo $coinFunctions->keys['captcha_site_key']; ?>'></script>
        <script>
			grecaptcha.ready(function () {
				grecaptcha.execute('<?php echo $coinFunctions->keys['captcha_site_key']; ?>', { action: 'payment' }).then(function (token) {
					document.getElementById('recaptchaResponse1').value = token;
					document.getElementById('recaptchaResponse2').value = token;
					document.getElementById('recaptchaResponse3').value = token;
					document.getElementById('recaptchaResponse4').value = token;
					document.getElementById('recaptchaResponse5').value = token;
				});
			});
        </script>
	</head>
	<body class="landing is-preload">
	<!-- Page Wrapper -->
	<div id="page-wrapper">