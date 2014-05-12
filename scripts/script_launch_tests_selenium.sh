#!/bin/bash
MSERVER="http://localhost/ebiobanques"
MFOLDERDEST="/home/nicolas/Bureau"
MFOLDERSRC="/data/developpement/workspace_zend_eclipse_php/ebiobanques/tests_selenium/dev/"
MSELENIUMSERVER="/data/developpement/selenium-server-standalone-2.35.0.jar"

echo "rebuild db local"
./script_reconstruct_db_local.sh
echo "Tests en local"
java -jar $MSELENIUMSERVER -port 4545  -htmlSuite *chrome $MSERVER $MFOLDERSRC"gerantTestSuiteSelenium.html" $MFOLDERDEST"/GerantResults.html"
echo "rebuild db local"
./script_reconstruct_db_local.sh
java -jar $MSELENIUMSERVER -port 4545  -htmlSuite *chrome $MSERVER $MFOLDERSRC"membreTestSuiteSelenium.html" $MFOLDERDEST"/MembreResults.html"
echo "rebuild db local"
./script_reconstruct_db_local.sh
java -jar $MSELENIUMSERVER -port 4545  -htmlSuite *chrome $MSERVER $MFOLDERSRC"adminTestSuiteSelenium.html" $MFOLDERDEST"/AdminResults.html"
echo "rebuild db local"
./script_reconstruct_db_local.sh
java -jar $MSELENIUMSERVER -port 4545  -htmlSuite *chrome $MSERVER $MFOLDERSRC"/inscriptionGerantTestSuiteSelenium.html" $MFOLDERDEST"/InscriptionGerantResults.html"
