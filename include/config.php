<?php 
// Coin specific variables will get injected
$ticker='';
$api_port=''; 
$rpc_port='';

// Service specific variables will get injected
$redirectURL='';
$ipnURL='';
$email='';

// general variables
$server_ip='localhost'; // '0.0.0.0' target server ip. [ex.] 10.0.0.15
$scheme='http' ;// tcp protocol to access json on coin. [default]
$AccountName='coldStakingHotAddresses' ; // special account for cold staking addresses
$HotAccountName='account%200' ; // special account for hot addresses
$api_ver=''; // additional parameters for api call
$coldstakeui=''; // switch off the scripts
$whitelist=''; //is whitelisting enabled
$payment=''; // is payment enabled (has to be used when whitelisting is enabled)
$exchange=''; // is exchanged enabled
?>