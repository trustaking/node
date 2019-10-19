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
apiver=""
date_stamp="$(date +%y-%m-%d-%s)"
logfile="/tmp/log_$date_stamp_output.log"
ColdWalletName=""
ColdWalletPassword=""
ColdWalletColdStakingHotAddress=""
ColdWalletColdStakingColdAddress=""
ColdStakingAmount=""
ColdStakingTX=""
if [[ "${apiver}"="&Segwit=true" ]] ; then
    SegwitSetting=",  \"segwitChangeAddress\": true"
fi 


######## Get some information from the user about the wallet ############
clear
echo -e "${RED}${BOLD}##############################################################${NONE}"
echo -e "${RED}${BOLD}########### TRUSTAKING.COM LOCAL WALLET - ADD FUNDS ##########${NONE}"
echo -e "${RED}${BOLD}##############################################################${NONE}"
echo
echo -e "${BOLD}Use this to add funds to your existing cold wallet.${NONE}"
echo 
read -p "Your wallet name  : " ColdWalletName
read -p "Password: " ColdWalletPassword
echo 

##### Get the Cold Wallet - Cold Address ######
ColdWalletColdStakingColdAddress=$(curl -sX GET "http://localhost:$apiport/api/ColdStaking/cold-staking-address?WalletName=$ColdWalletName&IsColdWalletAddress=true${apiver}" -H  "accept: application/json")
ColdWalletColdStakingColdAddress=$(echo $ColdWalletColdStakingColdAddress | cut -d \" -f4)

##### Enter the Staking Address from Trustaking.com ######

read -p "Enter your hot wallet address from trustaking.com: " HotWalletColdStakingHotAddress
echo
read -p "Confirm how many coins you wish to start staking at trustaking.com: " ColdStakingAmount
echo

##### Prepare the cold staking tx ######

echo -e "${RED}* Preparing your cold staking transaction ... please wait.${NONE}"
ColdStakingTX=$(curl -sX POST "http://localhost:$apiport/api/ColdStaking/setup-cold-staking" -H  "accept: application/json" -H  "Content-Type: application/json-patch+json" -d "{  \"coldWalletAddress\": \"$ColdWalletColdStakingColdAddress\",  \"hotWalletAddress\": \"$HotWalletColdStakingHotAddress\",  \"walletName\": \"$ColdWalletName\",  \"walletPassword\": \"$ColdWalletPassword\",  \"walletAccount\": \"account 0\",  \"amount\": \"$ColdStakingAmount\",  \"fees\": \"0.0002\"${SegwitSetting}")
ColdStakingTX=$(echo $ColdStakingTX | cut -d \" -f4)

##### Transmit the cold staking tx ######
curl -sX POST "http://localhost:$apiport/api/Wallet/send-transaction" -H  "accept: application/json" -H  "Content-Type: application/json-patch+json" -d "{\"hex\":\"$ColdStakingTX\"}" &>> ${logfile}

echo -e "${GREEN}Done.${NONE}"
echo
echo -e "${RED}Here's your cold wallet details. These are you're responsibility trustaking.com has no way to recover this information - keep this information safe offline:${NONE}"
echo
echo -e "${RED}Name      	      :${NONE}" $ColdWalletName
echo -e "${RED}Cold address       :${NONE}" $ColdWalletColdStakingColdAddress
echo -e "${RED}Trustaking address :${NONE}" $HotWalletColdStakingHotAddress
echo -e "${RED}Amount             :${NONE}" $ColdStakingAmount
#echo -e "${RED}Hex or error    :${NONE}" $ColdStakingTX
echo
read -p "Press a key to finish." response

