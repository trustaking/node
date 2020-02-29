<?php 
session_start(); 
include('include/node-check.php');

$_SESSION['Session'] = 'Open';

?>
<?php include('include/header-recap.php'); ?>
<?php include('include/menu.php'); ?>


<!-- Banner -->
<section id="banner">
	<div class="inner">
		<h2><img src="images/logo_transparent.png" alt="" width="150"/> <br/>TRUSTAKING.COM</h2>
		<p>The trusted home of <br />
		cold staking<br />
	</div>
	<p><br />Choose your purchase</p>
	<a href="#main" class="more scrolly"></a>
	</section>
<!-- Main -->
<article id="main">
	<div class="subscription-plans">
		<div class="plan-box-center">
			<div class="panel panel-plan box-active">
				<div class="panel-heading" style="background-color: #cd7f32; color: white">
					<h4 class="pull-left panel-title text-center">													
						Bronze </h4>
				</div>
				<div class="plan-price-box text-info">
					<span class="price">$2</span> / month
				</div>
			<div class="panel-body pt-0">
			<h4 class="text-primary text-teal-800 mb-0">Features</h4>
				<ul class="mt-0 mb-0 text-info top-border-none plans-intro">
					<li>
					Duration: <span class="text-primary">1 month</span>
					</li>
					<li>
						Expiration: <span class="text-primary"><?php echo date("d-M-Y",strtotime("+1 month")) ?></span>
					</li>
					<li>
						Price: <span class="text-primary"><span class="text-warning">$2</span></span>
					</li>
				</ul>
			</div>
			<div class="panel-footer pt-10 pb-10 text-center">	
			<form method="post" action="invoice.php" name="bronze" id="bronze">
				<input type="hidden" name="recaptcha_response" id="recaptchaResponse1">
				<input type="hidden" name="action" value="payment">
				<input type="hidden" name="Plan" value="1">
				<input type="submit" class="button primary small fitn" value="Select Plan" />
			</form>
			</div>
		</div>		
	</div>
	<div class="plan-box-center">
		<div class="panel panel-plan box-active">
			<div class="panel-heading" style="background-color: silver; color: white">
				<h4 class="pull-left panel-title text-center">Silver</h4>
			</div>
			<div class="plan-price-box text-info">
				<span class="price">$1.50</span> / month
			</div>
			<div class="panel-body pt-0">
				<h4 class="text-primary text-teal-800 mb-0">Features</h4>
				<ul class="mt-0 mb-0 text-info top-border-none plans-intro">
				<li>
						Duration: <span class="text-primary">6 month</span>
					</li>
					<li>
						Expiration: <span class="text-primary"><?php echo date("d-M-Y",strtotime("+6 months")) ?></span>
					</li>
					<li>
						Price: <span class="text-primary"><span class="text-warning">$9</span></span>
					</li>
				</ul>
			</div>
			<div class="panel-footer pt-10 pb-10 text-center">	
				<form method="post" action="invoice.php" name="silver" id="silver">
					<input type="hidden" name="recaptcha_response" id="recaptchaResponse2">
					<input type="hidden" name="action" value="payment">
					<input type="hidden" name="Plan" value="2">
					<input type="submit" class="button primary small fitn" value="Select Plan" />
				</form>
			</div>
		</div>	
	</div>
	<div class="plan-box-center">
		<div class="panel panel-plan box-active">
			<div class="panel-heading" style="background-color: gold; color: white">
				<h4 class="pull-left panel-title text-center">													
					Gold
				</h4>
			</div>
			<div class="plan-price-box text-info">
				<span class="price">$1</span> / month
			</div>
			<div class="panel-body pt-0">
				<h4 class="text-primary text-teal-800 mb-0">Features</h4>
				<ul class="mt-0 mb-0 text-info top-border-none plans-intro">
					<li>
						Duration: <span class="text-primary">12 month</span>
					</li>
					<li>
						Expiration: <span class="text-primary"><?php echo date("d-M-Y",strtotime("+12 months")) ?></span>
					</li>
					<li>
						Price: <span class="text-primary"><span class="text-warning">$12</span></span>
					</li>
				</ul>
			</div>
	<div class="panel-footer pt-10 pb-10 text-center">	
		<form method="post" action="invoice.php" name="gold" id="gold">
			<input type="hidden" name="recaptcha_response" id="recaptchaResponse3">
			<input type="hidden" name="action" value="payment">
			<input type="hidden" name="Plan" value="3">
			<input type="submit" class="button primary small fitn" value="Select Plan" />
		</form>
	</div>
	</div>   
		</div>
		<div class="plan-box-center">
			<div class="panel panel-plan box-active">
					<div class="panel-heading" style="background-color: #008c6e; color: white">
						<h4 class="pull-left panel-title text-center">													
							Free Trial
						</h4>
					</div>
					<div class="plan-price-box text-info">
						<span class="price">Free</span>	
					</div>
			<div class="panel-body pt-0">
				<h4 class="text-primary text-teal-800 mb-0">Features</h4>
				<ul class="mt-0 mb-0 text-info top-border-none plans-intro">
					<li>
						Duration: <span class="text-primary">1 week</span>
					</li>
					<li>
						Expiration: <span class="text-primary"><?php echo date("d-M-Y",strtotime("+1 week")) ?></span>
					</li>
					<li>
						Price: <span class="text-primary"><span class="text-warning">$0</span></span>
					</li>
				</ul>
			</div>
				<div class="panel-footer pt-10 pb-10 text-center">	
					<form method="post" action="invoice.php" name="free" id="free">
						<input type="hidden" name="recaptcha_response" id="recaptchaResponse4">
						<input type="hidden" name="action" value="payment">
						<input type="hidden" name="Plan" value="0">
						<input type="submit" class="button primary small fitn" value="Select Plan" />
					</form>
				</div>
			</div>
		</div>
	</section>
</article>

<?php include('include/footer.php'); ?>