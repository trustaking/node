Function LogWriter
{
    Param ([string]$logstring)
    Add-Content $logfile -value $logstring
}

##### Define Variables ######
$apiport=38222
$date_stamp=(Get-Date).ToString('yyyyMMddTHHmmssffffZ')
$logfile="$env:temp\trustaking-$date_stamp-output.log"
$ColdWalletName="cold-wallet"
$ColdWalletPassword=""
$ColdWalletPassphrase=""
$ColdWalletInitialFundingAddress=""
$ColdWalletColdStakingColdAddress=""
$ColdStakingAmount=""
$ColdStakingTX=""

######## Get some information from the user about the wallet ############
Clear-Host
Write-Host "#######################################################################" -ForegroundColor Red
Write-Host "########### TRUSTAKING.COM LOCAL WALLET - COLD STAKING SETUP ##########" -ForegroundColor Red
Write-Host "#######################################################################`r`n" -ForegroundColor Red
Write-Host "Use this to add funds to your existing cold wallet."
$response = Read-Host -Prompt "Please enter your Cold Wallet Name (default=cold-wallet)" 
if ($response) {
    $ColdWalletName = $response
}
$ColdWalletPassword = Read-Host -Prompt "Password for Cold Wallet"

##### Grab the Cold wallet funding address ##########
$WebResponse = Invoke-WebRequest "http://localhost:$apiport/api/Wallet/unusedaddress?WalletName=$ColdWalletName&AccountName=account%200"
$ColdWalletInitialFundingAddress = $WebResponse.Content -replace '"', ""

##### Display info about the Cold wallet & funding details ######
Write-Host "Send the funds you want to cold stake to this initial funding address on your Cold wallet then wait for the coins to confirm: "
Write-Host $ColdWalletInitialFundingAddress

Write-Host -NoNewLine 'Press any key to continue...';
$null = $Host.UI.RawUI.ReadKey('NoEcho,IncludeKeyDown');

##### Get the Cold Wallet - Cold Address ######
$WebResponse = Invoke-WebRequest "http://localhost:$apiport/api/ColdStaking/cold-staking-address?WalletName=$ColdWalletName&IsColdWalletAddress=true"
$result = $WebResponse.Content | ConvertFrom-Json
$ColdWalletColdStakingColdAddress=$result.address
LogWriter "ColdWalletColdStakingColdAddress: $ColdWalletColdStakingColdAddress"

##### Enter the Staking Address from Trustaking.com ######
$HotWalletColdStakingHotAddress = Read-Host -Prompt "Enter your address from trustaking.com"
$ColdStakingAmount = Read-Host -Prompt "Confirm how many coins you wish to start staking at trustaking.com"
LogWriter "HotWalletColdStakingHotAddress: $HotWalletColdStakingHotAddress Amount: $ColdStakingAmount"

##### Prepare the cold staking tx ######
Write-Host "* Preparing your cold staking transaction ... please wait."

$json = @{
    coldWalletAddress = $ColdWalletColdStakingColdAddress
    hotWalletAddress = $HotWalletColdStakingHotAddress
    walletName = $ColdWalletName
    walletPassword = $ColdWalletPassword
    walletAccount = "account 0"
    amount = $ColdStakingAmount
    fees = 0.0002
} | ConvertTo-Json
$response = Invoke-WebRequest "http://localhost:$apiport/api/ColdStaking/setup-cold-staking" -Method Post -Body $json -ContentType 'application/json-patch+json'
$result = $response.Content | ConvertFrom-Json
$ColdStakingTX = $result.transactionHex
LogWriter $ColdStakingTX

##### Transmit the cold staking tx ######
$json = @{
    hex = $ColdStakingTX
} | ConvertTo-Json
$response = Invoke-WebRequest "http://localhost:$apiport/api/Wallet/send-transaction" -Method Post -Body $json -ContentType 'application/json-patch+json'
$result = $response.Content | ConvertFrom-Json
LogWriter $response.Content
LogWriter "** End of Log **"

Write-Host "Done.  The transaction ID is:" $result.transactionId.ToString()
Write-Host "Here's your cold wallet details. These are you're responsibility trustaking.com has no way to recover this information - keep this information safe offline:"
Write-Host "Name      	:" $ColdWalletName
Write-Host "Password  	:" $ColdWalletPassword
Write-Host "Funding address :" $ColdWalletInitialFundingAddress
Write-Host "Cold address    :" $ColdWalletColdStakingColdAddress
Write-Host "Hot address     :" $HotWalletColdStakingHotAddress
Write-Host "Amount          :" $ColdStakingAmount