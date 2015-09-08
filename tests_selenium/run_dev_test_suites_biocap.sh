#!/bin/bash

#this file run the tests suites using selenium RC with the localhost url
# options de choix de navigateur : *safari, *googlechrome, *firefox
# selenium RC need an absolute path to the files that will be injected 
# in 2014 , google chrome will be the browser most used so we recommand to use it for automated test if selenium grid is not used 
#rebuild db before and aftere tests

#script parameters to modified.

CURRENTPATH=$(pwd)


java -jar selenium-server-standalone-2.44.0.jar -log selenium_vsc.log -htmlSuite "*googlechrome" "http://localhost/ebiobanques" $CURRENTPATH"/biocap/testsSuites/simpleUser" $CURRENTPATH"/results_simpleUser.html"

java -jar selenium-server-standalone-2.44.0.jar -log selenium_adm.log -htmlSuite "*googlechrome" "http://localhost/ebiobanques" $CURRENTPATH"/dev/testsSuites/adminUser.html" $CURRENTPATH"/results_adminUser.html"


echo "END SCRIPT"