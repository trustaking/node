<?php
include('include/node-check.php');
include('include/header.php');
include('include/menu.php');
$_SESSION['session'] = 'Open';
$_SESSION['Price'] = 0.05;
$balance = 0;

if ($coinFunctions->config['exchange'] != '1') {
	$functions->web_redirect("index.php");
}

$displayPrice = new NumberFormatter("en", NumberFormatter::CURRENCY);

// Grab the balance in the hot wallet
$balance = $coinFunctions->getBalance();

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
						Exchange <?php echo $coinFunctions->config['ticker']; ?> for BTC </h4>
				</div>
				<div class="plan-price-box text-info">
					<span class="price"><?php echo $displayPrice->formatCurrency($_SESSION['Price'], "USD") . " per " . strtoupper($coinFunctions->config['ticker']); ?> </span>
				</div>
				<div class="panel-body pt-0">
					<h4 class="text-primary text-teal-800 mb-0">Details</h4>
					<ul class="mt-0 mb-0 text-info top-border-none plans-intro">
						<li>
							Total <?php echo strtoupper($coinFunctions->config['ticker']); ?> available: <span class="text-primary"><?php echo $balance; ?></span>
						</li>
						<li>
							Price per <?php echo strtoupper($coinFunctions->config['ticker']); ?>: <span class="text-primary"><span class="text-warning"><?php echo $displayPrice->formatCurrency($_SESSION['Price'], "USD"); ?></span></span>
						</li>
						<li>
						<form method="post" action="order_confirmation.php" name="bronze" id="bronze">
							<input name="Quantity" type="text" value="" placeholder="Enter Quantity required?">
							<input name="Address" type="text" value="" placeholder="Enter <?php echo strtoupper($coinFunctions->config['ticker']); ?> Address">
							<input type="hidden" name="action" value="payment">
							<br/>
							<input type="submit" name="submit" class="button primary small fitn" id="submit" onsubmit="return confirm('Do you really/n want this?')" value="Exchange Now">
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