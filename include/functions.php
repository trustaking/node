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

public function getInvoiceStatus($invoiceId) {
require ('/var/secure/keys.php');
$ch = curl_init();
curl_setopt_array($ch, array(
  CURLOPT_PORT => "443",
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "{\"method\":\"getblock\", \"params\": [6931c538229099305baadd8ee17d9d3bad960c8f83e2468b428da887785297d4\",1]}",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Basic ".$apiKey."",
    "Content-Type: application/json",
    "cache-control: no-cache"
  ),
));
$response = curl_exec($ch); // Execute
$response = json_decode($response,true);
$error = curl_error($ch);
curl_close($ch);

foreach ($response as $key => $value) {
  $OrderStatus = $value["status"];
  $OrderIDCheck = $value["orderId"];
}

if ($OrderStatus == 'complete' && $OrderIDCheck == $_GET['OrderID']) {
  $result = "PASS";
} else {
  $result = "FAIL";
}

return $result;
}
}