<?php 
session_start();
require_once ('include/config.php');
require ('include/functions.php');
$wallet = new phpFunctions_Wallet();
$isWin = $wallet->isWindows();

if ( $_SESSION['Address'] == '' || empty($_SESSION['Address']) || 
	 $_SESSION['OrderID'] == '' || empty($_SESSION['OrderID']) || 
	 $_SESSION['Price'] == '' || empty($_SESSION['Price']) || 
	 $_SESSION['Days_Online'] == '' || empty($_SESSION['Days_Online']) || 
	 $_SESSION['InvoiceID'] == '' || empty($_SESSION['InvoiceID']) ) {
	die (' The session has expired - please try again.');
}

//Check if node is online before further checks
$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Node/status' ;
$check_server = $wallet->checkSite ($url);

if ( $check_server == '' || empty($check_server) ) {
$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:red'>Node offline</a></li>
EOD;
} else {
// Get Node Staking Details
$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Staking/getstakinginfo';
$get_stakinginfo = $wallet->CallAPI ($url); 

if ( !is_array($get_stakinginfo) ) {
	die (' There was an error connecting with the full node.');
}


if ($get_stakinginfo['enabled']>0) {
$enabled = <<<EOD
<a href="index.html" class="icon fa-circle" style="color:green">TRUSTAKING.COM</a>
EOD;
} else {
$enabled = <<<EOD
<a href="index.html" class="icon fa-circle" style="color:red">TRUSTAKING.COM </a>
EOD;
}

if ($get_stakinginfo['staking']>0) {
$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:green'>Staking online</a></li>
EOD;
} else {
$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:red'>Staking offline</a></li>
EOD;
}
}

//Check if invoice paid
$OrderPaid = $wallet->GetInvoiceStatus ($_SESSION['InvoiceID'],$_SESSION['OrderID']);
if ( $OrderPaid == 'FAIL' ) {
	die ('Payment not successful - please try again');
}

?>
<?php include('include/header.php'); ?>
<?php include('include/menu.php'); ?>
<!-- Main -->
<article id="main">
	<header>
		<img src="images/coin_logo-<?php print $ticker; ?>.png" alt="" width="200"/>
	</header>
	<section class="wrapper style5">
		<div class="inner">
			<h3>ORDER #<?php print $_SESSION['OrderID'];?></h3>
			<p>Thank you for your payment - before you get started, open your local wallet and ensure it's fully synced.</p><br>
			<?php if(!$isWin) { ?>
				<p>Then open a terminal window and run the following script and follow the prompts:</p>
				<pre><code>bash <( curl -s http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-setup.sh )</code></pre>
				<p>Here is your hot wallet address when prompted: <pre><code><?php print $_SESSION['Address']; ?></code></pre></p>
				<br/>
				<p>Run this script at any time to see your cold staking balance:</p>
				<pre><code>bash <( curl -s http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-balance.sh )</code></pre>
				<p>If you need to add funds at a later date use this command:</p>
				<pre><code>bash <( curl -s http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-add-funds.sh )</code></pre>
				<p>And finally, when you want to withdraw your funds use this command:</p>
				<pre><code>bash <( curl -s http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-withdraw-funds.sh )</code></pre>
			<?php } else { ?>
				<p>Then open a Powershell window and run the following script and follow the prompts:</p>
				<pre><code>iex ((New-Object System.Net.WebClient).DownloadString('http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-setup.ps1'))</code></pre>
				<p>Here is your hot wallet address when prompted: <pre><code><?php print $_SESSION['Address']; ?></code></pre></p>
				<br/>
				<p>Run this script at any time to see your cold staking balance:</p>
				<pre><code>iex ((New-Object System.Net.WebClient).DownloadString('http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-balance.ps1'))</code></pre>
				<p>If you need to add funds at a later date use this command:</p>
				<pre><code>iex ((New-Object System.Net.WebClient).DownloadString('http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-add-funds.ps1'))</code></pre>
				<p>And finally, when you want to withdraw your funds use this command:</p>
				<pre><code>iex ((New-Object System.Net.WebClient).DownloadString('http://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-withdraw-funds.ps1'))</code></pre>
			<?php } ?>
		</div>
	</section>
</article>
<?php include('include/footer.php'); ?>