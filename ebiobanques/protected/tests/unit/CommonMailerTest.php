<?php

/**
 * unit test class to test CommonMailer
 * @author nmalservet
 *
 */
class CommonMailerTest extends PHPUnit_Framework_TestCase
{

    /**
     * testing method to check if sendMail is correct. 
     */
    public function testSendMail() {
        $to="contact@ebiobanques.fr";
        $subject="test send mail from unit test";
        $body="Have a nice day!";
        $res=CommonMailer::sendMail($to, $subject, $body);
        $this->assertTrue($res); 
    }
}
?>
