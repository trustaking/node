<?php
session_start();
require('/var/secure/keys.php');
require('include/functions.php');
require('include/config.php');

// Set price and and Expiry based on plan number
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Quantity']) && isset($_POST['Address'])) {
  $_SESSION['Quantity'] = $_POST["Quantity"]; // Grab quantity and add to session
  $_SESSION['Address'] = $_POST["Address"]; // Grab address and add to session
} else {
  header('Location:' . 'index.php'); //  otherwise redirect to home page
}

// Calculate Total Price
$_SESSION['Total'] = $_SESSION['Quantity'] * $_SESSION['Price'];

$wallet = new phpFunctions_Wallet();

  // Generate & store the InvoiceID in session
  $_SESSION['OrderID'] = $_SESSION['Address'];
  // Full service description
  $serv = $ticker . "-" . $_SESSION['Price'] . " : " . $_SESSION['Address'];
  // Create invoice
  $inv = $wallet->CreateInvoice($_SESSION['OrderID'], $_SESSION['Total'], $serv, $redirectURL, $ipnURL);
  $invoiceId = $inv['invoice_id'];
  $invoiceURL = $inv['invoice_url'];
  // Store the InvoiceID in session
  $_SESSION['InvoiceID'] = $invoiceId;
  // Forwarding to payment page
  header('Location:' . $invoiceURL); //<<redirect to payment page
  //echo '<br><b>Invoice:</b><br>'.$invoiceId.'" created, see '.$invoiceURL .'<br>';

}
