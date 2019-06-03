<?php 
session_start();
require ('include/config.php');
require ('include/functions.php');
require ('/var/secure/keys.php');
$wallet = new phpFunctions_Wallet();

    // Deal with the bots first
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
    
        // Build POST request:
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_response = $_POST['recaptcha_response'];
    
        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $captcha_secret_key . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        if($recaptcha->success==true){

            // Take action based on the score returned:
            if ($recaptcha->score >= 0.5) {
                    $verified=true;
            } else {
                    $verified=false;
                    die (' Something went wrong! - please try again.');
            }
        } else { // there is an error /
            die (' Something went wrong! - please try again.');
        }
    }

	//Check Session is still alive

	if (//$_SESSION['OrderID'] == '' || empty($_SESSION['OrderID']) || 
	$_SESSION['Price'] == '' || empty($_SESSION['Price']) || 
	$_SESSION['Days_Online'] == '' || empty($_SESSION['Days_Online'])) {
  		 die (' The session has expired - please try again.');
	}

    //Check if node is online before and grab address before taking payment
    $url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Node/status' ;
    $check_server = $wallet->checkSite ($url);

	if ( $check_server == '' || empty($check_server) ) {
	$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:red'>Node offline</a></li>
EOD;
	} else {

// Get Node Staking Details
$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Staking/getstakinginfo';
$get_stakinginfo = $wallet->CallAPI ($url); 

if ( !is_array($get_stakinginfo) ) {
	die (' There was an error with your API parameters.');
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
    // Grab the next unused address 
    $url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Wallet/unusedaddress?WalletName='.$WalletName.'&AccountName='.$AccountName ;
    $address = $wallet->CallAPI ($url);
    if ( $address == '' || empty($address) ) {
        die (' Something went wrong! - please try again.');
    } else {
        $_SESSION['Address']=$address;
        }
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
						<h1><?php print $enabled;?></h1>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
										<?php print $message;?>
											<li><a href="index.php">Home</a></li>
											<li><a href="about.html">FAQ</a></li>
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
								<h3>ACTIVATE COLD STAKING</h3>
								<p>Before you get started, open your local wallet and ensure it's fully synced.</p><br>
								<p>Then open a terminal window and run the following script and follow the prompts:</p>
								<?php if(!isWindows()) { ?>
									<pre><code>bash <( curl -s http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-setup<?php print $ext ?> )</code></pre>
									<p>Here is your hot wallet address when prompted: <pre><code><?php print $_SESSION['Address']; ?></code></pre></p>
									<br/>
									<p>Run this script at any time to see your cold staking balance:</p>
									<pre><code>bash <( curl -s http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-balance.sh )</code></pre>
									<p>If you need to add funds at a later date use this command:</p>
									<pre><code>bash <( curl -s http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-add-funds.sh )</code></pre>
									<p>And finally, when you want to withdraw your funds use this command:</p>
									<pre><code>bash <( curl -s http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-withdraw-funds.sh )</code></pre>
								<?php 
								} else { 
								?>
									<pre><code>iex ((New-Object System.Net.WebClient).DownloadString('http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-setup.ps1'))</code></pre>
									<p>Here is your hot wallet address when prompted: <pre><code><?php print $_SESSION['Address']; ?></code></pre></p>
									<br/>
									<p>Run this script at any time to see your cold staking balance:</p>
									<pre><code>iex ((New-Object System.Net.WebClient).DownloadString('http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-balance.ps1'))</code></pre>
									<p>If you need to add funds at a later date use this command:</p>
									<pre><code>iex ((New-Object System.Net.WebClient).DownloadString('http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-add-funds.ps1'))</code></pre>
									<p>And finally, when you want to withdraw your funds use this command:</p>
									<pre><code>iex ((New-Object System.Net.WebClient).DownloadString('http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-withdraw-funds.ps1'))</code></pre>
								<?php } ?>
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