<?php 
session_start();
require ('/var/secure/keys.php');
include('include/node-check.php');
$isWin = $wallet->isWindows();
// Deal with the bots first
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
    // Build POST request:
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_response = $_POST['recaptcha_response'];
    // Make and decode POST request:
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $captcha_secret_key . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);
    if($recaptcha->success==true){
    	// Take action based on the score returned:
        if ($recaptcha->score >= 0.5) {
			$verified=true;
         } else {
            $verified=false;
            die (" Recaptcha thinks you're a bot! - please try again in a new tab.");
        }
      } else { // there is an error /
        die (' Something went wrong with Recaptcha! - please try again in a new tab.');
    }
}

//Check Session is still alive

if (//$_SESSION['OrderID'] == '' || empty($_SESSION['OrderID']) || 
	$_SESSION['Price'] == '' || empty($_SESSION['Price']) || 
	$_SESSION['Days_Online'] == '' || empty($_SESSION['Days_Online'])) {
  	die (' The session has expired - please try again.');
}

// Grab the next unused address 
$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Wallet/unusedaddress?WalletName='.$WalletName.'&AccountName='.$AccountName.$api_ver ;
$address = $wallet->CallAPI ($url);
if ( $address == '' || empty($address) ) {
    die (' Something went wrong checking the node! - please try again in a new tab it could just be a timeout.');
  } else {
    $_SESSION['Address']=$address;
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
		<h3>ACTIVATE COLD STAKING</h3>
			<p>Before you get started, open your local wallet and ensure it's fully synced.</p><br>
			<?php if(!$isWin) { ?>
				<p>Then open a terminal window and run the following script and follow the prompts:</p>
				<pre><code>bash <( curl -s https://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-setup.sh )</code></pre>
				<p>Here is your hot wallet address when prompted: <pre><code><?php print $_SESSION['Address']; ?></code></pre></p>
				<br/>
				<p>If you need to add funds at a later date use this command:</p>
				<pre><code>bash <( curl -s https://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-add-funds.sh )</code></pre>
				<p>And finally, when you want to withdraw your funds use this command:</p>
				<pre><code>bash <( curl -s https://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-withdraw-funds.sh )</code></pre>
			<?php } else { ?>
				<p>Then open a Powershell window and run the following script and follow the prompts:</p>
				<pre><code>iex ((New-Object System.Net.WebClient).DownloadString('https://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-setup.ps1'))</code></pre>
				<p>Here is your hot wallet address when prompted: <pre><code><?php print $_SESSION['Address']; ?></code></pre></p>
				<br/>
				<p>If you need to add funds at a later date use this command:</p>
				<pre><code>iex ((New-Object System.Net.WebClient).DownloadString('https://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-add-funds.ps1'))</code></pre>
				<p>And finally, when you want to withdraw your funds use this command:</p>
				<pre><code>iex ((New-Object System.Net.WebClient).DownloadString('https://<?php print $ticker; ?>.trustaking.com/scripts/trustaking-cold-wallet-withdraw-funds.ps1'))</code></pre>
			<?php } ?>
		</div>
	</section>
</article>
<?php include('include/footer.php'); ?>