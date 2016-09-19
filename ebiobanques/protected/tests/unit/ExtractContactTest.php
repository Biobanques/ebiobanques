<?php

/**
 * unit test class to test "ExtractContactCommand"
 * @author saakki
 *
 */
class ExtractContactCommandTest extends PHPUnit_Framework_TestCase {

    function testExtractContact() {

        $biobankesperada = new Biobank();
        $biobank = new Biobank();
        // $contact = new contact();
        
        $biobankesperada = Biobank::model()->findByPk(new MongoId("552fe5f20175447b308b4683"));
        if ($biobankesperada != null) {
            $biobank = ExtractContactCommand::extractContact($biobankesperada);
            $this->assertEquals("géraldine", $biobank->contact_resp->firstName);
            $this->assertEquals("GALLOT", $biobank->contact_resp->lastName);
            $this->assertEquals("geraldine.gallot@chu-nantes.fr", $biobank->contact_resp->email);
            $this->assertEquals("+33253482204", $biobank->contact_resp->direct_phone);
        }
    }

}

?>
