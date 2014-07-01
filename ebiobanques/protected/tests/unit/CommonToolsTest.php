<?php

/**
 * unit test class to test CommonTools
 * @author nmalservet
 *
 */
class CommonToolsTest extends PHPUnit_Framework_TestCase
{
   
        /**
     * testing method to check if the dev mode detector is ok
     */
    public function testIsInDevMode() {
        $this->assertTrue(CommonTools::isInDevMode()); 
    }
}
?>