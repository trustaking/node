<?php
include('include/initialise.php');

//Check session contains correct variables

if (($coinFunctions->config['exchange'] == '1') && 
    ( $_SESSION['Address'] == '' || empty($_SESSION['Address']) ||
    $_SESSION['Total'] == '' || empty($_SESSION['Total']) ||
    $_SESSION['Price'] == '' || empty($_SESSION['Price']) ||
    $_SESSION['Quantity'] == '' || empty($_SESSION['Quantity']) ||
    $_SESSION['session'] == '' || empty($_SESSION['session'])
  )) {
    $functions->web_redirect("index.php");
  }

  // Generate & store the InvoiceID in session
  $_SESSION['OrderID'] = 'EX-'. $coinFunctions->config['ticker'] . '-' . $_SESSION['Address'];
  // Full service description
  $serv = $coinFunctions->config['ticker'] . "-" . $_SESSION['Price'] . " : " . $_SESSION['Address'];
  // Create invoice
  $inv = $functions->CreateInvoice($_SESSION['OrderID'], $_SESSION['Total'], $serv);
  $invoiceId = $inv['invoice_id'];
  $invoiceURL = $inv['invoice_url'];
  // Store the InvoiceID in session
  $_SESSION['InvoiceID'] = $invoiceId;
  // Forwarding to payment page
//  $functions->web_redirect($invoiceURL); // redirect to payment page
  echo '<br><b>Invoice:</b><br>'.$invoiceId.'" created, see '.$invoiceURL .'<br>';
?>