#!/bin/bash

####################################################################
# script to rebuild locally the application with folders and rights
# do not use in production mode for security reasons
# to use under Unix systems
# @author  nicolas malservet
# @version 1.0 
####################################################################
echo "create folder for temp files"


mkdir ../ebiobanques/protected/runtime/tmp_files
chmod ugo+wx ../ebiobanques/protected/runtime/tmp_files
