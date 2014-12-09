#!/bin/bash

####################################################################
# script to deploy the webapp to a distant server via ssh and rsync.
# @author  nicolas malservet
# @version 1.0 
####################################################################

MUSER="root"
MURL="de519.ispfr.net"
MPATH="/var/www/vhosts/de519.ispfr.net/httpdocs/demo-ebiobanques/"

echo "updating pre-index page"
scp ../index.html root@de519.ispfr.net:/var/www/vhosts/de519.ispfr.net/httpdocs/demo-ebiobanques/index.html
