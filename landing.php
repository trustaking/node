<?php 
    session_start(); // start a session before any output - config is always called first

    require ('/var/secure/keys.php'); //secured location - sensitive keys
    require ('include/config.php'); // coin configuration
    require ('include/functions.php'); // standard functions
    require ('vendor/autoload.php'); //loads the btcpayserver library

    $wallet = new phpFunctions_Wallet();
    $OrderID = $ticker . '-' . $wallet->crypto_rand(100000000000,999999999999);

    $storageEngine = new \BTCPayServer\Storage\EncryptedFilesystemStorage($encryt_pass); // Password may need to be updated if you changed it
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

    // Token object is injected into the client
    $client->setToken($token);

    // * This is where we will start to create an Invoice object, make sure to check
    // * the InvoiceInterface for methods that you can use.
    $invoice = new \BTCPayServer\Invoice();
    $buyer = new \BTCPayServer\Buyer();
    $buyer
    ->setEmail($email);
    // Add the buyers info to invoice
    $invoice->setBuyer($buyer);

    // Item is used to keep track of a few things
    $item = new \BTCPayServer\Item();
    $item
    //    ->setCode('skuNumber')
        ->setDescription('1 month Trustaking service')
        ->setPrice('2.00');
    $invoice->setItem($item);

    // BTCPayServer supports multiple different currencies. Most shopping cart applications
    // and applications in general have defined set of currencies that can be used.
    // Setting this to one of the supported currencies will create an invoice using
    // the exchange rate for that currency.
    $invoice->setCurrency(new \BTCPayServer\Currency('USD'));

    // Configure the rest of the invoice
    $invoice
        ->setOrderId($OrderID)
        //->setNotificationUrl('https://store.example.com/btcpayserver/callback')
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

    // Store the InvoiceID in session
    $_SESSION['InvoiceID']=$invoice->getId();

    // Forwarding to payment page
    header('Location:' . $invoice->getUrl()); //<<redirect to payment page

//header('Location: activation.php'); // <<redirect to activation page for testing
//echo '<b>Invoice:</b><br>'.$invoice->getId().'" created, see '.$invoice->getUrl() .'<br>';