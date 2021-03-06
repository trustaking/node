<?php 
include('include/node-check.php');
include('include/header.php');
include('include/menu.php');

// Check session is live
if ( $_SESSION['session'] != 'Open' || $_SESSION['Address'] == '' || empty($_SESSION['Address']) ){
   $functions->web_redirect ("index.php");
}

//If payments are active, check if invoice paid

if ($coinFunctions->config['payment'] == '1' && $_SESSION['Plan'] != '0') {

	if ( $_SESSION['Address'] == ''   || empty($_SESSION['Address'])	|| 
		 $_SESSION['OrderID'] == ''   || empty($_SESSION['OrderID'])	|| 
		 $_SESSION['Price'] == ''     || empty($_SESSION['Price'])		|| 
		 $_SESSION['Expiry'] == ''    || empty($_SESSION['Expiry'])		|| 
		 $_SESSION['InvoiceID'] == '' || empty($_SESSION['InvoiceID'])) 
		{
			$functions->web_redirect ("index.php");
		}

	$OrderPaid = $functions->GetInvoiceStatus ($_SESSION['InvoiceID'],$_SESSION['OrderID']);

	if ( $OrderPaid == 'FAIL' ) {
		// print_r($OrderPaid);
		// echo "<br/>" . $_SESSION['InvoiceID'] . "<br/>";		
		// echo "<br/>" . $_SESSION['OrderID'] . "<br/>";
		exit ('Payment not successful - please try again');
	} 
	
}

// Set whitelist to $_SESSION['Address'] with expiry date = $_SESSION['Expiry']

if ($coinFunctions->config['whitelist'] == '1') {

	$result = $coinFunctions->setStakingExpiry($_SESSION['Address'],$_SESSION['Expiry']);
	if ( $result != '' || !empty($result) ) {
		echo '<pre>' . json_encode($result,JSON_PRETTY_PRINT) . '</pre>' ;
		echo "<br/><pre>" . $url . "</pre><br/>";
		exit (' Something went wrong checking the node! - please try again in a new tab it could just be a timeout.');
	}

}
?>
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
				<h3>Thankyou for using Trustaking.com</h3><p>Please consider giving a donation <a href="https://donations.trustaking.com/"><b><u>here</b></u></a></p>
			<?php }; ?>
			<p>For a step by step tutorial, check out our how-to guide by visiting this
				<?php if ($coinFunctions->config['howtourl'] != '') { ?> 
					<a href="<?php print $coinFunctions->config['howtourl'];?>" target="_blank"><b><u>page</b></u></a>
					 <?php } else {?>
						<a href="how-to.php#trustaking"><b><u>page</b></u></a>
				<?php } ?>
			</p>
			<p>Here is your personal Trustaking address: <pre><code><?php print $_SESSION['Address']; ?></code></pre></p>
			<p><b>IMPORTANT ... DO NOT SEND COINS DIRECTLY TO THIS ADDRESS</b> ... its for cold staking only </br></br>
			If you're in any doubt ... ask for help in Discord.</p>
		</div>
	</section>
</article>
<?php include('include/footer.php'); ?>