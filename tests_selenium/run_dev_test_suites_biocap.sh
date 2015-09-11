#!/bin/bash

#this file run the tests suites using selenium RC with the localhost url
# options de choix de navigateur : *safari, *googlechrome, *firefox
# selenium RC need an absolute path to the files that will be injected 
# in 2014 , google chrome will be the browser most used so we recommand to use it for automated test if selenium grid is not used 
#rebuild db before and aftere tests

#script parameters to modified.
EXTERNAL_DATA_PATH="/home/matthieu/Documents/inserm/dumps/biocap/"
CURRENTPATH=$(pwd)
#file to store localhost connection parameters like : --username ebiobanques --password ebiobanques --authenticationDatabase admin
MONGO_CONNECTION_PARAMETERS=$EXTERNAL_DATA_PATH"localhost_mongo_parameters.txt"
#dump file
#DUMP_FILE=$EXTERNAL_DATA_PATH"dumps/dump_interopdb_15-04-23/interop/"
#host and port
MONGO_HOST="--host localhost --port 32020"
#database name
MONGO_DB="biocap"

MONGO_PARAMETERS=$(awk '1' $MONGO_CONNECTION_PARAMETERS)
echo "launch tests suite with selenium rc"
echo "current path is:"$CURRENTPATH

#echo "rebuild db local ( restore from a dump)"
#echo "drop database"
#mongo $MONGO_HOST  $MONGO_PARAMETERS $MONGO_DB --eval "db.dropDatabase()"
#echo "restore a db in prod into new db"
#mongorestore $MONGO_HOST  $MONGO_PARAMETERS --db $MONGO_DB $DUMP_FILE

#echo "Save - Fin de restauration"
echo "add data for selenium tests"
mongo $MONGO_HOST  $MONGO_PARAMETERS $MONGO_DB $CURRENTPATH"/biocap/scripts/initUsers.js"

java -jar selenium-server-standalone-2.44.0.jar -log selenium_vsc.log -htmlSuite "*googlechrome" "http://localhost/ebiobanques" $CURRENTPATH"/biocap/testsSuites/biocapTestSuite.html" $CURRENTPATH"/results_simpleBiocapTests.html"


echo "END SCRIPT"