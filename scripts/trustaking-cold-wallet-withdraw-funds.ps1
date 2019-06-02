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
$ColdStakingAmount=""
$ColdStakingTX=""

######## Get some information from the user about the wallet ############
Clear-Host
Write-Host "#######################################################################" -ForegroundColor Red
Write-Host "########### TRUSTAKING.COM LOCAL WALLET - WITHDRAW FUNDS ##############" -ForegroundColor Red
Write-Host "#######################################################################`r`n" -ForegroundColor Red
Write-Host "Use this to withdraw funds from trustaking.com"
$response = Read-Host -Prompt "Please enter your Cold Wallet Name (default=cold-wallet)" 
if ($response) {
    $ColdWalletName = $response
}
$ColdWalletPassword = Read-Host -Prompt "Password for Cold Wallet"

##### Where do you want to return the funds to? ######
$ReturnAddress = Read-Host -Prompt "What address do you want to withdraw to?"
$ColdStakingAmount = Read-Host -Prompt "Confirm how many coins you wish to withdraw from Cold Staking" 

##### Prepare the cold staking cancel tx ######
Write-Host "* Preparing to withdraw from your cold staking and return funds ... please wait."

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

Write-Host "* Broadcasting your your cold staking withdrawal transaction ... please wait."
$json = @{
    hex = $ColdStakingTX
} | ConvertTo-Json
$response = Invoke-WebRequest "http://localhost:$apiport/api/Wallet/send-transaction" -Method Post -Body $json -ContentType 'application/json-patch+json'
$result = $response.Content | ConvertFrom-Json
LogWriter @result 
LogWriter "** End of Log **"

Write-Host "Done."
Write-Host "Here's all the details of the withdrawal:"
Write-Host "Return address" $ReturnAddress
Write-Host "Amount        " $ColdStakingAmount
Write-Host "Hex or error  " $ColdStakingTX