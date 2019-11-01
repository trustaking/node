<?php 
session_start();
require ('/var/secure/keys.php');
include('include/node-check.php');
$isWin = $wallet->isWindows();

if ( $_SESSION['Address'] == '' || empty($_SESSION['Address']) || 
	 $_SESSION['OrderID'] == '' || empty($_SESSION['OrderID']) || 
	 $_SESSION['Price'] == '' || empty($_SESSION['Price']) || 
	 $_SESSION['Days_Online'] == '' || empty($_SESSION['Days_Online']) || 
	 $_SESSION['InvoiceID'] == '' || empty($_SESSION['InvoiceID']) ) {
		$wallet->web_redirect ("index.php");	
}

//Check if invoice paid
$OrderPaid = $wallet->GetInvoiceStatus ($_SESSION['InvoiceID'],$_SESSION['OrderID']);
if ( $OrderPaid == 'FAIL' ) {
	die ('Payment not successful - please try again');
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
			<p>Thank you for your payment - before you get started, open your local wallet and ensure it's fully synced. Then follow the instructions in your local wallet.</p><br>
			<p>Here is your hot wallet address when prompted: <pre><code><?php print $_SESSION['Address']; ?></code></pre></p>
		</div>
	</section>
</article>
<?php include('include/footer.php'); ?>