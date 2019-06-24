<?php 
session_start(); 
require ('include/config.php');
require ('include/functions.php');
require ('/var/secure/keys.php');
$wallet = new phpFunctions_Wallet();

// Set  price and work out how long the server will run for
$now = new DateTime();
$end_date = new DateTime(date($service_end_date));
$difference = $now->diff($end_date);
$days_remaining = ceil($difference->format("%a"));
$_SESSION['Days_Online']=$days_remaining;
$_SESSION['Price'] = ceil(($price / $_SESSION['Days_Online']) * $days_remaining);
if ($_SESSION['Price']>$price) {
	$_SESSION['Price']=$price;
}

//Check if node is online before further checks
$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Node/status' ;
$check_server = $wallet->checkSite ($url);

//if ( $check_server == '' || empty($check_server) ) {
//	die (' The server appears to be unresponsive.');
//}

if ( $check_server == '' || empty($check_server) ) {
$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:red'>Node offline</a></li>
EOD;
$enabled = <<<EOD
<a href="index.html" class="icon fa-circle" style="color:red">TRUSTAKING.COM </a>
EOD;
} else {
// Get Node Staking Details
$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Staking/getstakinginfo';
$get_stakinginfo = $wallet->CallAPI ($url); 

if ( !is_array($get_stakinginfo) ) {
	die (' There was an error with your API parameters.');
}

if ($get_stakinginfo['enabled']>0) {
$enabled = <<<EOD
<a href="index.html" class="icon fa-circle" style="color:green">TRUSTAKING.COM</a>
EOD;
} else {
$enabled = <<<EOD
<a href="index.html" class="icon fa-circle" style="color:red">TRUSTAKING.COM </a>
EOD;
}

if ($get_stakinginfo['staking']>0) {
$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:green'>Staking online</a></li>
EOD;
} else {
$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:red'>Staking offline</a></li>
EOD;
}

$url = $scheme.'://'.$server_ip.':'.$api_port."/api/Wallet/balance?WalletName=$WalletName&AccountName=$AccountName";
$get_balance = $wallet->CallAPI ($url); 
//print_r ($get_balance);

if ( !is_array($get_balance) ) {
	die (' There was an error with your login parameters. Are your credentials correct?');
} else {
foreach($get_balance as $a => $b){
	foreach($get_balance as $c => $d){
		foreach($get_balance as $e => $f){
print_r ($a);
echo "<br />";
print_r ($b);
echo "<br />";
print_r ($c);
echo "<br />";
print_r ($d);
echo "<br />";
print_r ($e);
echo "<br />";
print_r ($f);

//echo $e['amountConfirmed'];
}}}

if ($bal>0) {
$balance = <<<EOD
<li><a href="" style='color:green'>Total: $bal/a></li>
EOD;
} else {
$balance = <<<EOD
<li><a href="" style='color:red'>Total: 0</a></li>
EOD;
}}

$OrderID = $ticker . '-' . $wallet->crypto_rand(100000000000,999999999999);
}
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
			<!-- Header -->
					<header id="header" class="alt">
						<h1><?php print $enabled;?></h1>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
											<?php print $message;?>
											<?php print $balance;?>
											<li><a href="index.php">Home</a></li>
											<li><a href="about.html">FAQ</a></li>
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
							<a href="#main" class="more scrolly"></a>

						<form method="post" action="landing.php">
            					<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
								<input type="submit" class="button icon fa-shopping-cart" value="$<?php print $_SESSION['Price'];?> Pay Now" />
						</form>
						<h6></h6><i><?php print $_SESSION['Days_Online'];?> days of cold staking remaining. Service ends on <?php print $end_date->format('Y-m-d');?></i>
						<a href="#main" class="more scrolly"></a>
					</section>
		<!-- Main -->
		<article id="main">
				<!-- One -->
					<section id="one" class="wrapper style1 special">
						<div class="inner">
							<header class="major">
								<h2>Full Node as a Service</h2>
								<p>Effortless cold staking with no technical knowledge required</p>
							</header>
							<ul class="icons major">
								<li><span class="icon fa-diamond major style1"><span class="label">Lorem</span></span></li>
								<li><span class="icon fa-heart-o major style2"><span class="label">Ipsum</span></span></li>
								<li><span class="icon fa-code major style3"><span class="label">Dolor</span></span></li>
							</ul>
						</div>
					</section>

				<!-- Two -->
					<section id="two" class="wrapper alt style2">
						<section class="spotlight">
							<div class="image"><img src="images/pic01.jpg" alt="" /></div><div class="content">
								<h2>Cold Staking</h2>
								<p>
								Cold Staking lets users securely delegate staking powers to “staking nodes” which contain no coins. The purpose of these “staking nodes” is to provide a dedicated resource connected to a blockchain network and stake on behalf of another wallet without being able to spend its coins. In other words, it allows users to stake offline coins.
								</p>
							</div>
						</section>
						<section class="spotlight">
							<div class="image"><img src="images/pic02.jpg" alt="" /></div><div class="content">
								<h2>Benefits of staking</h2>
								<p>Staking enables coin holders to earn compounding rewards in return for freezing their staked coins so they cannot be otherwise used while they are being staked. Stack those coins!</p>
							</div>
						</section>
						<section class="spotlight">
							<div class="image"><img src="images/pic03.jpg" alt="" /></div><div class="content">
								<h2>Withdraw at anytime<br />
								No Penalties</h2>
								<p>Staked Coins aren't kept on the full node, so you and only you can withdraw your coins back to your wallet at anytime. No fee's or penalties.</p>
							</div>
						</section>
					</section>

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