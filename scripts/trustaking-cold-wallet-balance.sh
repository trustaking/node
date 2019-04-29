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
ColdWalletName="cold-wallet"
ColdWalletSecretWords=""
ColdWalletPassword=""
ColdWalletPassphrase=""
ColdWalletInitialFundingAddress=""
ColdWalletColdStakingHotAddress=""
ColdWalletColdStakingColdAddress=""
ColdStakingAmount=""
ColdStakingTX=""
ColdStakingBal=""

######## Get some information from the user about the wallet ############
clear
echo -e "${RED}${BOLD}###################################################################${NONE}"
echo -e "${RED}${BOLD}########### TRUSTAKING.COM LOCAL WALLET - GET BALANCE #############${NONE}"
echo -e "${RED}${BOLD}###################################################################${NONE}"
echo
echo -e "Use this script to get your current balance"
echo 
read -p "Name (default=cold-wallet): " response
if [[ "$response" != "" ]] ; then 
   ColdWalletName="$response" 
fi
echo

##### Grab the balance ######

ColdStakingBal=$(curl -sX GET "http://localhost:$apiport/api/Wallet/maxbalance?WalletName=$ColdWalletName&AccountName=coldStakingColdAddresses&FeeType=medium" -H  "accept: application/json")
ColdStakingBal=${ColdStakingBal:22:12}
ColdStakingBalance=$(echo "scale=8; $ColdStakingBal/100000000" | bc)

echo -e "Here is the current balance for wallet $ColdWalletName: ${GREEN}"$ColdStakingBalance
echo -e "${NONE}"
echo