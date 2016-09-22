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
        $to = "contact@ebiobanques.fr";
        $subject = "test send mail from unit test";
        $body = "Have a nice day!";
        //Fixme : activate after refactoring for continuous build
        // $this->assertTrue(CommonMailer::sendMail($to, $subject, $body));
    }

    /**
     * testing method to check if sendMail is correct.
     */
    public function testSendMailRecoverPassword() {
        $criteria = new EMongoCriteria;
        $criteria->login = "mpenicaud";
        $user = User::model()->find($criteria);
        //Fixme : activate after refactoring for continuous build
        //$this->assertTrue(CommonMailer::sendMailRecoverPassword($user));
    }

    /**
     * testing method to check if sendMail is correct.
     */
    public function testDirectSend() {
        $subject = "This is a test mail subject";
        $body = "This is a test mail body";
        $emailTo = CommonProperties::$ADMIN_EMAIL;
        //FIXME we can't send mail with continuous integration or create a whole environment...
        //$this->assertFalse(CommonMailer::directSend(null, $body, $emailTo, null, null, false));
//  $this->assertTrue(CommonMailer::directSend($subject, $body, $emailTo, null, null, false));
    }

}
?>
