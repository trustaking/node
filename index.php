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

if ( $check_server == '' || empty($check_server) ) {
$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:red'>Node offline</a></li>
EOD;
$enabled = <<<EOD
<a href="index.html" class="icon fa-circle" style="color:red">TRUSTAKING.COM </a>
EOD;
} else {

// Grab balance
$url = $scheme.'://'.$server_ip.':'.$api_port."/api/Wallet/balance?WalletName=$WalletName&AccountName=$AccountName";
$get_balance = $wallet->CallAPI ($url); 
	
if ( !is_array($get_balance) ) {
	die (' There was an error with your login parameters. Are your credentials correct?');
} else {
foreach($get_balance as $a => $b){
	foreach($b as $c => $d){
}
$bal = $d['amountConfirmed']/100000000;
}}

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
<li><a href=""class="icon fa-circle" style='color:green'>Staking: $bal</a></li>
EOD;
} else {
$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:red'>Staking offline</a></li>
EOD;
}
}
?>
<?php include('include/header-recap.php'); ?>
<?php include('include/menu.php'); ?>

<!-- Banner -->
<section id="banner">
	<div class="inner">
		<h2><img src="images/logo_transparent.png" alt="" width="150"/> <br/>TRUSTAKING.COM</h2>
		<p>The trusted home of <br />
		cold staking<br />
	</div>
		<form method="post" action="activate.php">
			<input type="hidden" name="recaptcha_response" id="recaptchaResponse">
			<input type="submit" class="button icon fa-shopping-cart" value="Cold Stake Now" />
		</form>
			<p><br />We have opened a crowdfund <a href="https://btcpay.trustaking.com/apps/3ZLoV6ywKzV1JTBdx6DXEBWHXSxe/crowdfund">here</a> to keep the service free of charge.<br />We are currently running testnet!</p>
			<a href="#main" class="more scrolly"></a>
</section>

<!-- Main -->
<article id="main">
<!-- One -->
	<section id="one" class="wrapper style1 special">
		<div class="inner">
			<header class="major">
				<h2>Full Node as a Service</h2>
				<p><b>Effortless cold staking with no technical knowledge required</b></p>
				<p>This service is being provided <b>free of charge</b> as we have decided to trial a donation/tips based business model. We will rely on these tips and donations as long as possible, giving everyone the opportunity to use cold staking. Hopefully, people will appreciate the service and donate on a regular basis so that we can keep the service running. We have opened a crowdfunding page <a href="https://btcpay.trustaking.com/apps/3ZLoV6ywKzV1JTBdx6DXEBWHXSxe/crowdfund">here</a> if you want to help.<p> 
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
				<p>Cold Staking lets users securely delegate staking powers to “staking nodes” which contain no coins. The purpose of these “staking nodes” is to provide a dedicated resource connected to a blockchain network and stake on behalf of another wallet without being able to spend its coins. In other words, it allows users to stake offline coins.</p>
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
<?php include('include/footer.php'); ?>