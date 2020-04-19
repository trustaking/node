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
	$getinfo = $functions->rpc('getinfo', '');
	$getblockchaininfo = $functions->rpc('getblockchaininfo', '');
	$getstakinginfo = $functions->rpc('getstakinginfo', '');
	$getpeerinfo = $functions->rpc('getpeerinfo', '');
	$getnetworkinfo = $functions->rpc('getnetworkinfo', '');
	$getrawmempool = $functions->rpc('getrawmempool', '');

	echo '<pre>Hot balance: ' . json_encode($getbalance, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getinfo, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getstakinginfo, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getnetworkinfo, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getblockchaininfo, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getrawmempool, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getpeerinfo, JSON_PRETTY_PRINT) . '</pre>';
} else {

	die('<pre> Unable to connect to the node </pre>');
}
?>