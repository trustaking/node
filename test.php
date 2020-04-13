<?php
require('include/initialise.php');

//Check if node is online before further checks
$check_server = $coinFunctions->rpc('getinfo', '');

if ($check_server != '' || !empty($check_server)) {

	$getbalance = $coinFunctions->rpc('getbalance', '');
	echo '<pre>' . json_encode($getbalance, JSON_PRETTY_PRINT) . '</pre>';

	//curl --data-binary '{"jsonrpc":"1.0","id":"curltext","method":"walletpassphrase","params":["walletpasswordhere","60"]}' -H 'content-type:text/plain;' http://rpcuser:rpcpassword@127.0.0.1:48333/
	//curl --data-binary '{"jsonrpc":"1.0","id":"curltext","method":"sendtoaddress","params":["xdsaddresshere","25"]}' -H 'content-type:text/plain;' http://rpcuser:rpcpassword@127.0.0.1:48333/

	// X42

	//curl --data-binary '{"jsonrpc":"1.0","id":"curltext","method":"walletpassphrase","params":["walletpasswordhere","60"]}' -H 'content-type:text/plain;' http://rpcuser:rpcpassword@127.0.0.1:48333/
	//curl --data-binary '{"jsonrpc":"1.0","id":"curltext","method":"getinfo","params":['']}' -H 'content-type:text/plain;' http://x42user:qO8oHqj0swuY@127.0.0.1:62343/


	//	 $walletpassphrase = $functions->rpc('walletpassphrase','"IoqfWVis4sAcgU4t0Uafg6yK9Nl6S3","10"');
	//	 $sendtoaddress = $functions->rpc('sendtoaddress','"XWusQMotb4zp8Hd4a7oHR9HteCdH9cBLCW","5"');
	//	 $walletlock = $functions->rpc('walletlock','');



	// XDS
	$walletpassphrase = $coinFunctions->rpc('walletpassphrase', '"hunter","10"');
	$sendtoaddress = $coinFunctions->rpc('sendtoaddress', '"xds1qpgyr9z8a2gz6a8ypyfyh2ywscp8rq9rhma7f20","0.05"');
	$walletlock = $coinFunctions->rpc('walletlock', '');


	echo '<pre>' . json_encode($walletpassphrase, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($sendtoaddress, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($walletlock, JSON_PRETTY_PRINT) . '</pre>';

	$getbalance = $coinFunctions->rpc('getbalance', '');
	$getinfo = $coinFunctions->rpc('getinfo', '');
	$getstakinginfo = $coinFunctions->rpc('getstakinginfo', '');
	$getnetworkinfo = $coinFunctions->rpc('getnetworkinfo', '');
	$getrawmempool = $coinFunctions->rpc('getrawmempool', '');

	echo '<pre>' . json_encode($getbalance, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getinfo, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getstakinginfo, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getnetworkinfo, JSON_PRETTY_PRINT) . '</pre>';
	echo '<pre>' . json_encode($getrawmempool, JSON_PRETTY_PRINT) . '</pre>';
} else {

	die('<pre> Unable to connect to the node </pre>');
}
?>