<?php 
    session_start();
    require ('/var/secure/keys.php');
    require ('include/functions.php');
    require ('include/config.php');
    $wallet = new phpFunctions_Wallet();
    
    // Deal with the bots first
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
    
        // Build POST request:
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_response = $_POST['recaptcha_response'];
    
        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $captcha_secret_key . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        if($recaptcha->success==true){

            // Take action based on the score returned:
            if ($recaptcha->score >= 0.5) {
                    $verified=true;
            } else {
                    $verified=false;
                    die (" Recaptcha thinks you're a bot! - please try again in a new tab.");
            }
        } else { // there is an error /
            die (' Something went wrong with Recaptcha! - please try again in a new tab.');
        }
    }

    //Check if node is online before and grab address before taking payment
    $url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Node/status' ;
    $check_server = $wallet->checkSite ($url);

    if ( $check_server == '' || empty($check_server) ) {
    } else {

    // Grab the next unused address 
    $url = $scheme.'://'.$server_ip.':'.$api_port.'/api/Wallet/unusedaddress?WalletName='.$WalletName.'&AccountName='.$AccountName ;
    $address = $wallet->CallAPI ($url);
    if ( $address == '' || empty($address) ) {
        die (' Something went wrong checking the node! - please try again in a new tab it could just be a timeout.');
    } else {
        $_SESSION['Address']=$address;
        }
    }

    // Generate & store the InvoiceID in session
    $OrderID = $ticker . '-' . $wallet->crypto_rand(100000000000,999999999999);
    $_SESSION['OrderID']=$OrderID;

    // Full service description
    $serv=$_SESSION['Days_Online'].$service_desc;

    // Create invoice
    $inv = $wallet->CreateInvoice($OrderID,$_SESSION['Price'],$serv,$redirectURL);
    $invoiceId= $inv['invoice_id'];
    $invoiceURL= $inv['invoice_url'];

    // Store the InvoiceID in session
    $_SESSION['InvoiceID']=$invoiceId;

    // Forwarding to payment page
    header('Location:' . $invoiceURL); //<<redirect to payment page
    //echo '<br><b>Invoice:</b><br>'.$invoiceId.'" created, see '.$invoiceURL .'<br>';
?>