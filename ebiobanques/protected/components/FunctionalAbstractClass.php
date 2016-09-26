<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**

 *
 * @author matthieu
 */
abstract class FunctionalAbstractClass extends PHPUnit_Framework_TestCase
{
    /**
     * @var RemoteWebDriver
     */
    protected static $webDriver;
    protected $baseUrl;

    /**
     * Launch selenium server in local functional testing
     * Init driver for functional testing, depending of selected browser
     */
    public static function setUpBeforeClass() {

        parent::setUpBeforeClass();
        echo "\n" . 'Début des tests fonctionnels' . "\n"
        . "Navigateur utilisé : " . CommonProperties::$TESTBROWSER . "\n";
        if (CommonProperties::$LAUNCHSELENIUM) {
            chdir(Yii::app()->basePath . '/datas/apps');
            shell_exec('java -Dwebdriver.chrome.driver=chromedriver -jar selenium-server-standalone-2.53.1.jar >/dev/null 2>/dev/null & sleep 1 &');
        }

        echo "\n" . 'Création du webdriver' . "\n";
        $host = 'http://localhost:4444/wd/hub';

        try {

            switch (CommonProperties::$TESTBROWSER) {
                case 'chrome';
                    $desiredCapabilities = DesiredCapabilities::chrome();
                    break;
                case 'firefox';
                    $desiredCapabilities = DesiredCapabilities::firefox();
                    break;
                default: $desiredCapabilities = DesiredCapabilities::chrome();
            }
            FunctionalAbstractClass::$webDriver = RemoteWebDriver::create($host, $desiredCapabilities);
            FunctionalAbstractClass::$webDriver->manage()->timeouts()->implicitlyWait(2);
            FunctionalAbstractClass::$webDriver->manage()->timeouts()->pageLoadTimeout(3);
        } catch (Exception $ex) {
            echo 'Setting of webdriver fails : ' . $ex->getMessage() . $ex->getTraceAsString();
        }
    }

    public function setUp() {
        parent::setUp();
        $this->baseUrl = Yii::app()->createAbsoluteUrl("");
    }

    public static function tearDownAfterClass() {
        FunctionalAbstractClass::$webDriver->quit();
        echo "\n" . 'Arret de selenium' . "\n";
        if (CommonProperties::$LAUNCHSELENIUM)
            shell_exec('fuser -k -n tcp 4444');
        parent::tearDownAfterClass();
    }

    public function takeScreenShot($label = null) {
        $path = Yii::app()->basePath . "/tests/report/screenshots/$label/";

        if (!is_dir($path)) {
            if (mkdir($path, 0777, true)) {
                echo $path . " created";
            } else {
                echo $path . " NOT created";
            }
        } else {
            echo $path . " already exists";
        }

        if (is_dir($path)) {
            FunctionalAbstractClass::$webDriver->takeScreenshot($path . time());
        } else
            echo 'Can\'t take screenshot : ' . $path . ' is not an existing folder';
    }

}