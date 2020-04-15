<?php
session_start();
require_once('include/coin-functions.php');
require_once('include/functions.php');
$coinFunctions = new phpCoinFunctions();
$functions = new phpFunctions();
$_SESSION['session'] = 'Open';