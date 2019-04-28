<?php 

function crypto_rand($min,$max,$pedantic=True) {
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


public function ping($scheme,$ip,$port){

    $url = $scheme.'://'.$ip;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt ($ch, CURLOPT_PORT , $port);
    curl_setopt ($ch, CURLOPT_TIMEOUT , 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


function CallAPI($url) {

$ch = curl_init() ; //  Initiate curl
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_URL,$url); // Set the url
curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch)
$response = curl_exec($ch); // Execute
$result=json_decode($response);

if (curl_error($ch)) {
    $result = curl_errno($ch);
    echo 'Request Error:' . curl_error($ch);
} else {
    $result = file_get_contents($url); // grab contents
}
curl_close($ch); // Closing
return $result;

}

?>
