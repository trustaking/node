<?php
include('include/node-check.php');
if (isset($_POST['address'])) {
	$result = $coinFunctions->getAddressHistory($_POST['address']);
	$history = json_encode($result, JSON_PRETTY_PRINT);
}
?>
<?php include('include/header.php'); ?>
<?php include('include/menu.php'); ?>
<!-- Main -->
<article id="main">
	<header>
		<img src="images/coin_logo-<?php print $coinFunctions->config['ticker']; ?>.png" alt="" width="200" />
	</header>
	<section class="wrapper style5">
		<div class="inner">
			<section>
				<h3>Check My Expiry Date</h3>
		</div>
		<?php if (isset($_POST['address']) && isset($history)) { ?>
			<?php echo "<pre>" . $history . "<pre>"; ?>
		<?php } ?>
		<br />
		<form method="post" action="">
			<div class="col-24">
				<input type="text" name="address" id="address" value="" placeholder="address" />
			</div>
			<br />
			<div class="col-12">
				<ul class="actions">
					<li><input type="submit" value="Search" class="primary" /></li>
					<li><input type="reset" value="Reset" /></li>
				</ul>
			</div>
		</form>
	</section>
	</section>
</article>
<?php include('include/footer.php'); ?>