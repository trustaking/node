<?php 
include('include/node-check.php');
include('include/header.php');
include('include/menu.php'); 
?>
<!-- Main -->
<article id="main">
	<header>
		<h2>Cold Staking<br />How-to Guides</h2>
	</header>

    <section class="wrapper style1 special">
		<div class="inner">
            <h2>What is cold staking?</h2>
            <p>Staking coins strengthens the network and you get rewarded for finding blocks. Cold staking is a safer way to stake your coins.<br><br>
            Cold Staking allows you to safely store your coins in your wallet while a separate always online cold staking server stakes the coins, meaning you don't have to keep your wallet open for staking.<br><br>
            The cold staking server has no access to your coins and you can withdraw coins to a spending address at any time.</p>
        </div>
    </section>
    <section id="trustaking" class="wrapper style2">
		<div class="inner">
            <h2>Start Cold Staking on Trustaking.com</h2>
                If you don't feel like setting up and maintaining your own cold staking server on a VPS or a dedicated server, then Trustaking.com is the service for you!
                <br><br>
                All users who want to start staking their coins, strengthen the network and get rewards can follow the instructions below.
                <br><br>
                <h5>Requirements</h5>
                <ul>
                <li>Core wallet synced up to 100% - you may need to download a Core Wallet that supports Cold Staking <a href="https://github.com/thecrypt0hunter/CoreWallet/releases" target="_blank">here</a>.</li>
                <li>Coins in your main wallet account (DASHBOARD)</li>
                </ul>
                <h5>Instructions</h5>
                <ol>
                <?php if ($coinFunctions->config['payment'] == '1') { ?>
                    <li>Go to <a href="https://<?php echo $ticker;?>.trustaking.com/"><?php echo $ticker;?>.trustaking.com</a>, choose your plan (and make your payment) or a free trial.</li><br>
                    <img src="images/cold-stake/choose-plan.png">
                <?php } else { ?>
                    <li>Go to <a href="https://<?php echo $ticker;?>.trustaking.com/"><?php echo $ticker;?>.trustaking.com</a>, click Cold Stake Now.</li><br>
                    <img src="images/cold-stake/trustaking-1.png">
                <?php }; ?>
                <li> You will be provided with a personal cold staking address from Trustaking.com which you will use to delegate staking.</li><br>
                <img src="images/cold-stake/trustaking-2.png">
                <li> In your Core wallet, click into to COLD/DELEGATED STAKING tab.</li><br>
                <img src="images/cold-stake/cold-stake-tab.png">
                <li> Click Setup Now.</li><br>
                <img src="images/cold-stake/cold-staking-wallet.png">
                <li> Enter the amount of coins you want to delegate to a cold staking service.</li><br>
                <img src="images/cold-stake/cold-staking-amount.png">
                <li> Enter the cold staking address you received from Trustaking.com</li><br>
                <img src="images/cold-stake/cold-staking-address.png">
                <li> Enter the wallet password and click DELEGATE/SEND.</li><br>
                <img src="images/cold-stake/cold-staking-password.png">
                <li> Your Cold Staking setup is complete!</li><br>
                <img src="images/cold-stake/cold-staking-sent.png">
                <li> That's it! After 1 network confirmation your Cold Staking balance will be visible and will begin to stake after it matures.</li><br>
                <img src="images/cold-stake/cold-staking-confirmed.png">
                </li>
                </ol>
        </div>
    </section>
    <section id="vps" class="wrapper style2">
		<div class="inner">
            <h2>Setup a Cold Staking Server on a VPS</h2>
            <p>To help the network remain decentralised it is recommended that you run your own Cold Staking server.<br>
            If you want setup your own cold staking server on a VPS, follow the instructions below.</p>
            <h5>Requirements</h5>
            <ul>
            <li>Core wallet synced up to 100%</li>
            <li>Coins in your main wallet account (DASHBOARD)</li>
            <li>A Virtual Private Server (VPS) - With Ubuntu 64 Bit OS (16.04 - 19.04)</li>
            <li>Recommended VPS specifications: 2GB RAM, 1 Core CPU, 20GB+ Hard drive</li>
            <li>A way to connect to the VPS console:</li>
            <ul>
            <li>Windows users can download Putty from: <a href="http://www.putty.org/">www.putty.org</a></li>
            <li>Mac users can use Terminal to connect: <a href="https://apple.blogoverflow.com/2012/02/how-to-use-ssh-on-mac-os-x/">MAC OS X Terminal Guide</a></li>
            </ul>    
            </ul>
            <br>
            <h5>Instructions for VPS setup</h5>
            <ol>
            <li> After you purchased your VPS and installed Ubuntu, you need to login into the VPS console using Putty or the Mac OS alternative.</li><br>
            <li> In Putty enter the IP address of the VPS and click Open.</li><br>
            <img src="images/cold-stake/putty-login.jpg">
            <br><i>You may see a certificate warning, since this is the first time you are connecting to this server. You can safely click Yes to trust this server in the future.<br><br>
            You are now connected to the server and should see a terminal window. Begin by logging into your server with the user name (usually "root") and password supplied by the hosting provider. <br><br>
            To paste in the Putty, Right Click the mouse button.<br><br></i>
            <li> In the Terminal window you need to enter four commands to begin the Hot Wallet installation and setup.<br>
            Copy this 1st command into the Terminal and hit Enter.<br>
            <div class="p-2 rounded" style="background-color: black">
            <code>sudo su -</code>
            </div><br>
            Copy this 2nd command into the Terminal and hit Enter.<br>
            <div class="p-2 rounded" style="background-color: black">
            <code>apt-get update && apt-get upgrade -y && apt-get autoremove -y</code>
            </div><br>
            Now copy this final command into the Terminal and hit Enter which will begin the setup process.<br>
            <div class="p-2 rounded" style="background-color: black">
            <code>bash <( curl -s https://raw.githubusercontent.com/thecrypt0hunter/node-installer/master/install-<?php echo $ticker;?>-hot-node.sh )</code>
            </div><br>
            This is how it should look when you enter the commands one-by-one and the setup begins:</li><br>
            <img src="images/cold-stake/VPS-hot-node-setup.gif">
            <li> The script automatically checks and installs all the necessary components, which can take up to 10 minutes.<br><br>
            Once the installation is complete, you will be asked to enter a Wallet Name (required), Password (required) and a Passphrase (optional, can leave blank) to create this hot wallet. Hit Enter after typing each detail.</li><br>
            <img src="images/cold-stake/vps-enter-details.png">
            <li> Now the script will go through the final steps and give you the cold staking address that you can use to setup cold/delegated staking in your Core wallet.<br><br>
            Copy and save this information incase you want to delegate more funds in the future.</li><br>
            <img src="images/cold-stake/vps-hot-address.png">
            <li> In your Core wallet, click into to COLD/DELEGATED STAKING tab.</li><br>
            <img src="images/cold-stake/cold-stake-tab.png">
            <li> Click Setup Now.</li><br>
            <img src="images/cold-stake/cold-staking-wallet.png">
            <li> Enter the amount of coins you want to delegate for Cold Staking.</li><br>
            <img src="images/cold-stake/cold-staking-amount.png">
            <li> Enter the cold staking address you received when you setup your cold staking server on the VPS.</li><br>
            <img src="images/cold-stake/vps-hot-address-copy.png">
            <li> Enter the wallet password and click DELEGATE/SEND.</li><br>
            <img src="images/cold-stake/cold-staking-password.png">
            <li> Your Cold Staking has been setup!</li><br>
            <img src="images/cold-stake/cold-staking-sent.png">
            <li> That's it! After 1 network confirmation your Cold/Delegated Staking balance will be visible and will begin to stake after it matures.</li><br>
            <img src="images/cold-stake/cold-staking-confirmed.png">
            </li>
            <li> Lastly you should make a backup of your wallet file to ensure easy recovery of the Cold/Delegated Balance. <br></li><br>
            You can find the location of your wallet file by going to the ADVANCED tab in your wallet and look at the Wallet data directory.</li><br><br>
            <img src="images/cold-stake/save-wallet-location.png"><br>
            <li>Go to that folder and make a copy of the file which starts with the name of your wallet and ends with *.wallet.json.</li><br>
            <img src="images/cold-stake/save-wallet-file.png">
            </li>
            </ol>
        </div>
    </section>
    <section id="add-more" class="wrapper style2">
		<div class="inner">
            <h2>Delegate more coins for cold staking</h2>
            You can keep delegating more coins from your main balance to cold staking, and you can use the same cold staking address, or a completely different one each time. To do this simply follow these instructions:<br><br>
            <ol>
            <li>Click into the Cold/Delegated Staking tab in your Core Wallet. </li>
            <li>Click "Add".</li>
            <li>Enter the amount of coins you want to delegate for cold staking</li>
            <li>Enter the cold address you received from cold staking service or your own cold address from the VPS setup</li>
            <li>Click "Send/Delegate"</li>
            <li>That's it! After your coins mature, they will begin to stake. You can see your Cold/Delegated Staking balance in this tab.</li>
            </ol>
            <br>
            <div class="row text-center">
            <img src="images/cold-stake/cold-stake-more.gif">
            </div>
            </div>
        </div>
    </section>


    <section id="withdraw" class="wrapper style2">
		<div class="inner">
            <h2>Withdraw Coins from Cold Staking</h2>
            You may withdraw as many coins as you want from your cold staking at any time. You may use any address for the withdrawal, but it is likely that you will use your own wallets address to withdraw your coins.
            Follow these guidelines to withdraw coins back to your main balance.<br><br>
            <ol>
            <li>In the "Dashboard" tab click on "RECEIVE" button and copy your wallet receiving address.</li>
            <li>Click into the Cold Staking tab.</li>
            <li>Click with "Withdraw" button in the Cold/Delegate Balance section.</li>
            <li>Enter the amount of coins you want to withdraw from your Cold/Delegated Balance</li>
            <li>Enter the address you copied from the Dashboard for your own wallet</li>
            <li>Enter the wallet password and click send.</li>
            <li>That's it! Go back to the Dashboard tab to see the withdrawal back to your wallet.</li>
            </ol>
            <br>
            <div class="row text-center">
            <img src="images/cold-stake/cold-stake-withdraw.gif">
            </div>
        </div>
    </section>
</article>
<?php include('include/footer.php'); ?>