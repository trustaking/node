<?php 
session_start();
require ('/var/secure/keys.php');
include('include/node-check.php');

if ( $_SESSION['Address'] == '' || empty($_SESSION['Address']) || 
	 $_SESSION['OrderID'] == '' || empty($_SESSION['OrderID']) || 
	 $_SESSION['Price'] == '' || empty($_SESSION['Price']) || 
	 $_SESSION['Expiry'] == '' || empty($_SESSION['Expiry']) || 
	 $_SESSION['InvoiceID'] == '' || empty($_SESSION['InvoiceID']) ) {
		$wallet->web_redirect ("index.php");	
}

//Check if invoice paid
$OrderPaid = $wallet->GetInvoiceStatus ($_SESSION['InvoiceID'],$_SESSION['OrderID']);
if ( $OrderPaid == 'FAIL' ) {
	die ('Payment not successful - please try again');
} else {

	// Set whitelist $_SESSION['Address'] with expiry date = $_SESSION['Expiry']
	$address=$_SESSION['Address'];
	$expiry = $_SESSION['Expiry'];
    $url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Staking/stakingExpiry?walletName='.$WalletName.'&address='.$address.'&stakingExpiry='.$expiry;
    $result = $wallet->CallAPI ($url);
    if ( $result != '' || !empty($result) ) {
        die (' Something went wrong checking the node! - please try again in a new tab it could just be a timeout.');
    }

	// Restart Staking
    $url = $scheme.'://'.$server_ip.':'.$api_port.'api/Staking/stopstaking?true';
    $result = $wallet->CallAPI ($url);
    $url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Staking/stakingExpiry?password='.$WalletPassword.'&name='.$WalletName;
    $result = $wallet->CallAPI ($url);
}

?>
<?php include('include/header.php'); ?>
<?php include('include/menu.php'); ?>
<!-- Main -->
<article id="main">
	<header>
		<img src="images/coin_logo-<?php print $ticker; ?>.png" alt="" width="200"/>
	</header>
	<section class="wrapper style5">
		<div class="inner">
			<h3>ORDER #<?php print $_SESSION['OrderID'];?></h3>
			<p>Thank you for your payment - before you get started, open your local wallet and ensure it's fully synced. Then follow the instructions in your local wallet.</p>
			<p>Here is your hot wallet address when prompted: <pre><code><?php print $_SESSION['Address']; ?></code></pre></p>
			<p><b>IMPORTANT ... DO NOT SEND COINS DIRECTLY TO THIS ADDRESS</b> ... its for cold staking only - if you're not sure ask for help in Discord.<p>
		</div>
	</section>
</article>
<?php include('include/footer.php'); ?>