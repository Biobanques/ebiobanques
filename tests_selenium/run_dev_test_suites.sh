#!/bin/bash

#this file run the tests suites using selenium RC with the localhost url
# options de choix de navigateur : *safari, *googlechrome, *firefox
# selenium RC need an absolute path to the files that will be injected 
# in 2014 , google chrome will be the browser most used so we recommand to use it for automated test if selenium grid is not used 
#rebuild db before and aftere tests

echo "launch tests suite with selenium rc"
echo "current path is:"$(pwd)
CURRENTPATH=$(pwd)

echo "rebuild db local"
mongo localhost:32020/interop ./db_init.js

java -jar selenium-server-standalone-2.44.0.jar -htmlSuite "*googlechrome" "http://localhost/ebiobanques" $CURRENTPATH"/dev/testsSuites/visiteSiteSansConnexionTestSuite.html" $CURRENTPATH"/results.html"

echo "reset db local"
mongo localhost:32020/interop ./db_reset.js