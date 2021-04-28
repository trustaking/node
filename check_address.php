<?php
include('include/node-check.php');
if (isset($_POST['address'])) {
	$result = $coinFunctions->getAddressBalance($_POST['address']);
	$balance = json_encode($result, JSON_PRETTY_PRINT);
	if (isset($balance)) {
		$result = $coinFunctions->getAddressHistory($_POST['address']);
		$history = json_encode($result, JSON_PRETTY_PRINT);
	}
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
				<h3>Check My Address</h3>
		</div>
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
	<br />
	<?php if (isset($_POST['address']) && isset($balance)) { ?>
			<?php echo "<pre>" . $balance . "<pre>"; ?>
		<?php } ?>
	<br />
	<?php if (isset($_POST['address']) && isset($history)) { ?>
			<?php echo "<pre>" . $history . "<pre>"; ?>
		<?php } ?>
	</section>
</article>
<?php include('include/footer.php'); ?>