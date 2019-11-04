##### Define Variables ######
$apiport=38222
$ColdWalletName="MyColdWallet"
$now = get-date

######## Get some information from the user about the wallet ############
Clear-Host
Write-Host "#######################################################################" -ForegroundColor Red -BackgroundColor Gray
Write-Host "############# TRUSTAKING.COM LOCAL WALLET - GET BALANCE ###############" -ForegroundColor Red -BackgroundColor Gray
Write-Host "#######################################################################`r`n" -ForegroundColor Red -BackgroundColor Gray
Write-Host "Use this script to get your current balance`n"

$response = Read-Host -Prompt "Please enter the name of your wallet (default=MyColdWallet)" 
if ($response) {
    $ColdWalletName = $response
}

##### Grab the balance ######
$WebResponse = Invoke-WebRequest "http://localhost:$apiport/api/Wallet/balance?WalletName=$ColdWalletName&AccountName=coldStakingColdAddresses"  
$result = $WebResponse.Content | ConvertFrom-Json
$ColdStakingBalance=$result.balances.amountConfirmed / 100000000

Write-Host "`nHere is the current confirmed balance as at $now for wallet" $ColdWalletName": " -NoNewline
Write-Host $ColdStakingBalance "`n" -ForegroundColor Green