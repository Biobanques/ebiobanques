<?php

//class SeleniumWebTestCase extends PHPUnit_Extensions_SeleniumTestCase
class SeleniumWebTestCase extends CWebTestCase
{
    protected $coverageScriptUrl = 'http://localhost/phpunit/phpunit_coverage.php';
    public $fixtures = array(
        'user' => 'User',
    );

    protected function setUp() {
        parent::setUp();
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://localhost/demo-ebiobanques/index-test.php");
    }

}