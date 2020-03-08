<?php
session_start();
include('include/node-check.php');
include('include/header.php');	
include('include/menu.php');

$displayPrice = new NumberFormatter("en", NumberFormatter::CURRENCY);
$displayTotal = new NumberFormatter("en", NumberFormatter::CURRENCY);

// Check session is live & exchange is available
if ( $_SESSION['Session'] != 'Open' || $exchange != '1') {
	// Set price and and Expiry based on plan number
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Quantity']) && isset($_POST['Address'])) {
		$_SESSION['Quantity'] = $_POST["Quantity"]; // Grab quantity and add to session
		$_SESSION['Address'] = $_POST["Address"]; // Grab address and add to session
	} else {
		$functions->web_redirect("index.php"); //otherwise redirect to homepage
	}
	$functions->web_redirect("index.php");
}

$_SESSION['Total'] = $_SESSION['Quantity'] * $_SESSION['Price'];

?>
<!-- Main -->
<article id="main">
	<header>
		<h2>Confirmation</h2>
	</header>

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
							Total <?php echo strtoupper($ticker); ?> requested: <span class="text-primary"><?php echo $_SESSION['Quantity']; ?></span>
						</li>
						<li>
							Price per <?php echo strtoupper($ticker); ?>: <span class="text-primary"><span class="text-warning"><?php echo $displayPrice->formatCurrency($_SESSION['Price'], "USD"); ?></span></span>
						</li>
						<li>
						<li>
							Total Cost in BTC: <span class="text-primary"><span class="text-warning"><?php echo $displayTotal->formatCurrency($_SESSION['Total'], "USD"); ?></span></span>
						</li>
						<li>
							<?php echo strtoupper($ticker); ?> Address: <span class="text-primary"><span class="text-warning"><?php echo $_SESSION['Address']; ?></span></span>
						</li>

						<form method="post" action="buy.php" name="bronze" id="bronze">
							<input type="submit" name="submit" class="button primary small fitn" id="submit" value="Exchange Now">
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
<input type="submit" class="button primary small fitn" value="Exchange Now">