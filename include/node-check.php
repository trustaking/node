<?php
include_once('include/initialise.php');
$balance = 0;
$connections = 0;

//Check if node is online before further checks
$check_server = $coinFunctions->rpc('getinfo','');

if ( $check_server == '' || empty($check_server) ) {
$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:red'>Node offline</a></li>
EOD;
$enabled = <<<EOD
<a href="index.html" class="icon fa-circle" style="color:red">TRUSTAKING.COM </a>
EOD;
} else {

// Grab balance
$balance = $coinFunctions->getBalance();

// Get number of connections
$getinfo = $coinFunctions->rpc('getinfo','');

	if (array_key_exists('connections', $getinfo)) {
		$connections = $getinfo['connections'];
	}

// Get Staking Details
$get_stakinginfo = $coinFunctions->rpc('getstakinginfo','');

if ( !is_array($get_stakinginfo) ) {
	echo '<pre>' . json_encode($getstakinginfo,JSON_PRETTY_PRINT) . '</pre>' ;
	exit (' There was an error with your RPC parameters.');
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
<li><a href=""class="icon fa-circle" style='color:green'>Staking: $balance ($connections)</a></li>
EOD;
} else {
$message = <<<EOD
<li><a href=""class="icon fa-circle" style='color:blue'>Staking offline ($connections)</a></li>
EOD;
}
}