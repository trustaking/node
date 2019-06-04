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
$ColdWalletSecretWords=""
$ColdWalletPassword=""
$ColdWalletPassphrase=""
$ColdWalletInitialFundingAddress=""
$ColdWalletColdStakingColdAddress=""
$ColdStakingAmount=""
$ColdStakingTX=""

######## Get some information from the user about the wallet ############
Clear-Host
Write-Host "#######################################################################" -ForegroundColor Red -BackgroundColor Gray
Write-Host "########### TRUSTAKING.COM LOCAL WALLET - COLD STAKING SETUP ##########" -ForegroundColor Red -BackgroundColor Gray
Write-Host "#######################################################################`r`n" -ForegroundColor Red -BackgroundColor Gray
Write-Host "Firstly, let's create your cold wallet (which will hold the funds offline)`n"
$response = Read-Host -Prompt "Please enter your preferred Cold Wallet Name (default=MyColdWallet)" 
if ($response) {
    $ColdWalletName = $response
}

$ColdWalletPassword = Read-Host -Prompt "`nPassword for Cold Wallet"
$ColdWalletPassphrase = Read-Host -Prompt "`nPassphrase for Cold Wallet" 

##### Setup the Cold wallet ########
Write-Host "`n* Creating your Cold wallet ... please wait." -ForegroundColor DarkCyan

$WebResponse = Invoke-WebRequest "http://localhost:$apiport/api/Wallet/mnemonic?language=english&wordCount=12"  ### grab a 12 word mneumonic
$ColdWalletSecretWords = $WebResponse.Content -replace '"', ""

$json = @{
    mnemonic = $ColdWalletSecretWords
    password = $ColdWalletPassword
    passphrase = $ColdWalletPassphrase
    name = $ColdWalletName
    creationDate = (get-date).ToString("yyyy-MM-ddTHH:mm:ssZ")
} | ConvertTo-Json
$response = Invoke-WebRequest "http://localhost:$apiport/api/Wallet/recover" -Method Post -Body $json -ContentType 'application/json-patch+json'
LogWriter "Wallet recover result: $response"
Write-Host "* Cold Wallet Creation Result:" $response.StatusDescription -ForegroundColor DarkCyan

##### Grab the Cold wallet funding address ##########
#Write-Host "* Getting the Initial funding address ... please wait."
$WebResponse = Invoke-WebRequest "http://localhost:$apiport/api/Wallet/unusedaddress?WalletName=$ColdWalletName&AccountName=account%200"
$ColdWalletInitialFundingAddress = $WebResponse.Content -replace '"', ""
LogWriter "ColdWalletInitialFundingAddress: $ColdWalletInitialFundingAddress"

##### Display info about the Cold wallet & funding details ######
Write-Host "`nSend the funds you want to cold stake to this initial funding address on your Cold wallet then wait for the coins to confirm: "
Write-Host $ColdWalletInitialFundingAddress "`n"

Write-Host -NoNewLine 'Press any key to continue...';
$null = $Host.UI.RawUI.ReadKey('NoEcho,IncludeKeyDown');

##### Convert the Cold wallet to a cold staking wallet ######
$json = @{
    walletName = $ColdWalletName
    walletPassword = $ColdWalletPassword
    isColdWalletAccount = $true
} | ConvertTo-Json

$response = Invoke-WebRequest "http://localhost:$apiport/api/ColdStaking/cold-staking-account" -Method Post -Body $json -ContentType 'application/json-patch+json'

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
Write-Host "`n* Preparing your cold staking transaction ... please wait."
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

Write-Host "`nCold Staking Setup complete."
Write-Host "`nHere's your cold wallet details:"
Write-Host "Name      	:" $ColdWalletName
Write-Host "Password  	:" $ColdWalletPassword
Write-Host "Passphrase	:" $ColdWalletPassphrase
Write-Host "Mnemonic  	:" $ColdWalletSecretWords
Write-Host "Funding address :" $ColdWalletInitialFundingAddress
Write-Host "Cold address    :" $ColdWalletColdStakingColdAddress
Write-Host "Hot address     :" $HotWalletColdStakingHotAddress
Write-Host "Amount          :" $ColdStakingAmount
Write-Host "Transaction ID  :" $result.transactionId.ToString()
Write-Host "`n!!! Keeping your cold wallet details safe is your responsibility!`nTrustaking.com has no way to recover this information - keep this information safe offline.`n" -ForegroundColor Red -BackgroundColor Yellow