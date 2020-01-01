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
						<li><a href="about.php">FAQ</a></li>
						<li><a href="https://github.com/thecrypt0hunter/node-installer" target="_blank">VPS Node Installer</a></li>
						<li><a href="https://github.com/thecrypt0hunter/CoreWallet/releases" target="_blank">Core Wallet Download</a></li>
						<li><a href="https://donations.trustaking.com/" target="_blank">Donations</a></li>
					</ul>
					<ul>
						<li><a href="how-to.php" style='color:green'> HOW-TO GUIDES</a></li>
						<li><a href="how-to.php#trustaking">Delegate to Trustaking</a></li>
						<li><a href="how-to.php#vps">Setup VPS</a></li>
						<li><a href="how-to.php#add-more">Add more coins</a></li>
						<li><a href="how-to.php#withdraw">Withdraw coins</a></li>
						<?php if ($whitelist == '1') { ?>
							<li><a href="check_expiry.php">Check my expiry date</a></li>
						<?php } ?>
					</ul>
			    </div>
			</li>
	        </ul>
    	</nav>
</header>