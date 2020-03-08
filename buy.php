<?php
session_start();
require('/var/secure/keys.php');
require('include/functions.php');
require('include/config.php');

if ($exchange == '1') {
  //Check session contains correct variables
  if (
    $_SESSION['Address'] == '' || empty($_SESSION['Address']) ||
    $_SESSION['Total'] == '' || empty($_SESSION['Total']) ||
    $_SESSION['Price'] == '' || empty($_SESSION['Price']) ||
    $_SESSION['Quantity'] == '' || empty($_SESSION['Quantity']) ||
    $_SESSION['Session'] == '' || empty($_SESSION['Session'])
  ) {
    $functions->web_redirect("index.php");
  }
  $functions->web_redirect("index.php");
}

$functions = new phpFunctions();

  // Generate & store the InvoiceID in session
  $_SESSION['OrderID'] = 'E-'. $ticker . '-' . $_SESSION['Address'];
  // Full service description
  $serv = $ticker . "-" . $_SESSION['Price'] . " : " . $_SESSION['Address'];
  // Create invoice
  $inv = $functions->CreateInvoice($_SESSION['OrderID'], $_SESSION['Total'], $serv, $redirectURL, $ipnURL);
  $invoiceId = $inv['invoice_id'];
  $invoiceURL = $inv['invoice_url'];
  // Store the InvoiceID in session
  $_SESSION['InvoiceID'] = $invoiceId;
  // Forwarding to payment page
  header('Location:' . $invoiceURL); //<<redirect to payment page
  //echo '<br><b>Invoice:</b><br>'.$invoiceId.'" created, see '.$invoiceURL .'<br>';
?>