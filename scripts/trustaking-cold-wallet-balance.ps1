##### Define Variables ######
$apiport=38222
$ColdWalletName="cold-wallet"
$now = get-date

######## Get some information from the user about the wallet ############
Clear-Host
Write-Host "#######################################################################" -ForegroundColor Red
Write-Host "########### TRUSTAKING.COM LOCAL WALLET - COLD STAKING SETUP ##########" -ForegroundColor Red
Write-Host "#######################################################################`r`n" -ForegroundColor Red
Write-Host "Use this script to get your current balance"

$response = Read-Host -Prompt "Please enter the name of your wallet (default=cold-wallet)" 
if ($response) {
    $ColdWalletName = $response
}

##### Grab the balance ######
$WebResponse = Invoke-WebRequest "http://localhost:$apiport/api/Wallet/balance?WalletName=$ColdWalletName&AccountName=coldStakingColdAddresses"  
$result = $WebResponse.Content | ConvertFrom-Json
$ColdStakingBalance=$result.balances.amountConfirmed / 100000000

Write-Host "`r`nHere is the current confirmed balance at $now for wallet " $ColdWalletName ": " -NoNewline
Write-Host $ColdStakingBalance -ForegroundColor Green