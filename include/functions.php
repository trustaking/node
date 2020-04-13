<?php

class phpFunctions
{
    public $keys;

    public function __construct() {
       $this->keys = parse_ini_file('/var/secure/keys.ini', true);
    }

    public function crypto_rand($min, $max, $pedantic = True)
    {
        $diff = $max - $min;
        if ($diff <= 0) return $min; // not so random...
        $range = $diff + 1; // because $max is inclusive
        $bits = ceil(log(($range), 2));
        $bytes = ceil($bits / 8.0);
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

    public function GetInvoiceStatus($invoiceId, $orderID)
    {
        require('vendor/autoload.php'); //loads the btcpayserver library
        $storageEngine = new \BTCPayServer\Storage\EncryptedFilesystemStorage($this->keys['encryt_pass']);
        $privateKey    = $storageEngine->load('/var/secure/btcpayserver.pri');
        $publicKey     = $storageEngine->load('/var/secure/btcpayserver.pub');
        $client        = new \BTCPayServer\Client\Client();
        $adapter       = new \BTCPayServer\Client\Adapter\CurlAdapter();

        $client->setPrivateKey($privateKey);
        $client->setPublicKey($publicKey);
        $client->setUri($this->keys['btcpayserver']);
        $client->setAdapter($adapter);

        $token = new \BTCPayServer\Token();
        $token->setToken($this->keys['pair_token']);
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

    public function CreateInvoice($OrderID, $Price, $Description)
    {
        require('vendor/autoload.php'); //loads the btcpayserver library
        $storageEngine = new \BTCPayServer\Storage\EncryptedFilesystemStorage($this->keys['encryt_pass']);
        $privateKey    = $storageEngine->load('/var/secure/btcpayserver.pri');
        $publicKey     = $storageEngine->load('/var/secure/btcpayserver.pub');
        $client        = new \BTCPayServer\Client\Client();
        $adapter       = new \BTCPayServer\Client\Adapter\CurlAdapter();

        $client->setPrivateKey($privateKey);
        $client->setPublicKey($publicKey);
        $client->setUri($this->keys['btcpayserver']);
        $client->setAdapter($adapter);

        $token = new \BTCPayServer\Token();
        $token->setToken($this->keys['pair_token']);
        //$token->setFacade('merchant');
        $client->setToken($token);

        // * This is where we will start to create an Invoice object, make sure to check
        // * the InvoiceInterface for methods that you can use.
        $invoice = new \BTCPayServer\Invoice();
        $buyer = new \BTCPayServer\Buyer();
        //$buyer->setEmail($email);

        // Add the buyers info to invoice
        $invoice->setBuyer($buyer);

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
            ->setNotificationUrl($ipnURL)
            ->setOrderId($OrderID)
            ->setRedirectURL($redirectURL);

        // Updates invoice with new information such as the invoice id and the URL where
        // a customer can view the invoice.
        try {
            echo "Creating invoice at Trustaking.com now." . PHP_EOL;
            $client->createInvoice($invoice);
        } catch (\Exception $e) {
            echo "Exception occured: " . $e->getMessage() . PHP_EOL;
            $request  = $client->getRequest();
            $response = $client->getResponse();
            echo (string) $request . PHP_EOL . PHP_EOL . PHP_EOL;
            echo (string) $response . PHP_EOL . PHP_EOL;
            exit(1); // We do not want to continue if something went wrong
        }

        return array('invoice_id' => $invoice->getId(), 'invoice_url' => $invoice->getUrl());
    }

    public function web_redirect($url, $permanent = false)
    {
        if ($permanent) {
            header('HTTP/1.1 301 Moved Permanently');
        }
        header('Location: ' . $url);
        exit();
    }
}
?>