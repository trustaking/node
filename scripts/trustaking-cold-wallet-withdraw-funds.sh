#!/bin/bash
NONE='\033[00m'
RED='\033[01;31m'
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
logfile="/tmp/log_${date_stamp}.log"
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
echo -e "${RED}${BOLD}###################################################################${NONE}"
echo -e "${RED}${BOLD}########### TRUSTAKING.COM LOCAL WALLET - WITHDRAW FUNDS ##########${NONE}"
echo -e "${RED}${BOLD}###################################################################${NONE}"
echo
echo -e "Use this to withdraw funds from trustaking.com"
echo 
read -p "Name (default=MyColdWallet): " response
if [[ "$response" != "" ]] ; then 
   ColdWalletName="$response" 
fi
read -p "Password: " ColdWalletPassword
echo

##### Where do you want to return the funds to? ######

read -p "What address do you want to withdraw to?" ReturnAddress
echo
read -p "Confirm how many coins you wish to withdraw from Cold Staking :" ColdStakingAmount
echo

##### Prepare the cold staking cancel tx ######

echo -e "* Preparing to withdraw from your cold staking and return funds ... please wait."

ColdStakingTX=$(curl -sX POST "http://localhost:$apiport/api/ColdStaking/cold-staking-withdrawal" -H  "accept: application/json" -H  "Content-Type: application/json-patch+json" -d "{  \"receivingAddress\": \"$ReturnAddress\",  \"walletName\": \"$ColdWalletName\",  \"walletPassword\": \"$ColdWalletPassword\",  \"amount\": \"$ColdStakingAmount\",  \"fees\": \"0.0002\"}")

ColdStakingTX=${ColdStakingTX:19:512}

echo -e "${GREEN}Done.${NONE}"
echo

##### Transmit the cold staking tx ######

echo -e "*Broadcasting your your cold staking withdrawal transaction ... please wait."

curl -sX POST "http://localhost:$apiport/api/Wallet/send-transaction" -H  "accept: application/json" -H  "Content-Type: application/json-patch+json" -d "{\"hex\":\"$ColdStakingTX\"}" &>> ${logfile}

echo -e "${GREEN}Done.${NONE}"
echo
echo -e "Here's all the details of the withdrawal:"
echo
echo -e "Return address :" $ReturnAddress
echo -e "Amount         :" $ColdStakingAmount
echo -e "Hex or error   :" $ColdStakingTX
echo
read -p "Press a key to finish." response