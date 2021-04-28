<!-- Header -->
<header id="header" class="alt">
	<h1><?php print $enabled;?></h1>
   		<nav id="nav">
	        <ul>
		        <li class="special">
			    <a href="#menu" class="menuToggle"><span>Menu</span></a>
			    <div id="menu">
			        <ul>
			            <?php print $message;?>
			            <li><a href="index.php">Home</a></li>
						<li><a href="https://donations.trustaking.com/" target="_blank">Donations</a></li>
						<li><a href="about.php">FAQ</a></li>
<!--						<li><a href="check_address.php">Check my address</a></li>
-->
						 <?php if ($coinFunctions->config['rewardsurl'] != '') { ?>
							<li><a href="<?php print $coinFunctions->config['rewardsurl'];?>" target="_blank">Staking Calculator</a></li>
						<?php } ?>
						<?php if ($coinFunctions->config['whitelist'] == '1') { ?>
							<li><a href="check_expiry.php">Check my expiry date</a></li>
						<?php } ?>
						<?php if ($coinFunctions->config['exchange'] == '1') { ?>
							<li><a href="order.php">Exchange</a></li>
						<?php } ?>
					</ul>
					<ul>
						<li><a href="#" style='color:green'> DOWNLOADS</a></li>
						<?php if ($coinFunctions->config['vpsurl'] != '') { ?>
							<li><a href="<?php print $coinFunctions->config['vpsurl'];?>" target="_blank">VPS Node Installer</a></li>
						<?php } ?>
						<?php if ($coinFunctions->config['walleturl'] != '') { ?>
							<li><a href="<?php print $coinFunctions->config['walleturl'];?>" target="_blank">Download Wallet</a></li>
						<?php } ?>
					</ul>
					<ul>
					<?php if ($coinFunctions->config['howtourl'] != '') { ?>
						<li><a href="#" style='color:green'> HOW-TO GUIDES</a></li>
							<li><a href="<?php print $coinFunctions->config['howtourl'];?>" target="_blank">Delegate to Trustaking</a></li>
						<?php if ($coinFunctions->config['howtovpsurl'] != '') { ?>
							<li><a href="<?php print $coinFunctions->config['howtovpsurl'];?>" target="_blank">Setup VPS</a></li>
						<?php } ?>
						<?php if ($coinFunctions->config['addurl'] != '') { ?>
							<li><a href="<?php print $coinFunctions->config['addurl'];?>" target="_blank">Add more coins</a></li>
						<?php } ?>
						<?php if ($coinFunctions->config['withdrawurl'] != '') { ?>
							<li><a href="<?php print $coinFunctions->config['withdrawurl'];?>" target="_blank">Withdraw coins</a></li>
						<?php } ?>
					<?php } ?>
					</ul>
			    </div>
			</li>
	        </ul>
    	</nav>
</header>