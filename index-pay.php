<?php 
session_start(); 
require ('/var/secure/keys.php');
include('include/node-check.php');

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

$OrderID = $ticker . '-' . $wallet->crypto_rand(100000000000,999999999999);
?>
<?php include('include/header.php'); ?>
<?php include('include/menu.php'); ?>

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