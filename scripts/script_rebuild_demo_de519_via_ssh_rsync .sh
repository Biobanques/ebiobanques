#!/bin/bash

####################################################################
# script to deploy the webapp to a distant server via ssh and rsync.
# @author  nicolas malservet
# @version 1.0 
####################################################################

MUSER="root"
MURL="de519.ispfr.net"
MPATH="/var/www/vhosts/de519.ispfr.net/httpdocs/demo-ebiobanques"

echo "delete local cache files"
rm -Rf ./ebiobanques/assets/*
echo "set the revision number of the current last commit in the master branch with git"
git rev-parse --short master > ./ebiobanques/revision_number.php
echo "sync sources files"
rsync -avz -e 'ssh'  ./ebiobanques/ $MUSER@$MURL:$MPATH
