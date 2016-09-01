<?php


/**
 * Test class for ICD comparator
 *
 * @author nicolas malservet
 */
class ICDComparatorTest extends PHPUnit_Framework_TestCase
{

    public function testgetGroup() {
       //test group
        $this->assertNotNull(ICDComparator::getGroup("A10"));
        $exceptionRaised=false;
        try{
            //must throw an eception because ICD invalid
        ICDComparator::getGroup("010");
        }catch(Exception $e){
            $exceptionRaised=true;
        }
        $this->assertTrue($exceptionRaised);
        //ICD not founded example = K99 inexisting code
        $this->assertNull("K99");
        //ICD existing C01
        $this->assertEquals(ICDComparator::getGroup("C01"), "C00_D48");
    }


}
