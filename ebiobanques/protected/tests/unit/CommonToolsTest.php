<?php

/**
 * unit test class to test CommonTools
 * @author nmalservet
 *
 */
class CommonToolsTest extends PHPUnit_Framework_TestCase {

    /**
     * testing method to check if the dev mode detector is ok
     */
    public function testIsInDevMode() {
        $this->assertTrue(CommonTools::isInDevMode());
    }

    /**
     * test the method to translatea mysql date to a short date fr dd/mm/yyyy
     */
    public function testToSHortDateFR() {
        $madate = "2000-12-27 23:45:00";
        $this->assertEquals("27/12/2000", CommonTools::toShortDateFR($madate));
    }

    /**
     * test the method to translate a mysql date to a short date en jj/mm/aa
     */
    public function testToSHortDateEN() {
        $madate = "2000-12-27 23:45:00";
        $this->assertEquals("2000-12-27", CommonTools::toShortDateEN($madate));
    }
    /**
     * test the method to translate a mysql date to a long date en yyyy-mm-dd hh:mm
     */
    public function testToDateEN() {
        $madate = "2000-12-27 23:45:00";
        $this->assertEquals("2000-12-27 23:45", CommonTools::toDateEN($madate));
    }
    /**
     * test the method to translate a mysql date to a long date fr dd/mm/yyyy hh:mm
     */
    public function testToDateFR() {
        $madate = "2000-12-27 23:45:00";
        $this->assertEquals("27/12/2000 23:45", CommonTools::toDateFR($madate));
    }
      /**
     * test the method to translate a mysql date to another date format
     */
    public function testToDate() {
        $madate = "2000-12-27 23:45:00";
        $this->assertEquals("27/12/2000", CommonTools::toDate("d/m/Y",$madate));
    }
}

?>
