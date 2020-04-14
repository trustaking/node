<?php 
include('include/node-check.php');

// Check session is live & exchange is available
if ($_SESSION['session'] != 'Open' || $coinFunctions->config['exchange'] != '1') {
	//Check session contains correct variables
	if (
		$_SESSION['Address'] == '' || empty($_SESSION['Address']) ||
		$_SESSION['Total'] == '' || empty($_SESSION['Total']) ||
		$_SESSION['Price'] == '' || empty($_SESSION['Price']) ||
		$_SESSION['Quantity'] == '' || empty($_SESSION['Quantity']) ||
		$_SESSION['session'] == '' || empty($_SESSION['session'])
	) {
		$functions->web_redirect("index.php");
	}
	$functions->web_redirect("index.php");
}
//Check if invoice paid
$OrderPaid = $functions->GetInvoiceStatus ($_SESSION['InvoiceID'],$_SESSION['OrderID']);

if ( $OrderPaid == 'FAIL' ) {
		print_r($OrderPaid);
		echo "<br/>" . $_SESSION['InvoiceID'] . "<br/>";		
		echo "<br/>" . $_SESSION['OrderID'] . "<br/>";
		exit ('Payment not successful - please try again');
	} 

// TODO Transfer $_SESSION['Total'] to $_SESSION['Address']

// Set whitelist $_SESSION['Address'] with expiry date = $_SESSION['Expiry']

if ($coinFunctions->config['whitelist'] == '1') {

	$params = [
	'walletName' => $WalletName,
	'address' => $_SESSION['Address'],
	'stakingExpiry' => $_SESSION['Expiry'],
	];

	$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Staking/stakingExpiry';
	$result = $functions->CallAPIParams ($url,"POST",$params);
	if ( $result != '' || !empty($result) ) {
		echo '<pre>' . json_encode($result,JSON_PRETTY_PRINT) . '</pre>' ;
		echo "<br/><pre>" . $url . "</pre><br/>";
		exit (' Something went wrong checking the node! - please try again in a new tab it could just be a timeout.');
	}

	// Restart Staking TODO - Decide if this is a daily restart at node level during testing
	$url = $scheme.'://'.$server_ip.':'.$api_port.'api/Staking/stopstaking?true';
	$result = $functions->CallAPI ($url,"POST");
	$url = $scheme.'://'.$server_ip.':'.$api_port.'api/Staking/startstaking?password='.$WalletPassword.'&name='.$WalletName;
	$result = $functions->CallAPI ($url,"POST");

}
?>
<?php include('include/header.php'); ?>
<?php include('include/menu.php'); ?>
<!-- Main -->
<article id="main">
	<header>
		<img src="images/coin_logo-<?php print $coinFunctions->config['ticker']; ?>.png" alt="" width="200"/>
	</header>
	<section class="wrapper style5">
		<div class="inner">
			<?php if ($coinFunctions->config['payment'] == '1' && $_SESSION['Plan']!='0') { ?>
				<h3>ORDER #<?php print $_SESSION['OrderID'];?></h3><p>Thank you for your payment!</p><br>
			<?php } else { ?>
				<h3>Thankyou for using Trustaking.com</h3><p>Please consider giving a donation <a href="https://donations.trustaking.com/">here</a></p><br>
			<?php }; ?>
			<p>Before you get started, open your local wallet and ensure it's fully synced. Then follow the instructions in your local wallet.</p>
			<p>Here is your personal cold staking address: <pre><code><?php print $_SESSION['Address']; ?></code></pre></p>
			<p><b>IMPORTANT ... DO NOT SEND COINS DIRECTLY TO THIS ADDRESS</b> ... its for cold staking only </br></br>
			If you're in any doubt ... ask for help in Discord.</p>
		</div>
	</section>
</article>
<?php include('include/footer.php'); ?>