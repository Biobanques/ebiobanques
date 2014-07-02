<?php

class SeleniumWebTestCase extends PHPUnit_Extensions_SeleniumTestCase
{
    protected $coverageScriptUrl = 'http://localhost/phpunit/phpunit_coverage.php';

    protected function setUp() {
        parent::setUp();
    }

}