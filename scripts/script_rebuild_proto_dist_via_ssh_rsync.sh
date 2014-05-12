#!/bin/bash

####################################################################
# script to deploy the webapp to a distant server via ssh and rsync.
# @author  nicolas malservet
# @version 1.0 
####################################################################

MUSER="root"
MURL="my_server_address.com"
MPATH="/var/www/ebiobanques/"
MDIR="/data/current_project_dir/ebiobanques/

echo "delete local cache files"
rm -Rf ./ebiobanques/assets/*
echo "sync sources files"
rsync -avz -e 'ssh'  $MDIR $MUSER@$MURL:$MPATH
