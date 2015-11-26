#!/bin/bash

####################################################################
# script to rebuild locally the application with folders and rights
# do not use in production mode for security reasons
# to use under Unix systems
# @author  nicolas malservet
# @updater matthieu penicaud
# @version 1.1 
####################################################################
echo "set rights and folders"
chmod ugo+wx ../ebiobanques/protected/runtime
mkdir ../ebiobanques/protected/runtime/tmp_files
chmod ugo+wx ../ebiobanques/protected/runtime/tmp_files
mkdir ../ebiobanques/assets
chmod ugo+wx ../ebiobanques/assets