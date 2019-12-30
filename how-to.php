<?php include('include/node-check.php'); ?>
<?php include('include/header.php'); ?>
<?php include('include/menu.php'); ?>
<!-- Main -->

<link rel="stylesheet" href="assets/css/vendor.bundle.css?ver=142">
<link rel="stylesheet" href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/23500/nextparticle-documentation.css">
<link rel="stylesheet" href="assets/css/style.css?ver=142">
<link rel="stylesheet" href="assets/css/theme.css?ver=142">
<link rel="stylesheet" href="assets/css/vendor/hover-min.css">
<link rel="stylesheet" href="assets/css/custom.css">
<link rel="stylesheet" href="assets/css/responsive.css">

<article id="main">
<section id="what-is-cold-staking" class="section-pad mt-1 pb-5 section section-cold-stake">
<div class="container">
<div class="row text-center">
<div class="col-12 col-md-6">
<div class="section-head pt-5">
<h2 class="section-title animated" data-animate="fadeInUp" data-delay="0">What is cold staking?
<span>Solaris</span>
</h2>
<p class="animated" data-animate="fadeInUp" data-delay=".1">
Staking Solaris coins strengthens the network and you get rewarded for finding blocks.
Cold staking is a safer way to stake your XLR coins. </p>
<p class="animated" data-animate="fadeInUp" data-delay=".2">Cold Staking allows you to safely store the coins in your wallet while a separate always online Hot Wallet stakes the coins, meaning you don't have to keep your wallet open to stake Solaris.
The Hot Wallet has no access to your coins and you can withdraw coins your Cold Balance to any address at any time.
</p>
</div>
</div>
<div class="col-12 col-md-6 animated" data-animate="fadeInUp" data-delay=".1">
<img src="images/cold-stake/cold-stake-image.png">
</div>
</div>
</div>
</section>

<div class="section section-pad pt-5 section-bg inner-bg" id="coldstaking">
<div class="container">
<div class="row text-center">
<div class="col">
<div class="section-head pb-5" id="wallet-title-text">
<h2 class="section-title animated" data-animate="bounceInDown" data-delay="0.2">How-to Guides
<span>Cold</span>
</h2>
</div>
</div>
</div>

<div class="nav-tabs-wallet animated" data-animate="bounceInDown" data-delay="0.2">
<ul class="nav text-center nav-justified" data-animate="fadeInUp" data-delay="0">
<li class="nav-item nav-item-wallet-small">
<a class="nav-link active wallet-tab wallet-tab-small wallet-small-nav-tab" data-toggle="tab" href="#v-pills-coldstake">
<h6 style="font-size: 0.6rem;">Cold Staking on Trustaking.com</h6>
</a>
</li>
<li class="nav-item nav-item-wallet-small">
<a class="nav-link wallet-tab wallet-tab-small wallet-small-nav-tab" data-toggle="tab" href="#v-pills-coldstake-vps">
<h6 style="font-size: 0.6rem;">Cold Staking on VPS</h6>
</a>
</li>
<li class="nav-item nav-item-wallet-small">
<a class="nav-link wallet-tab wallet-tab-small wallet-small-nav-tab" data-toggle="tab" href="#v-pills-cold-more">
<h6 style="font-size: 0.6rem;">Add More to Cold Stake</h6>
</a>
</li>
<li class="nav-item nav-item-wallet-small">
<a class="nav-link wallet-tab wallet-tab-small wallet-small-nav-tab" data-toggle="tab" href="#v-pills-legacy">
<h6 style="font-size: 0.6rem;">Withdraw Coins from Cold Balance</h6>
</a>
</li>
</ul>
</div>
<div class="row animated" data-animate="bounceInUp" data-delay="0.2">

<div class="col-3" id="wallets-section-wide">
<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
<a class="nav-links active wallet-tab" id="v-pills-core-tab" data-toggle="pill" href="#v-pills-coldstake" role="tab" aria-controls="v-pills-core" aria-selected="true">
<h5 style="font-size: 1rem;">Cold Staking on Trustaking.com</h5>
</a>
<a class="nav-links wallet-tab" id="v-pills-core-tab" data-toggle="pill" href="#v-pills-coldstake-vps" role="tab" aria-controls="v-pills-core" aria-selected="false">
<h5 style="font-size: 1rem;">Cold Staking on VPS</h5>
</a>
 <a class="nav-links wallet-tab" id="v-pills-legacy-tab" data-toggle="pill" href="#v-pills-cold-more" role="tab" aria-controls="v-pills-legacy" aria-selected="false">
<h5 style="font-size: 1rem;">Add More to Cold Stake</h5>
</a>
<a class="nav-links wallet-tab" id="v-pills-legacy-tab" data-toggle="pill" href="#v-pills-legacy" role="tab" aria-controls="v-pills-legacy" aria-selected="false">
<h5 style="font-size: 1rem;">Withdraw Coins from Cold Balance</h5>
</a>
</div>
</div>

<div class="col">
<div class="tab-content" id="v-pills-tabContent">
<div class="tab-pane fade show active" id="v-pills-coldstake" role="tabpanel" aria-labelledby="v-pills-core-tab">
<h5>Start Cold Staking on Trustaking.com</h5>
If you don't feel like setting up and maintaining your own Hot Staking wallet on a VPS or a dedicated server, then Trustaking.com is the service for you!
<br><br>
Trustaking provide Full Node As a Service free of charge but relying on <a href="https://donations.trustaking.com/">donations</a> to keep it that way. All Solaris users who want to start staking their XLR coins, strengthen the network and get rewards can follow the instructions below.
<br><br>
<h5>Requirements</h5>
<ul class="wallet-features-text">
<li>• Solaris Core wallet synced up to 100%</li>
<li>• XLR coins in your main wallet account (DASHBOARD)</li>
</ul>
<br>
<h5>Instructions</h5>
<ul class="wallet-features-text">
<li><b class="text-warning">1.</b> Go to <a href="https://solaris.trustaking.com/">solaris.trustaking.com</a> and click COLD STAKE NOW.
<img src="images/cold-stake/trustaking-1.png">
</li><br>
<li><b class="text-warning">2.</b> You will be provided with a Hot Wallet address from Trustaking.com which you will use to setup cold staking.
<img src="images/cold-stake/trustaking-2.png">
</li><br>
<li><b class="text-warning">3.</b> In your Solaris Core wallet, click into to COLD STAKING tab.
<img src="images/cold-stake/cold-stake-tab.png">
</li><br>
<li><b class="text-warning">4.</b> Select "This will become a Cold Staking wallet" and click next.
<img src="images/cold-stake/cold-staking-wallet.png">
</li><br>
<li><b class="text-warning">5.</b> Enter the amount of coins you want to start Cold Staking.
<img src="images/cold-stake/cold-staking-amount.png">
</li><br>
<li><b class="text-warning">6.</b> Enter the Hot Wallet address you received from Trustaking.com
<img src="images/cold-stake/cold-staking-address.png">
</li><br>
<li><b class="text-warning">7.</b> Enter the wallet password and click SEND.<br>
<img src="images/cold-stake/cold-staking-password.png">
</li><br>
<li><b class="text-warning">8.</b> Your Cold Staking has been setup!<br>
<img src="images/cold-stake/cold-staking-sent.png">
</li><br>
<li><b class="text-warning">9.</b> That's it! After 1 network confirmation your Cold Staking balance will be visible and will begin to stake after it matures.
<img src="images/cold-stake/cold-staking-confirmed.png">
</li>
<li><b class="text-warning">10.</b> Lastly you should make a backup of your wallet file to ensure easy recovery of the Cold Balance. <br><br>
The 12 word mnemonic phrase does work to recover main balance and the cold balance will still be there, but not visible and requires special techniques to recover. The wallet file ensures you can easily restore your cold balance in the future.
<br><br>
You can find the location of your wallet file by going to the ADVANCED tab in your wallet and look at the Wallet data directory.
<img src="images/cold-stake/save-wallet-location.png"><br><br>
Go to that folder and make a copy of the file which starts with the name of your wallet and ends with *.wallet.json.<br><br>
<img src="images/cold-stake/save-wallet-file.png"><br>
</li>
</ul>
<br>
</div>
<div class="tab-pane fade" id="v-pills-coldstake-vps" role="tabpanel" aria-labelledby="v-pills-core-tab">
<h5>Start Cold Staking on a VPS</h5>
It is recommended to run your own Full Node for Cold Staking To help the Solaris network stay as decentralized as possible.
If you want setup your own Hot Wallet which will do the staking for you on a VPS, then follow the instructions below.
<br><br>
<h5>Requirements</h5>
<ul class="wallet-features-text">
<li>• Solaris Core wallet synced up to 100%</li>
<li>• XLR coins in your main wallet account (DASHBOARD)</li>
<li>• A Virtual Private Server (VPS) - With Ubuntu 64 Bit OS (16.04 - 19.04)</li>
<li>• Recommended VPS specifications: 2GB RAM, 1 Core CPU, 20GB+ Hard drive</li>
<li>• A way to connect to the VPS console:</li>
<li>&#8203; ○ Windows users can download Putty from: <a href="http://www.putty.org/">www.putty.org</a></li>
<li>&#8203; ○ Mac users can use Terminal to connect: <a href="https://apple.blogoverflow.com/2012/02/how-to-use-ssh-on-mac-os-x/">MAC OS X Terminal Guide</a></li>
</ul>
<br>
<h5>Instructions for VPS Hot Wallet setup</h5>
<ul class="wallet-features-text">
<li><b class="text-warning">1.</b> After you purchased your VPS and installed Ubuntu, you need to login into the VPS console using Putty or the Mac OS alternative.
</li><br>
<li><b class="text-warning">2.</b> In Putty enter the IP address of the VPS and click Open.
<img src="images/cold-stake/putty-login.jpg"><br>
You may see a certificate warning, since this is the first time you are connecting to this server. You can safely click Yes to trust this server in the future.<br><br>
You are now connected to the server and should see a terminal window. Begin by logging into your server with the user name (usually "root") and password supplied by the hosting provider. <br><br>
To paste in the Putty, Right Click the mouse button.
</li><br>
<li><b class="text-warning">3.</b> In the Terminal window you need to enter four commands to begin the Hot Wallet installation and setup.<br><br>
Copy this 1st command into the Terminal and hit Enter.<br>
<div class="p-2 rounded" style="background-color: black">
<code>apt-get update</code>
</div><br>
Copy this 2nd command into the Terminal and hit Enter.<br>
<div class="p-2 rounded" style="background-color: black">
<code>apt-get upgrade</code>
</div><br>
Copy this 3rd command into the Terminal and hit Enter.<br>
<div class="p-2 rounded" style="background-color: black">
<code>sudo su -</code>
</div><br>
Now copy this 5th command into the Terminal and hit Enter which will begin the setup process.<br>
<div class="p-2 rounded" style="background-color: black">
<code>bash <( curl -s https://raw.githubusercontent.com/thecrypt0hunter/node-installer/master/install-solaris-hot-node.sh )</code>
</div><br>
This is how it should look when you enter both commands one-by-one and the setup begins:
<img src="images/cold-stake/VPS-hot-node-setup.gif"><br>
</li><br>
<li><b class="text-warning">4.</b> The script automatically checks and installs all the necessary components, which can take up to 10 minutes.<br><br>
Once the installation is complete, you will be asked to enter a Wallet Name (required), Password (required) and a Passphrase (optional, can leave blank) to create this hot wallet. Hit Enter after typing each detail.<br>
<img src="images/cold-stake/vps-enter-details.png">
</li><br>
<li><b class="text-warning">5.</b> Now the script will go through the final steps and give you the Hot Wallet address that you can use to setup Cold Staking in your Solaris Core wallet.<br><br>
Copy and save this information incase you want to add more funds to cold-stake by using the same Hot Wallet address again.
<img src="images/cold-stake/vps-hot-address.png">
</li><br>
<li><b class="text-warning">6.</b> In your Solaris Core wallet, click into to COLD STAKING tab.
<img src="images/cold-stake/cold-stake-tab.png">
</li><br>
<li><b class="text-warning">7.</b> Select "This will become a Cold Staking wallet" and click next.
<img src="images/cold-stake/cold-staking-wallet.png">
</li><br>
<li><b class="text-warning">8.</b> Enter the amount of coins you want to start Cold Staking.
<img src="images/cold-stake/cold-staking-amount.png">
</li><br>
<li><b class="text-warning">9.</b> Enter the Hot Wallet address you received from setting up your VPS Hot Wallet.
<img src="images/cold-stake/vps-hot-address-copy.png">
</li><br>
<li><b class="text-warning">10.</b> Enter the wallet password and click SEND.<br>
<img src="images/cold-stake/cold-staking-password.png">
</li><br>
<li><b class="text-warning">11.</b> Your Cold Staking has been setup!<br>
<img src="images/cold-stake/cold-staking-sent.png">
</li><br>
<li><b class="text-warning">12.</b> That's it! After 1 network confirmation your Cold Staking balance will be visible and will begin to stake after it matures.
<img src="images/cold-stake/cold-staking-confirmed.png">
</li>
<li><b class="text-warning">13.</b> Lastly you should make a backup of your wallet file to ensure easy recovery of the Cold Balance. <br><br>
The 12 word mnemonic phrase does work to recover main balance and the cold balance will still be there, but not visible and requires special techniques to recover. The wallet file ensures you can easily restore your cold balance in the future.
<br><br>
You can find the location of your wallet file by going to the ADVANCED tab in your wallet and look at the Wallet data directory.
<img src="images/cold-stake/save-wallet-location.png"><br><br>
Go to that folder and make a copy of the file which starts with the name of your wallet and ends with *.wallet.json.<br><br>
<img src="images/cold-stake/save-wallet-file.png"><br>
</li>
</ul>
<br>
</div>
<div class="tab-pane fade" id="v-pills-cold-more" role="tabpanel" aria-labelledby="v-pills-light-tab">
<h5>Add More Coins to Cold Stake</h5>
You can keep adding more coins from your main balance to Cold Stake, and you can use the same Hot Wallet address, or a completely different one each time. To do this simply follow these instructions:
<br>
<br>
<ul class="wallet-features-text">
<li>1. Click into the Cold Staking tab in your Solaris Core Wallet. </li>
<li>2. Click "New Setup".</li>
<li>3. Enter the amount of coins you want to start Cold Staking</li>
<li>4. Enter the Hot Wallet address you received from Cold Staking Service or your own Hot Wallet setup</li>
<li>5. Click "Send"</li>
<li>6. That's it! After your coins mature, they will begin to stake. You can see your combined Cold Staking balance in this tab.</li>
</ul>
<br>
<div class="row text-center">
<img src="images/cold-stake/cold-stake-more.gif">
</div>
</div>
<div class="tab-pane fade" id="v-pills-legacy" role="tabpanel" aria-labelledby="v-pills-legacy-tab">
<h5>Withdraw Coins from Cold Balance</h5>
You may withdraw as many coins as you want from your Cold Balance at any time. You may use any address for the withdrawal, or use your own wallets address to withdraw the coins to your main balance.
Follow these guidelines to withdraw coins back to your main balance.
<br>
<br>
<ul class="wallet-features-text">
<li>1. In the "Dashboard" tab click on "RECEIVE" button and copy your wallet receiving address.</li>
<li>2. Click into the Cold Staking tab.</li>
<li>3. Click with "Withdraw" button in the Cold Balance section.</li>
<li>4. Enter the amount of coins you want to withdraw from your Cold Balance</li>
<li>5. Enter the address you copied from the Dashboard for your own wallet</li>
<li>6. Enter the wallet password and click send.</li>
<li>7. That's it! Go back to the Dashboard tab to see the withdrawal back to your wallet.</li>
</ul>
<br>
<div class="row text-center">
<img src="images/cold-stake/cold-stake-withdraw.gif">
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</article>
<?php include('include/footer.php'); ?>