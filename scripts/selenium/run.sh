#!/bin/bash
MSERVER="http://localhost/ebiobanques"
MFOLDERDEST="/home/matthieu/NetBeansProjects/ebiobanques.fr/scripts/selenium/results/"
MFOLDERSRC="/home/matthieu/NetBeansProjects/ebiobanques.fr/tests_selenium/dev/"
MSELENIUMSERVER="/home/matthieu/Documents/test/selenium-server-standalone-2.41.0.jar"


echo "rebuild db local"
mongo localhost:32020/interop ./db_init.js
echo "Tests en local"
java -jar $MSELENIUMSERVER -port 4545  -htmlSuite *firefox $MSERVER $MFOLDERSRC"suite.html" $MFOLDERDEST"/suiteResult.html"
echo "reset db local"
mongo localhost:32020/interop ./db_reset.js