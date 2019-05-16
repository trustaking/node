<?php 
    session_start(); // start a session before any output
    require ('include/functions.php'); // standard functions
    require ('include/config.php'); // coin configuration
    $wallet = new phpFunctions_Wallet();

    // Generate & store the InvoiceID in session
    $OrderID = $ticker . '-' . $wallet->crypto_rand(100000000000,999999999999);
    $_SESSION['OrderID']=$OrderID;

    // Create invoice
    $inv = $wallet->CreateInvoice($OrderID);
    $invoiceId= $inv['invoice_id'];
    $invoiceURL= $inv['invoice_url'];

    // Store the InvoiceID in session
    $_SESSION['InvoiceID']=$invoiceId;

    // Forwarding to payment page
//    header('Location:' . $invoiceURL); //<<redirect to payment page

//header('Location: activation.php'); // <<redirect to activation page for testing
echo '<b>Invoice:</b><br>'.$invoiceId.'" created, see '.$invoiceURL .'<br>';