<?php 
require ('include/config.php');
require ('include/functions.php');
require ('/var/secure/keys.php');
require ('vendor/autoload.php');

$wallet = new phpFunctions_Wallet();

//Check if node is online before further checks
$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Node/status' ;
$check_server = $wallet->checkSite ($url);

//if ( $check_server == '' || empty($check_server) ) {
//	die (' The coind server located at '. $scheme.'://'.$server_port.' on Port:['.$server_port.'] appears to be unresponsive.');
//}

if ( $check_server == '' || empty($check_server) ) {
$message = <<<EOD
<ul class="icons"><label class="icon fa-circle" style='font-size:16px;color:red'> Full Node is offline</label></ul>
EOD;
} else {
// Get Node Staking Details
$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Staking/getstakinginfo';
$stakinginfo = $wallet->CallAPI ($url); 

//if ( !is_array($stakinginfo) ) {
//	die (' There was an error with your login parameters.');
//}

if ($stakinginfo['staking']=1) {
//if ($stakinginfo->staking =1) {
$message = <<<EOD
<ul class="icons"><label class="icon fa-circle" style='font-size:16px;color:green'> Staking is online</label></ul>
EOD;
} else {
$message = <<<EOD
<ul class="icons"><label class="icon fa-circle" style='font-size:16px;color:red'> Staking is offline</label></ul>
EOD;
}
}

$OrderID = $ticker . '-' . $wallet->crypto_rand(100000000000,999999999999);
?>
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
	</head>
	<body class="landing is-preload">

		<!-- Page Wrapper -->
			<div id="page-wrapper">
			<!-- Header -->
					<header id="header" class="alt">
					<?php print $message;?>
						<h1><a href="index.html">TRUSTAKING.COM</a></h1>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
											<li><a href="index.html">Home</a></li>
										</ul>
									</div>
								</li>
							</ul>
						</nav>
					</header>

				<!-- Banner -->
				<section id="banner">
						<div class="inner">
							<h2><img src="images/logo_transparent.png" alt="" width="150"/> <br/>TRUSTAKING.COM</h2>
							<p>The trusted home of <br />
							cold staking<br />
							<a href="#main" class="more scrolly"><b>PAYMENT</b></a>
					</section>

				<!-- Main 
					<article id="main">
							<section class="wrapper style5">
								<div class="inner">
								<form method="POST" action="https://btcpay.trustaking.com/api/v1/invoices" margin: 0 auto; >
									<input type="hidden" name="storeId" value="HABeciwEXCSLXzyQDpgXmgM7RkCFWoELpZp1KcZ8W87q" />
									<input type="hidden" name="price" value="2" />
									<input type="hidden" name="orderId" value="<?php print $OrderID;?>" />
									<input type="hidden" name="currency" value="USD" />
									<input type="hidden" name="checkoutDesc" value="One month cold staking service" />
									<input type="hidden" name="notifyEmail" value="admin@trustaking.com" />
									<input type="hidden" name="browserRedirect" value="http://<?php print $ticker; ?>.trustaking.com/activate.php?OrderID=<?php print $OrderID; ?>" />
									<input type="image" src="https://btcpay.trustaking.com/img/paybutton/pay.png" name="submit" style="width:209px" alt="Pay with BtcPay, Self-Hosted Bitcoin Payment Processor">
								</form>
							</div>
							</section>
					</article>
				-->
				<!-- Main -->
				<article id="main">
						<section class="wrapper style5">
							<div class="inner">
							<form method="POST" action="https://testnet.demo.btcpayserver.org/api/v1/invoices">
								<input type="hidden" name="storeId" value="7thhDWTqzvaKjMU5KHxUY1AbzkrQ6UaTsfD4E8Ux6k2k" />
								<input type="hidden" name="orderId" value="<?php print $OrderID;?>" />
								<input type="hidden" name="price" value="2" />
								<input type="hidden" name="currency" value="USD" />
								<input type="hidden" name="notifyEmail" value="admin@trustaking.com" />
								<input type="hidden" name="browserRedirect" value="http://<?php print $ticker; ?>.trustaking.com/activate.php?OrderID=<?php print $OrderID; ?>" />
    							<input type="image" src="https://testnet.demo.btcpayserver.org/img/paybutton/pay.png" name="submit" style="width:209px" alt="Pay with BtcPay, Self-Hosted Bitcoin Payment Processor">
							</form>
							</div>
						</section>
					</article>

				<!-- Footer -->
					<footer id="footer">
						<ul class="icons">
							<li><a href="https://discord.gg/BRcDVqM" class="fab fa-discord"></a></li>
							<li><a href="mailto:admin@trustaking.com" class="icon fa-envelope-o"></a></li>
						</ul>
						<ul class="copyright">
							<li>&copy; TRUSTAKING.COM</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
						</ul>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>