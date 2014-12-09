#!/bin/bash

####################################################################
# script to deploy the webapp to a distant server via ssh and rsync.
# @author  nicolas malservet
# @version 1.0 
####################################################################

MUSER="root"
MURL="de519.ispfr.net"
MPATH="/var/www/vhosts/de519.ispfr.net/httpdocs/demo-ebiobanques/ebiobanques"


rsync -avz -e 'ssh'  ./ebiobanques/CommonTools.php $MUSER@$MURL:$MPATH
