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
$ColdStakingAmount=""
$ColdStakingTX=""

######## Get some information from the user about the wallet ############
Clear-Host
Write-Host "#######################################################################" -ForegroundColor Red -BackgroundColor Gray
Write-Host "########### TRUSTAKING.COM LOCAL WALLET - WITHDRAW FUNDS ##############" -ForegroundColor Red -BackgroundColor Gray
Write-Host "#######################################################################`r`n" -ForegroundColor Red -BackgroundColor Gray
Write-Host "Use this to withdraw funds from trustaking.com`n"
$response = Read-Host -Prompt "Please enter your Cold Wallet Name (default=MyColdWallet)" 
if ($response) {
    $ColdWalletName = $response
}
$ColdWalletPassword = Read-Host -Prompt "`nPassword for Cold Wallet"

##### Where do you want to return the funds to? ######
$ReturnAddress = Read-Host -Prompt "`nWhat address do you want to withdraw to?"
$ColdStakingAmount = Read-Host -Prompt "`nConfirm how many coins you wish to withdraw from Cold Staking" 

##### Prepare the cold staking cancel tx ######
Write-Host "`n* Preparing to withdraw from your cold staking and return funds ... please wait." -ForegroundColor DarkCyan

 $json = @{
    receivingAddress = $ReturnAddress
    walletName = $ColdWalletName
    walletPassword = $ColdWalletPassword
    amount = $ColdStakingAmount
    fees = 0.0002
} | ConvertTo-Json
$response = Invoke-WebRequest "http://localhost:$apiport/api/ColdStaking/cold-staking-withdrawal" -Method Post -Body $json -ContentType 'application/json-patch+json'
$result = $response.Content | ConvertFrom-Json
$ColdStakingTX = $result.transactionHex
LogWriter @result

##### Transmit the cold staking tx ######
Write-Host "`n* Broadcasting your your cold staking withdrawal transaction ... please wait." -ForegroundColor DarkCyan
$json = @{
    hex = $ColdStakingTX
} | ConvertTo-Json
$response = Invoke-WebRequest "http://localhost:$apiport/api/Wallet/send-transaction" -Method Post -Body $json -ContentType 'application/json-patch+json'
$result = $response.Content | ConvertFrom-Json
LogWriter @result 
LogWriter "** End of Log **"

Write-Host "`nTransaction complete.  Here are your withdrawal transaction details:" 
Write-Host "Return address:" $ReturnAddress
Write-Host "Amount        :" $ColdStakingAmount
Write-Host "Hex or error  :" $ColdStakingTX "`n"