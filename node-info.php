<?php
require('include/coin-functions.php');
$functions = new phpCoinFunctions();

//Check if node is online before further checks
$check_server = $functions->rpc('getinfo', '');

if ($check_server != '' || !empty($check_server)) {

// Examples
	// $getStakingExpiry = $functions->getStakingExpiry("xds1qxx69j9nzq0v0rqs0tc7sf8r5v2n8nkaqpltck2");
	// echo '<pre>' . json_encode($getStakingExpiry, JSON_PRETTY_PRINT) . '</pre>';
	// $setStakingExpiry = $functions->setStakingExpiry("xds1qxx69j9nzq0v0rqs0tc7sf8r5v2n8nkaqpltck2","<<date>>");
	// $startStaking = $functions->startStaking();
	// $stopStaking = $functions->stopStaking();
	// $sendTx = $functions->sendTx("xds1qxx69j9nzq0v0rqs0tc7sf8r5v2n8nkaqpltck2","0.5");
	// echo '<pre>SendTx: ' . json_encode($sendTx, JSON_PRETTY_PRINT) . '</pre>';
	// $getColdStakingaddress = $functions->getColdStakingAddress("Cold");
	// echo '<pre>Cold address: ' . json_encode($getColdStakingaddress, JSON_PRETTY_PRINT) . '</pre>';
	// $getmainbalance = $functions->getBalance("account 0");
	// echo '<pre>Main balance: ' . json_encode($getmainbalance, JSON_PRETTY_PRINT) . '</pre>';
	// $getcoldbalance = $functions->getBalance("coldStakingHotAddresses");
	// echo '<pre>Cold balance: ' . json_encode($getcoldbalance, JSON_PRETTY_PRINT) . '</pre>';
	// $getaddress = $functions->getAddress();
	// echo '<pre>Main address: ' . json_encode($getaddress, JSON_PRETTY_PRINT) . '</pre>';
	// $getHotColdStakingaddress = $functions->getColdStakingAddress("Hot");
	// echo '<pre>Cold Hot address: ' . json_encode($getHotColdStakingaddress, JSON_PRETTY_PRINT) . '</pre>';


	$getbalance = $functions->getBalance();
	echo '<pre>Staking balance: ' . json_encode($getbalance, JSON_PRETTY_PRINT) . '</pre>';

	$getinfo = $functions->rpc('getinfo', '');
	echo '<pre>getinfo: ' . json_encode($getinfo, JSON_PRETTY_PRINT) . '</pre>';

	$getStakingExpiry = $functions->getStakingExpiry();
	echo '<pre>getstakingexpiry: ' . json_encode($getStakingExpiry, JSON_PRETTY_PRINT) . '</pre>';

	$getstakinginfo = $functions->rpc('getstakinginfo', '');
	echo '<pre>getblockstakinginfo: ' . json_encode($getstakinginfo, JSON_PRETTY_PRINT) . '</pre>';

	$getnetworkinfo = $functions->rpc('getnetworkinfo', '');
	echo '<pre>getnetworkinfo: ' . json_encode($getnetworkinfo, JSON_PRETTY_PRINT) . '</pre>';

	$getblockchaininfo = $functions->rpc('getblockchaininfo', '');
	echo '<pre>getblockchaininfo: ' . json_encode($getblockchaininfo, JSON_PRETTY_PRINT) . '</pre>';

	$getrawmempool = $functions->rpc('getrawmempool', '');
	echo '<pre>getrawmempool: ' . json_encode($getrawmempool, JSON_PRETTY_PRINT) . '</pre>';

	$getpeerinfo = $functions->rpc('getpeerinfo', '');
	echo '<pre>getpeerinfo: ' . json_encode($getpeerinfo, JSON_PRETTY_PRINT) . '</pre>';
} else {

	die('<pre> Unable to connect to the node </pre>');
}
?>