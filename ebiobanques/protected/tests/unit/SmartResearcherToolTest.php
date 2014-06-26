<?php

/**
 * unit test class to test SmartResearcherTool
 * @author nmalservet
 *
 */
class SmartResearcherToolTest extends PHPUnit_Framework_TestCase
{

    /**
     * testing method to check if search 
     */
    public function testSearch() {
        $keywords="male";
        $model=SmartResearcherTool::search($keywords);
        $this->assertNotNull($model);
        $this->assertEquals("M",$model->gender);
    }
}
?>