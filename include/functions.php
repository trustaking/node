<?php 

class phpFunctions_Wallet {

public function crypto_rand($min,$max,$pedantic=True) {
    $diff = $max - $min;
    if ($diff <= 0) return $min; // not so random...
    $range = $diff + 1; // because $max is inclusive
    $bits = ceil(log(($range),2));
    $bytes = ceil($bits/8.0);
    $bits_max = 1 << $bits;
    $num = 0;
    do {
        $num = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes))) % $bits_max;
        if ($num >= $range) {
            if ($pedantic) continue; // start over instead of accepting bias
            // else
            $num = $num % $range;  // to hell with security
        }
        break;
    } while (True);  // because goto attracts velociraptors
    return $num + $min;
}

public function checkSite( $url ) {
    $useragent = $_SERVER['HTTP_USER_AGENT'];

    $options = array(
            CURLOPT_RETURNTRANSFER => true,      // return web page
            CURLOPT_HEADER         => false,     // do not return headers
            CURLOPT_FOLLOWLOCATION => true,      // follow redirects
            CURLOPT_USERAGENT      => $useragent, // who am i
            CURLOPT_AUTOREFERER    => true,       // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 2,          // timeout on connect (in seconds)
            CURLOPT_TIMEOUT        => 2,          // timeout on response (in seconds)
            CURLOPT_MAXREDIRS      => 10,         // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false,     // SSL verification not required
            CURLOPT_SSL_VERIFYHOST => false,     // SSL verification not required
    );
    $ch = curl_init( $url );
    curl_setopt_array( $ch, $options );
    curl_exec( $ch );

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ($httpcode == 200);
}

public function CallAPI($url) {

$ch = curl_init() ; //  Initiate curl
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_URL,$url); // Set the url
curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch)
$response = curl_exec($ch); // Execute
$response = json_decode($response,true);
$error = curl_errno($ch);
$result = $response;
curl_close($ch);
return $result;
}

public function GetInvoiceStatus($invoiceId,$orderID) {
  require ('/var/secure/keys.php'); //secured location - sensitive keys
  require ('include/config.php'); // coin configuration
  require ('vendor/autoload.php'); //loads the btcpayserver library

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

  $invoice = $client->getInvoice($invoiceId);
  
  $OrderIDCheck = $invoice->getOrderId();
  $OrderStatus = $invoice->getStatus();
  $ExcStatus = $invoice->getExceptionStatus();
    
  if (($OrderStatus == 'complete' || $OrderStatus == 'paid') && $OrderIDCheck == $orderID) {
    $result = "PASS";
  } else { //TODO: Handle partial payments
    $result = "FAIL";
  }
  
  return $result;
}

public function CreateInvoice($OrderID,$Price,$Description,$redirectURL) {
  require ('/var/secure/keys.php'); //secured location - sensitive keys
  require ('vendor/autoload.php'); //loads the btcpayserver library

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

  // * This is where we will start to create an Invoice object, make sure to check
  // * the InvoiceInterface for methods that you can use.
  $invoice = new \BTCPayServer\Invoice();
  $buyer = new \BTCPayServer\Buyer();
  //$buyer->setEmail($email);

  // Add the buyers info to invoice
  $invoice
      ->setBuyer($buyer);

  // Item is used to keep track of a few things
  $item = new \BTCPayServer\Item();
  $item
      //->setCode('skuNumber')
      ->setDescription($Description)
      ->setPrice($Price);
  $invoice->setItem($item);

  // Setting this to one of the supported currencies will create an invoice using
  // the exchange rate for that currency.
  $invoice
      ->setCurrency(new \BTCPayServer\Currency('USD'));

  // Configure the rest of the invoice
  $invoice
      //->setNotificationUrl('https://store.example.com/btcpayserver/callback')
      ->setOrderId($OrderID)
      ->setRedirectURL($redirectURL);

  // Updates invoice with new information such as the invoice id and the URL where
  // a customer can view the invoice.
  try {
  echo "Creating invoice at BTCPayServer now.".PHP_EOL;
  $client->createInvoice($invoice);
  } catch (\Exception $e) {
      echo "Exception occured: " . $e->getMessage().PHP_EOL;
      $request  = $client->getRequest();
      $response = $client->getResponse();
      echo (string) $request.PHP_EOL.PHP_EOL.PHP_EOL;
      echo (string) $response.PHP_EOL.PHP_EOL;
      exit(1); // We do not want to continue if something went wrong
  }

  return array('invoice_id' => $invoice->getId(), 'invoice_url' => $invoice->getUrl());
}

}