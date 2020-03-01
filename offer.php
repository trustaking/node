<?php
session_start();
include('include/node-check.php');
include('include/header.php');
include('include/menu.php');
$_SESSION['Session'] = 'Open';
$_SESSION['Price'] = 0.05;

$displayPrice = new NumberFormatter("en", NumberFormatter::CURRENCY);

// Grab the balance in the hot wallet
$url = $scheme . "://" . $server_ip . ":" . $api_port . "/api/Wallet/balance?WalletName=$WalletName&AccountName=$HotAccountName";
$get_balance = $wallet->CallAPI($url, "GET");

if (!is_array($get_balance)) {
	print_r($get_balance);
	echo "<br/>" . $url . "<br/>";
	exit (' There was an error with your login parameters. Are your credentials correct?');
} else {
	foreach ($get_balance as $a => $b) {
		foreach ($b as $c => $d) {
		}
		//TODO: check that balance is returned and thow an error
		$bal = floor($d['amountConfirmed'] / 100000000);
	}
}

?>

<!-- Banner -->
<section id="banner">
	<div class="inner">
		<h2><img src="images/logo_transparent.png" alt="" width="150" /> <br />TRUSTAKING.COM <br />EXCHANGE</h2>
	</div>
</section>

<!-- Main -->
<article id="main">
	<div class="subscription-plans">
		<div class="plan-box-center">
			<div class="panel panel-plan box-active">
				<div class="panel-heading" style="background-color: #cd7f32; color: white">
					<h4 class="panel-title text-center">
						Exchange <?php echo $ticker; ?> for BTC </h4>
				</div>
				<div class="plan-price-box text-info">
					<span class="price"><?php echo $displayPrice->formatCurrency($_SESSION['Price'], "USD") . " per " . strtoupper($ticker); ?> </span>
				</div>
				<div class="panel-body pt-0">
					<h4 class="text-primary text-teal-800 mb-0">Details</h4>
					<ul class="mt-0 mb-0 text-info top-border-none plans-intro">
						<li>
							Total <?php echo strtoupper($ticker); ?> available: <span class="text-primary"><?php echo $bal; ?></span>
						</li>
						<li>
							Price per <?php echo strtoupper($ticker); ?>: <span class="text-primary"><span class="text-warning"><?php echo $displayPrice->formatCurrency($_SESSION['Price'], "USD"); ?></span></span>
						</li>
						<li>
						<form method="post" action="buy.php" name="bronze" id="bronze">
							<input name="Quantity" type="text" value="" placeholder="Enter Quantity required?">
							<input name="Address" type="text" value="" placeholder="Enter <?php echo strtoupper($ticker); ?> Address">
							<input type="hidden" name="action" value="payment">
							<br/>
							<input type="submit" class="button primary small fitn" value="Exchange Now">
						</form>
					</li>

					</ul>

				</div>
				<div class="panel-footer pt-10 pb-10 text-center">
				</div>
			</div>
		</div>

</article>

<?php include('include/footer.php'); ?>