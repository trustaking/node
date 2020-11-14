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
fork=
COINAPIPORT=
date_stamp="$(date +%y-%m-%d-%s)"
logfile="/tmp/log_$date_stamp_output.log"
RPCUSER=`cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1`
RPCPASS=`cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1`
HotWalletName="hot"
HotWalletSecretWords=""
HotWalletPassword=""
HotWalletPassphrase=""
HotWalletInitialFundingAddress=""
HotWalletColdStakingHotAddress=""
ColdWalletColdStakingColdAddress=""
ColdStakingAmount=""
ColdStakingTX=""

######## Get some information from the user about the wallet ############
clear
echo -e "${RED}${BOLD}#############################################################################${NONE}"
echo -e "${RED}${BOLD}##################### REMOTE WALLET - COLD STAKING SETUP ####################${NONE}"
echo -e "${RED}${BOLD}#############################################################################${NONE}"
echo
echo -e "Please enter some details about your Hot wallet (that will used for staking)"
echo 
read -p "Name (default=hot):" response
if [[ "$response" != "" ]] ; then 
   HotWalletName="$response" 
fi
read -p "Password:" HotWalletPassword
read -p "Passphrase:" HotWalletPassphrase
echo 

##### Setup the hot wallet ########

echo -e "*Creating your Hot wallet ... please wait."

### grab a 12 word mneumonic

HotWalletSecretWords=$(sed -e 's/^"//' -e 's/"$//' <<<$(curl -sX GET "http://localhost:$COINAPIPORT/api/Wallet/mnemonic?language=english&wordCount=12" -H "accept: application/json")) 
curl -sX POST "http://localhost:$COINAPIPORT/api/Wallet/create" -H  "accept: application/json" -H  "Content-Type: application/json-patch+json" -d "{  \"mnemonic\": \"$HotWalletSecretWords\",  \"password\": \"$HotWalletPassword\",  \"passphrase\": \"$HotWalletPassphrase\",  \"name\": \"$HotWalletName\"}" &>> ${logfile}

echo -e "${GREEN}Done.${NONE}"
echo

##### Convert the hot wallet to a cold staking wallet ######

echo -e "* Preparing your Hot wallet for cold staking   ... please wait."
curl -sX POST "http://localhost:$COINAPIPORT/api/ColdStaking/cold-staking-account" -H  "accept: application/json" -H  "Content-Type: application/json-patch+json" -d "{  \"walletName\": \"$HotWalletName\",  \"walletPassword\": \"$HotWalletPassword\",  \"isColdWalletAccount\": false}" &>> ${logfile}

echo -e "${GREEN}Done.${NONE}"
echo

##### Get the Hot Wallet - Hot Address ######

echo -e "* Fetching your Hot wallet details for cold staking   ... please wait."

HotWalletColdStakingHotAddress=$(curl -sX GET "http://localhost:$COINAPIPORT/api/ColdStaking/cold-staking-address?WalletName=$HotWalletName&IsColdWalletAddress=false" -H  "accept: application/json")
HotWalletColdStakingHotAddress=${HotWalletColdStakingHotAddress:12:34}

echo -e "${GREEN}Done.${NONE}"
echo

##### Start staking on the Hot Wallet ######

echo -e "* Preparing to start cold staking on your Hot wallet   ... please wait."

curl -sX POST "http://localhost:$COINAPIPORT/api/Staking/startstaking" -H  "accept: application/json" -H  "Content-Type: application/json-patch+json" -d "{  \"password\": \"$HotWalletPassword\",  \"name\": \"$HotWalletName\"}" &>> ${logfile}

curl -X GET "http://localhost:$COINAPIPORT/api/Staking/getstakinginfo" -H  "accept: application/json" &>> ${logfile}

echo -e "${GREEN}Done.${NONE}"
echo
echo -e "Here's all the Hot wallet details - keep this information safe offline:"
echo
echo -e "Name      	:" $HotWalletName
echo -e "Password  	:" $HotWalletPassword
echo -e "Passphrase	:" $HotWalletPassphrase
echo -e "Mnemonic  	:" $HotWalletSecretWords
echo -e "Hot address     :${RED}" $HotWalletColdStakingHotAddress
echo -e "${NONE}"

[ ! -d /var/secure ] && mkdir -p /var/secure 
cat > /var/secure/cred-${fork}.sh << EOF
STAKINGNAME=${HotWalletName}
STAKINGPASSWORD=${HotWalletPassword}
RPCUSER=${RPCUSER}
RPCPASS=${RPCPASS}
EOF
chmod 0644 /var/secure/cred-${fork}.sh