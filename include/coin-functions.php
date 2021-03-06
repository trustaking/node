<?php

class phpCoinFunctions
{

    public $keys;
    public $config;

    public function __construct()
    {
        if (!file_exists('include/config.ini')) {
            $this->displayError('Config file missing');
        } else {
            $this->config = parse_ini_file('include/config.ini', true);
        }
        if (!file_exists('/var/secure/keys.ini')) {
            $this->displayError('Keys file missing');
        } else {
            $this->keys = parse_ini_file('/var/secure/keys.ini', true);
        }
    }

    public function displayError($errorText) {
        echo '<pre>'.$errorText.'</pre>';
        //TODO Log Error
    }

    public function CallAPI($url, $request_type, $params = null)
    {
        $payload = json_encode($params);
        if ($request_type == 'POST') {
            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLINFO_HEADER_OUT => true,            // to track the handle's request string. 
                CURLOPT_POSTFIELDS => $payload,         // holds the json payload
                CURLOPT_POST => true,                  // POST
                CURLOPT_HTTPHEADER => array(
                    'accept: application/json',
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($payload)
                ),
            );
            $ch = curl_init($url);
        } else {
            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLINFO_HEADER_OUT => true,            // to track the handle's request string. 
                CURLOPT_HTTPHEADER => array(
                    'accept: application/json',
                    'Content-Type: application/json'
                ),
            );
            $ch = curl_init($url. '?' . http_build_query($params));
        }

        curl_setopt_array($ch, $options);     
        $response = curl_exec($ch);
        $result = json_decode($response, true);
        curl_close($ch);
        return $result;
    }

    public function rpc($command, $params = null)
    {
        $url = 'http://localhost:' . $this->config['rpc_port'] . '/';
        $request = '{"jsonrpc": "1.0", "$rpcuser":"$rpcpass", "method": "' . $command . '", "params": [' . $params . '] }';
        $rpcauth = $this->config['rpcuser'].':'.$this->config['rpcpass'];

        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_BINARYTRANSFER => true,
            CURLINFO_HEADER_OUT => true,           // to track the handle's request string. 
            CURLOPT_POSTFIELDS => $request,        // holds the json payload
            CURLOPT_POST => true,                  // POST
            CURLOPT_USERPWD => $rpcauth,
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'Content-Type: application/json',
                'Content-Length: ' . strlen($request)
            ),
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $response = json_decode($response, true);

        if (is_array($response)) {
            $result = $response['result'];
            $error = $response['error'];
        } else {
            $result = '';
            $error = '';
        }

        if (isset($error)) {
            return $error;
        } else {
            return $result;
        }
        curl_close($ch);
    }

    public function getBalance($accountName = null)
    {

        if ($accountName == '') {
            $accountName = $this->config['AccountName']; // default to config, Cold Addresses
        }

        $params = [
            'AccountName' => $accountName,
            'WalletName' => $this->config['WalletName']
        ];

        $url = 'http://localhost:' . $this->config['api_port'] . "/api/Wallet/balance";
        $response = $this->CallAPI($url,"GET",$params);

        if (isset($response) && array_key_exists('errors', $response)) {
            if ($this->config['debug'] == '1') {
                $this->displayError('Are the credentials correct as there was an error with: ' . $url);
                $this->displayError(json_encode($response,JSON_PRETTY_PRINT));
                $this->displayError(json_encode($params,JSON_PRETTY_PRINT));
            } else {
                $this->displayError('Error connecting to the node .. please inform the administrator');
            }
        } else {
            foreach ($response as $a => $b) {
                foreach ($b as $c => $d) {
                }
                if (array_key_exists('amountConfirmed', $d)) {
                    $result = floor($d['amountConfirmed'] / 100000000);
                }
            }
            return $result;
        }
    }

    public function setStakingExpiry($address,$stakeExpiry)
    {
        $params = [
            'walletName' => $this->config['WalletName'],
            'address' => $address,
            'stakingExpiry' => $stakeExpiry,
            ];
        $url = 'http://localhost:' . $this->config['api_port'] . '/api/Staking/stakingExpiry';
        $response = $this->CallAPI ($url,"POST",$params);

        if (isset($response) && array_key_exists('errors', $response)) {
            if ($this->config['debug'] == '1') {
                $this->displayError('Are the credentials correct as there was an error with: ' . $url);
                $this->displayError(json_encode($response,JSON_PRETTY_PRINT));
                $this->displayError(json_encode($params,JSON_PRETTY_PRINT));
            } else {
                $this->displayError('Error connecting to the node .. please inform the administrator');
            }
        } else {
          return $response;
        }
    }

    public function getStakingExpiry($address = null)
    {
        $params = [
            'walletName' => $this->config['WalletName'],
            'segwit' =>$this->config['segwit']
            ];
        $url = 'http://localhost:' . $this->config['api_port'] . '/api/Staking/getStakingNotExpired';
        $response = $this->CallAPI ($url,"POST",$params);

            if (isset($response) && array_key_exists('errors', $response)) {
                if ($this->config['debug'] == '1') {
                    $this->displayError('Are the credentials correct as there was an error with: ' . $url);
                    $this->displayError(json_encode($response,JSON_PRETTY_PRINT));
                    $this->displayError(json_encode($params,JSON_PRETTY_PRINT));
                } else {
                    $this->displayError('Error connecting to the node .. please inform the administrator');
                }
            } else {
                if (isset ($address)) {
                    foreach($response as $a => $b){
                        $i=0;
                        foreach($b as $c => $d){ // /[^a-z|\s+]+/i /[^0-9]/
                            $add = trim((json_encode($response['addresses'][$i]['address'])),'"') ;
                            $exp = strtr(trim(json_encode($response['addresses'][$i]['expiry']),'"'),"T"," ") ;
                            $exp = substr($exp, 0, strlen($exp)-4);
                            if ( $add == $address ) {
                                $result = $exp;
                            }
                            $i++;
                        }
                    }
                } else {
            $result = $response;
        }
        if (isset($result)){
            return $result;
        } else {
            return "Expired";
        }
    }
}

    public function startStaking()
    {
        $params = [
            'name' => $this->config['WalletName'],
            'password' => $this->config['WalletPassword'],
            ];
        $url = 'http://localhost:' . $this->config['api_port'] .'/api/Staking/startstaking';
        $response = $this->CallAPI ($url,"POST",$params);       
        if (isset($response) && array_key_exists('errors', $response)) {
            if ($this->config['debug'] == '1') {
                $this->displayError('Are the credentials correct as there was an error with: ' . $url);
                $this->displayError(json_encode($response,JSON_PRETTY_PRINT));
                $this->displayError(json_encode($params,JSON_PRETTY_PRINT));
            } else {
                $this->displayError('Error connecting to the node .. please inform the administrator');
            }
        } else {
          return $response;
        }
    }

    public function stopStaking()
    {
        $url = 'http://localhost:' . $this->config['api_port'] .'/api/Staking/stopstaking';
        $response = $this->CallAPI ($url,"POST","true");
     
        if (isset($response) && array_key_exists('errors', $response)) {
            if ($this->config['debug'] == '1') {
                $this->displayError('Are the credentials correct as there was an error with: ' . $url);
                $this->displayError(json_encode($response,JSON_PRETTY_PRINT));
            } else {
                $this->displayError('Error connecting to the node .. please inform the administrator');
            }
        } else {
          return $response;
        }
    }

    public function getAddress()
    {
        $params = [
            'walletName' => $this->config['WalletName'],
            'AccountName' => 'account 0', // $this->config['AccountName'], // Cold Addresses
            'Segwit' => $this->config['segwit']
            ];
        $url = 'http://localhost:' . $this->config['api_port'] .'/api/Wallet/unusedaddress';
        $response = $this->CallAPI ($url,"GET",$params);
  
        if (is_array($response) && array_key_exists('errors', $response)) {
            if ($this->config['debug'] == '1') {
                $this->displayError('Are the credentials correct as there was an error with: ' . $url);
                $this->displayError(json_encode($response,JSON_PRETTY_PRINT));
                $this->displayError(json_encode($params,JSON_PRETTY_PRINT));
            } else {
                $this->displayError('Error connecting to the node .. please inform the administrator');
            }
        } else {
          return $response;
        }
    }

    public function getColdStakingAddress($addressType)
    {

        if ($addressType == "Hot") {
            $addressType = "false";
        } else {
            $addressType = "true"; 
        }

        $params = [
            'walletName' => $this->config['WalletName'],
            'IsColdWalletAddress' =>$addressType, 
            'Segwit' => $this->config['segwit']
            ];

        $url = 'http://localhost:' . $this->config['api_port'] .'/api/ColdStaking/cold-staking-address';
        $response = $this->CallAPI($url,"GET",$params);
        if (isset($response) && array_key_exists('errors', $response)) {
            if ($this->config['debug'] == '1') {
                $this->displayError('Are the credentials correct as there was an error with: ' . $url);
                $this->displayError(json_encode($response,JSON_PRETTY_PRINT));
                $this->displayError(json_encode($params,JSON_PRETTY_PRINT));
            } else {
                $this->displayError('Error connecting to the node .. please inform the administrator');
            }
        } else {
          return $response['address'];
        }
    }

    // curl -X 'GET' 'http://localhost:17103/api/Wallet/history?WalletName=hot&AccountName=coldStakingHotAddresses&Address=ygCc34jiu6d6pTrt1WtFd9SCNuZgRVbBwp' -H 'accept: */*'

    public function getAddressHistory($address = null)
    {
        $params = [
            'WalletName' => $this->config['WalletName'],
            'AccountName' => $this->config['AccountName'],
            'Address' => $address
        ];
        $url = 'http://localhost:' . $this->config['api_port'] . '/api/Wallet/history';
        $response = $this->CallAPI($url, "GET", $params);

        if (isset($response) && array_key_exists('errors', $response)) {
            if ($this->config['debug'] == '1') {
                $this->displayError('Are the credentials correct as there was an error with: ' . $url);
                $this->displayError(json_encode($response, JSON_PRETTY_PRINT));
                $this->displayError(json_encode($params, JSON_PRETTY_PRINT));
            } else {
                $this->displayError('Error connecting to the node .. please inform the administrator');
            }
        } else {
            return $response;
        }
    }

//    http://localhost:17103/api/Wallet/received-by-address?Address=XDJrwwv5FDWbtJYywH3kDmqkWyd1PaeWv5

    public function getAddressBalance($address = null)
    {
        $params = [
            'Address' => $address
        ];
        $url = 'http://localhost:' . $this->config['api_port'] . '/api/Wallet/received-by-address';
        $response = $this->CallAPI($url, "GET", $params);

        if (isset($response) && array_key_exists('errors', $response)) {
            if ($this->config['debug'] == '1') {
                $this->displayError('Are the credentials correct as there was an error with: ' . $url);
                $this->displayError(json_encode($response, JSON_PRETTY_PRINT));
                $this->displayError(json_encode($params, JSON_PRETTY_PRINT));
            } else {
                $this->displayError('Error connecting to the node .. please inform the administrator');
            }
        } else {
            return $response;
        }
    }

    public function sendTx($address,$amount)
    {
        // Build transaction
        $params = [
            'password' => $this->config['WalletPassword'],
            'walletName' => $this->config['WalletName'],
            'feeAmount' => '0.01',
            'segwitChangeAddress' => $this->config['segwit'],            
            'recipients' => [
                [
                 'destinationAddress' => $address,
                 'amount' => $amount
                 ]
            ]
        ];

        $url = 'http://localhost:' . $this->config['api_port'] .'/api/Wallet/build-transaction';
        $hex = $this->CallAPI($url,"POST",$params);
        
        // Broadcast transaction
         $params = [
             'hex' => $hex['hex']
             ];

         $url = 'http://localhost:' . $this->config['api_port'] .'/api/Wallet/send-transaction';
         $response = $this->CallAPI($url,"POST",$params);
         if (isset($response) && array_key_exists('errors', $response)) {
            if ($this->config['debug'] == '1') {
                $this->displayError('Are the credentials correct as there was an error with: ' . $url);
                $this->displayError(json_encode($response,JSON_PRETTY_PRINT));
                $this->displayError(json_encode($params,JSON_PRETTY_PRINT));
            } else {
                $this->displayError('Error connecting to the node .. please inform the administrator');
            }
        } else {
          return $response;
        }
    }
}
