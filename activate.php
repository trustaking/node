<?php 
require_once ('include/config.php');
require ('include/functions.php');
$wallet = new phpFunctions_Wallet();

//Check if node is online before further checks
$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Node/status' ;
$check_server = $wallet->checkSite ($url);

if ( $check_server == '' || empty($check_server) ) {
$message = <<<EOD
<ul class="icons"><label class="icon fa-circle" style='font-size:16px;color:red'> Full Node is offline</label></ul>
EOD;
} else {

// Grab the next unused address 
$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Wallet/unusedaddress?WalletName='.$WalletName.'&AccountName='.$AccountName ;
$address = $wallet->CallAPI ($url);
//TODO: error trap the address

// Grab Staking info
$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Staking/getstakinginfo';
$stakinginfo = $wallet->CallAPI ($url);

if ($stakinginfo['staking']=1) {
$message = <<<EOD
<ul class="icons"><label class="icon fa-circle" style='font-size:16px;color:green'> Staking is online</label></ul>
EOD;
} else {
$message = <<<EOD
<ul class="icons"><label class="icon fa-circle" style='font-size:16px;color:red'> Staking is offline</label></ul>
EOD;
}
}
//Check if invoice paid
#$invoiceId   = 'CtT6BnSTimsH1kQaXZjkUC' ; //Testing only
$invoiceId   = 'Q7rqzgQ5Le81jsh5mxNbkQ' ;
$OrderPaid = $wallet->getInvoiceStatus ($invoiceId);
if ( $OrderPaid == 'FAIL' ) {
	die ('Payment not successful - please try again');
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

				<!-- Main -->
					<article id="main">
						<header>
							<img src="images/coin_logo-<?php print $ticker; ?>.png" alt="" width="200"/>
						</header>
							<section class="wrapper style5">
								<div class="inner">
								<h3>ORDER #<?php print $_GET['OrderID'];?></h3>
								<p>Thank you for your payment - before you get started, open your local wallet and ensure it's fully synced.</p><br>
								<p>Then open a terminal window and run the following script:</p>
								<pre><code>bash <( curl -s http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-setup.sh )</code></pre>
								<p>Here is your hot wallet address when prompted: <pre><code><?php print $address; ?></code></pre></p>
								<br/>
								<p>Run this script at any time to see your cold staking balance:</p>
								<pre><code>bash <( curl -s http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-balance.sh )</code></pre>
								<p>If you need to add funds at a later date use this command:</p>
								<pre><code>bash <( curl -s http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-add-funds.sh )</code></pre>
								<p>And finally, when you want to withdraw your funds use this command:</p>
								<pre><code>bash <( curl -s http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-withdraw-funds.sh )</code></pre>
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