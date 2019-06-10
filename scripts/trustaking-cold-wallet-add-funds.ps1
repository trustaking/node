Function LogWriter
{
    Param ([string]$logstring)
    Add-Content $logfile -value $logstring
}

##### Define Variables ######
$apiport=38222
$date_stamp=(Get-Date).ToString('yyyyMMddTHHmmssffffZ')
$logfile="$env:temp\trustaking-$date_stamp-output.log"
$ColdWalletName="MyColdWallet"
$ColdWalletPassword=""
$ColdWalletInitialFundingAddress=""
$ColdWalletColdStakingColdAddress=""
$ColdStakingAmount=""
$ColdStakingTX=""

######## Get some information from the user about the wallet ############
Clear-Host
Write-Host "#######################################################################" -ForegroundColor Red -BackgroundColor Gray
Write-Host "############### TRUSTAKING.COM LOCAL WALLET - ADD FUNDS ###############" -ForegroundColor Red -BackgroundColor Gray
Write-Host "#######################################################################`r`n" -ForegroundColor Red -BackgroundColor Gray
Write-Host "Please follow the prompts to add funds to your existing cold wallet.`n"
$response = Read-Host -Prompt "Please enter your Cold Wallet Name (default=MyColdWallet)" 
if ($response) {
    $ColdWalletName = $response
}
$ColdWalletPassword = Read-Host -Prompt "`nPassword for Cold Wallet"

##### Grab the Cold wallet funding address ##########
$WebResponse = Invoke-WebRequest "http://localhost:$apiport/api/Wallet/unusedaddress?WalletName=$ColdWalletName&AccountName=account%200"
$ColdWalletInitialFundingAddress = $WebResponse.Content -replace '"', ""

##### Display info about the Cold wallet & funding details ######
Write-Host "`nSend the funds you want to cold stake to this initial funding address on your Cold wallet then wait for the coins to confirm: "
Write-Host $ColdWalletInitialFundingAddress "`n"

Write-Host -NoNewLine 'Press any key to continue...';
$null = $Host.UI.RawUI.ReadKey('NoEcho,IncludeKeyDown');

##### Get the Cold Wallet - Cold Address ######
$WebResponse = Invoke-WebRequest "http://localhost:$apiport/api/ColdStaking/cold-staking-address?WalletName=$ColdWalletName&IsColdWalletAddress=true"
$result = $WebResponse.Content | ConvertFrom-Json
$ColdWalletColdStakingColdAddress=$result.address
LogWriter "ColdWalletColdStakingColdAddress: $ColdWalletColdStakingColdAddress"

##### Enter the Staking Address from Trustaking.com ######
$HotWalletColdStakingHotAddress = Read-Host -Prompt "`n`nEnter your address from trustaking.com"
$ColdStakingAmount = Read-Host -Prompt "`nConfirm how many coins you wish to start staking at trustaking.com"
LogWriter "HotWalletColdStakingHotAddress: $HotWalletColdStakingHotAddress Amount: $ColdStakingAmount"

##### Prepare the cold staking tx ######
Write-Host "`n* Preparing your cold funding staking transaction ... please wait." -ForegroundColor DarkCyan
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
Write-Host "`n* Broadcasting your your cold staking funding transaction ... please wait." -ForegroundColor DarkCyan
$json = @{
    hex = $ColdStakingTX
} | ConvertTo-Json
$response = Invoke-WebRequest "http://localhost:$apiport/api/Wallet/send-transaction" -Method Post -Body $json -ContentType 'application/json-patch+json'
$result = $response.Content | ConvertFrom-Json
LogWriter $response.Content
LogWriter "** End of Log **"

Write-Host "`nTransaction complete.  Here are your funding transaction details:" 
Write-Host "Name      	:" $ColdWalletName
Write-Host "Funding address :" $ColdWalletInitialFundingAddress
Write-Host "Cold address    :" $ColdWalletColdStakingColdAddress
Write-Host "Hot address     :" $HotWalletColdStakingHotAddress
Write-Host "Amount          :" $ColdStakingAmount
Write-Host "Transaction ID  :" $result.transactionId.ToString()
Write-Host "`n!!! Keeping your cold wallet details safe is your responsibility!`nTrustaking.com has no way to recover this information - keep this information safe offline.`n" -ForegroundColor Red -BackgroundColor Yellow
