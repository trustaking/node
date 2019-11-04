<?php 
require ('include/config.php');
require ('include/functions.php');
$wallet = new phpFunctions_Wallet();

//Check if node is online before further checks
$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Node/status' ;
$check_server = $wallet->checkSite ($url);

if ( $check_server == '' || empty($check_server) ) {
$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:red'>Node offline</a></li>
EOD;
$enabled = <<<EOD
<a href="index.html" class="icon fa-circle" style="color:red">TRUSTAKING.COM </a>
EOD;
} else {

// Grab balance
$url = $scheme.'://'.$server_ip.':'.$api_port."/api/Wallet/balance?WalletName=$WalletName&AccountName=$AccountName";
$get_balance = $wallet->CallAPI ($url); 
	
if ( !is_array($get_balance) ) {
	die (' There was an error with your login parameters. Are your credentials correct?');
} else {
foreach($get_balance as $a => $b){
	foreach($b as $c => $d){
}
$bal = $d['amountConfirmed']/100000000;
}}

// Get Node Staking Details
$url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Staking/getstakinginfo';
$get_stakinginfo = $wallet->CallAPI ($url); 

if ( !is_array($get_stakinginfo) ) {
	die (' There was an error with your API parameters.');
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
<li><a href=""class="icon fa-circle" style='color:green'>Staking: $bal</a></li>
EOD;
} else {
$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:red'>Staking offline</a></li>
EOD;
}
}
?>