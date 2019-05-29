<?php 
// Coin specific variables will get injected
$ticker='';
$api_port=''; 

// Service specific variables will get injected.
$service_end_date='';
$service_desc='';
$price='';
$online_days='';
$redirectURL='';
$email='';

// general variables
$server_ip='localhost'; // '0.0.0.0' target server ip. [ex.] 10.0.0.15
$scheme='http' ;// tcp protocol to access json on coin. [default]
$AccountName='coldStakingHotAddresses' ; // special account for cold staking addresses

//TODO: Inject wallet name
$WalletName='hot' ; // Hot wallet name
?>