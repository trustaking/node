<?php
session_start();
require ('/var/secure/keys.php');
require ('include/functions.php');
require ('include/config.php');

$wallet = new phpFunctions_Wallet();

$myfile = fopen("/var/secure/BTCPayServerIPN.log", "a");
$raw_post_data = file_get_contents('php://input');
$date = date('m/d/Y h:i:s a', time());

if (false === $raw_post_data) {
    fwrite($myfile, $date . " : Error. Could not read from the php://input stream or invalid BTCPayServer IPN received.\n");
    fclose($myfile);
    throw new \Exception('Could not read from the php://input stream or invalid BTCPayServer IPN received.');
}

$ipn = json_decode($raw_post_data);

if (true === empty($ipn)) {
    fwrite($myfile, $date . " : Error. Could not decode the JSON payload from BTCPayServer.\n");
    fclose($myfile);
    throw new \Exception('Could not decode the JSON payload from BTCPayServer.');
}

if (true === empty($ipn->id)) {
    fwrite($myfile, $date . " : Error. Invalid BTCPayServer payment notification message received - did not receive invoice ID.\n");
    fclose($myfile);
    throw new \Exception('Invalid BTCPayServer payment notification message received - did not receive invoice ID.');
}

// Now fetch the invoice from BTCPayServer
// This is needed, since the IPN does not contain any authentication
$storageEngine = new \BTCPayServer\Storage\EncryptedFilesystemStorage($encryt_pass);
$privateKey    = $storageEngine->load('/var/secure/btcpayserver.pri');
$publicKey     = $storageEngine->load('/var/secure/btcpayserver.pub');
$client        = new \BTCPayServer\Client\Client();
$adapter       = new \BTCPayServer\Client\Adapter\CurlAdapter();

$client->setPrivateKey($privateKey);
$client->setPublicKey($publicKey);
$client->setUri($btcpayserver);
$client->setAdapter($adapter);

$token = new \BTCPayServer\Token();
$token->setToken($pair_token);
$token->setFacade('merchant');
$client->setToken($token);

/**
 * This is where we will fetch the invoice object
 */
$invoice = $client->getInvoice($ipn->id);
$invoiceId = $invoice->getId();
$invoiceStatus = $invoice->getStatus();
$invoiceExceptionStatus = $invoice->getExceptionStatus();
$invoicePrice = $invoice->getPrice();

fwrite($myfile, $date . " : IPN received for BTCPayServer invoice ".$invoiceId." . Status = " .$invoiceStatus." / exceptionStatus = " . $invoiceExceptionStatus." Price = ". $invoicePrice." Tax Included = ". $taxIncluded."\n");
fwrite($myfile, "Raw IPN: ". $raw_post_data."\n");

//Respond with HTTP 200, so BTCPayServer knows the IPN has been received correctly
//If BTCPayServer receives <> HTTP 200, then BTCPayServer will try to send the IPN again with increasing intervals for two more hours.
header("HTTP/1.1 200 OK");
?>