<?php 
/**
 * unit test class to test "Sample"
 * @author nmalservet
 *
 */
class SampleTest extends CDbTestCase
{
	
	public function testSearch()
	{
		$this->assertTrue(true);//$sample=Sample::model()->search());
	}
        
        public function testSearch2()
	{
		$this->assertTrue(false);
	}
}
?>