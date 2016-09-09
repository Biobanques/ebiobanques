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
        $this->assertNotNull(ICDComparator::getGroup("A10"),"A10 must be a valaid code");
        $exceptionRaised=false;
        try{
            //must throw an eception because ICD invalid
        ICDComparator::getGroup("010","010 is an incorect code");
        }catch(Exception $e){
            $exceptionRaised=true;
        }
        $this->assertTrue($exceptionRaised);
        //ICD not founded example = K99 inexisting code
        $this->assertNull(ICDComparator::getGroup("K99"),"K99 is an inexisting code");
        //ICD existing C01
        $this->assertEquals(ICDComparator::getGroup("C01"), "C00-D48","C01 must be in the group C00-D48");
    
        $this->assertEquals(ICDComparator::getGroup("B01"), "A00-B99","B01 must be in the group A00-B99");
    
        }


    public function testisICDCode(){
        $this->assertTrue(ICDComparator::isICDCode("A01"),"A01 must be a valid code");
        $this->assertFalse(ICDComparator::isICDCode("cat"),"cat is not a valid code");
        $this->assertFalse(ICDComparator::isICDCode("C000"),"C000 is not a valid code!");
        $this->assertTrue(ICDComparator::isICDCode("B01"),"B01 is  a valid code!");
    }
}
