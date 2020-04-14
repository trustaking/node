<?php
$bannerAd[1] = '<a href="https://www.liberstad.com/" target="_blank"><img src="images/liberstad.png" width="728" height="90" border="0"></a>';
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
	</head>
	<body class="landing is-preload">
	<!-- Page Wrapper -->
	<div id="page-wrapper">
