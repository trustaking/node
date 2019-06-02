##### Define Variables ######
$apiport=38222
$ColdWalletName="cold-wallet"

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
$WebResponse = Invoke-WebRequest "http://localhost:$apiport/api/Wallet/maxbalance?WalletName=$ColdWalletName&AccountName=account%200&FeeType=medium"  
$result = $WebResponse.Content | ConvertFrom-Json
$ColdStakingBal=$result.maxSpendableAmount
## BASH ColdStakingBalance=$(echo "scale=8; $ColdStakingBal/100000000" | bc)
$ColdStakingBalance=$ColdStakingBal/100000000

Write-Host "`r`nHere is the current balance for wallet "$ColdWalletName":" $ColdStakingBalance