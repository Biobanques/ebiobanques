<?php

/**
 * unit test class to test "Sample"
 * @author nmalservet
 *
 */
class SampleTest extends PHPUnit_Framework_TestCase
{

    public function testgetShortNotes() {
        $sample = Sample::model();
        $this->assertNotNull($sample); //$sample=Sample::model()->search());
    }

}
?>