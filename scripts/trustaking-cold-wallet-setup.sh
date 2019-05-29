#!/bin/bash
NONE='\033[00m'
RED="\033[01;31m"
GREEN='\033[01;32m'
YELLOW='\033[01;33m'
PURPLE='\033[01;35m'
CYAN='\033[01;36m'
WHITE='\033[01;37m'
BOLD='\033[1m'
UNDERLINE='\033[4m'

##### Define Variables ######
apiport=38222
date_stamp="$(date +%y-%m-%d-%s)"
logfile="/tmp/log_$date_stamp_output.log"
ColdWalletName="MyColdWallet"
ColdWalletSecretWords=""
ColdWalletPassword=""
ColdWalletPassphrase=""
ColdWalletInitialFundingAddress=""
ColdWalletColdStakingHotAddress=""
ColdWalletColdStakingColdAddress=""
ColdStakingAmount=""
ColdStakingTX=""

######## Get some information from the user about the wallet ############
clear
echo -e "${RED}${BOLD}#######################################################################${NONE}"
echo -e "${RED}${BOLD}########### TRUSTAKING.COM LOCAL WALLET - COLD STAKING SETUP ##########${NONE}"
echo -e "${RED}${BOLD}#######################################################################${NONE}"
echo
echo -e "${BOLD}Firstly, let's create your cold wallet (which will hold the funds offline)${NONE}"
echo 
read -p "Name (default=MyColdWallet): " response
if [[ "$response" != "" ]] ; then 
   ColdWalletName="$response" 
fi
read -p "Password: " response
ColdWalletPassword="$response"
read -p "Passphrase: " response
ColdWalletPassphrase="$response"
echo 
##### Setup the Cold wallet ########

echo -e "${RED}* Creating your Cold wallet ... please wait.${NONE}"

ColdWalletSecretWords=$(sed -e 's/^"//' -e 's/"$//' <<<$(curl -sX GET "http://localhost:$apiport/api/Wallet/mnemonic?language=english&wordCount=12" -H "accept: application/json")) ### grab a 12 word mneumonic
curl -sX POST "http://localhost:$apiport/api/Wallet/create" -H  "accept: application/json" -H  "Content-Type: application/json-patch+json" -d "{  \"mnemonic\": \"$ColdWalletSecretWords\",  \"password\": \"$ColdWalletPassword\",  \"passphrase\": \"$ColdWalletPassphrase\",  \"name\": \"$ColdWalletName\"}" &>> ${logfile}

echo -e "${GREEN}Done.${NONE}"
echo

##### Grab the Cold wallet funding address ##########

#echo -e "${RED}* Getting the Initial funding address ... please wait."

ColdWalletInitialFundingAddress=$(sed -e 's/^"//' -e 's/"$//' <<<$(curl -sX GET "http://localhost:$apiport/api/Wallet/unusedaddress?WalletName=$ColdWalletName&AccountName=account%200" -H  "accept: application/json"))

#echo -e "${GREEN}Done.${NONE}"
#echo

##### Display info about the Cold wallet & funding details ######

echo -e "${GREEN}Send the funds you want to cold stake to this initial funding address on your Cold wallet then wait for the coins to confirm: ${NONE}"
echo
echo -e $ColdWalletInitialFundingAddress
echo
read -p "Press a key to continue." response
echo

##### Convert the Cold wallet to a cold staking wallet ######

#echo -e "${RED}* Upgrading your Cold wallet for cold staking   ... please wait.${NONE}"

curl -sX POST "http://localhost:$apiport/api/ColdStaking/cold-staking-account" -H  "accept: application/json" -H  "Content-Type: application/json-patch+json" -d "{  \"walletName\": \"$ColdWalletName\",  \"walletPassword\": \"$ColdWalletPassword\",  \"isColdWalletAccount\": true}" &>> ${logfile}

#echo -e "${GREEN}Done.${NONE}"
#echo

##### Get the Cold Wallet - Cold Address ######

#echo -e "${RED}* Fetching your Cold wallet details  ... please wait.${NONE}"

ColdWalletColdStakingColdAddress=$(curl -sX GET "http://localhost:$apiport/api/ColdStaking/cold-staking-address?WalletName=$ColdWalletName&IsColdWalletAddress=true" -H  "accept: application/json")

ColdWalletColdStakingColdAddress=${ColdWalletColdStakingColdAddress:12:34}

#echo -e "${GREEN}Done.${NONE}"
#echo

##### Enter the Staking Address from Trustaking.com ######

read -p "Enter your address from trustaking.com: " response
HotWalletColdStakingHotAddress="$response"
read -p "Confirm how many coins you wish to start staking at trustaking.com: " response
ColdStakingAmount="$response"
echo

##### Prepare the cold staking tx ######

echo -e "${RED}* Preparing your cold staking transaction ... please wait.${NONE}"

ColdStakingTX=$(curl -sX POST "http://localhost:$apiport/api/ColdStaking/setup-cold-staking" -H  "accept: application/json" -H  "Content-Type: application/json-patch+json" -d "{  \"coldWalletAddress\": \"$ColdWalletColdStakingColdAddress\",  \"hotWalletAddress\": \"$HotWalletColdStakingHotAddress\",  \"walletName\": \"$ColdWalletName\",  \"walletPassword\": \"$ColdWalletPassword\",  \"walletAccount\": \"account 0\",  \"amount\": \"$ColdStakingAmount\",  \"fees\": \"0.0002\"}")

ColdStakingTX=${ColdStakingTX:19:512}

#echo -e "${GREEN}Done.${NONE}"
#echo

##### Transmit the cold staking tx ######

#echo -e "${RED}*Broadcasting your your cold staking transaction ... please wait.${NONE}"

curl -sX POST "http://localhost:$apiport/api/Wallet/send-transaction" -H  "accept: application/json" -H  "Content-Type: application/json-patch+json" -d "{\"hex\":\"$ColdStakingTX\"}" &>> ${logfile}

echo -e "${GREEN}Done.${NONE}"
echo
echo -e "${RED}Here's your cold wallet details. These are you're responsibility trustaking.com has no way to recover this information - keep this information safe offline:${NONE}"
echo
echo -e "${RED}Name      	:${NONE}" $ColdWalletName
echo -e "${RED}Password  	:${NONE}" $ColdWalletPassword
echo -e "${RED}Passphrase	:${NONE}" $ColdWalletPassphrase
echo -e "${RED}Mnemonic  	:${NONE}" $ColdWalletSecretWords
echo -e "${RED}Funding address :${NONE}" $ColdWalletInitialFundingAddress
echo -e "${RED}Cold address    :${NONE}" $ColdWalletColdStakingColdAddress
echo -e "${RED}Hot address     :${NONE}" $HotWalletColdStakingHotAddress
echo -e "${RED}Amount          :${NONE}" $ColdStakingAmount
#echo -e "${RED}Hex or error    :${NONE}" $ColdStakingTX


