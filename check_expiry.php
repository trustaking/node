<?php
include('include/node-check.php');

if (isset($_POST['address'])) {
	if ($coinFunctions->config['whitelist'] == '1') {
		$expires = $coinFunctions->getStakingExpiry($_POST['address']);
	}
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
				<section>
					<h3>Check My Expiry Date</h3>
				</div>
				<?php if ( isset($_POST['address']) && isset($expires) ){?>
				<div class="table-wrapper">
					<table>
							<thead>
								<tr>
									<th>Address</th>
									<th>Expiry</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $_POST['address'];?></td>
									<td><?php echo $expires;?></td>
								</tr>
							</tbody>
							<tfoot>
							</tfoot>
						</table>
				<?php } ?> <br />
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