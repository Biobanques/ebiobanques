#!/bin/bash

####################################################################
# script to rebuild locally the application with folders and rights
# do not use in production mode for security reasons
# to use under Unix systems
# @author  nicolas malservet
# @version 1.0 
####################################################################
echo "set rights and folders"
chmod ugo+wx ../ebiobanques/protected/runtime
mkdir ../ebiobanques/assets
chmod ugo+wx ../ebiobanques/assets