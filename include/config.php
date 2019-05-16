<?php 
// Coin specific variables
$ticker='redstone';
$api_port='38222'; 

// BTCPayServer variables

$encryt_pass  = 'YourTopSecretPassword';

//TODO: Inject the redirectURL, Service, Price.
$service_desc = '12 months Trustaking service';
$price        = '15.00';
$redirectURL  = 'http://35.185.115.152/activate.php';
$email        = '';

// general variables
$server_ip='localhost'; // '0.0.0.0' target server ip. [ex.] 10.0.0.15
$WalletName='hot-wallet' ; // Hot wallet name
$AccountName='coldStakingHotAddresses' ; // special account for cold staking addresses
$scheme='http' ;// tcp protocol to access json on coin. [default]
?>