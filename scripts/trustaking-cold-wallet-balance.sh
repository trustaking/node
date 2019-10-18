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
apiport=38221
date_stamp="$(date +%y-%m-%d-%s)"
ColdWalletName=""
logfile="/tmp/balance.log"

######## Get some information from the user about the wallet ############
clear
echo -e "${RED}${BOLD}###################################################################${NONE}"
echo -e "${RED}${BOLD}########### TRUSTAKING.COM LOCAL WALLET - GET BALANCE #############${NONE}"
echo -e "${RED}${BOLD}###################################################################${NONE}"
echo
echo -e "Use this script to get your current balance"
echo 
read -p "Wallet Name: " ColdWalletName
echo

##### Grab the balance ######

ColdStakingBal=$(curl -sX GET "http://localhost:$apiport/api/Wallet/balance?WalletName=$ColdWalletName&AccountName=coldStakingColdAddresses" -H  "accept: application/json")
#ConfirmedBalance=${ColdStakingBal:134:12}
ConfirmedBalance=$(echo $ColdStakingBal | cut -d \" -f4)

ConfirmedBalance=$(echo "scale=8; $ConfirmedBalance/100000000" | bc)
echo -e "Here is the current confirmed balance at ${date_stamp} for wallet $ColdWalletName: "${ConfirmedBalance} >> $logfile
echo -e "Here is the current confirmed balance at ${date_stamp} for wallet $ColdWalletName: ${GREEN}"${ConfirmedBalance}
echo -e "${NONE}"
echo
read -p "Press a key to finish." response
