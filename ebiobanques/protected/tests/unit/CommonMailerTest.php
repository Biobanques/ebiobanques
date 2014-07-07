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
        $this->assertTrue(CommonMailer::sendMail($to, $subject, $body));
    }

    /**
     * testing method to check if sendMail is correct.
     */
    public function testSendMailRecoverPassword() {
        $criteria = new EMongoCriteria;
        $criteria->login = "demo";
        $user = User::model()->find($criteria);
        ;
        $this->assertTrue(CommonMailer::sendMailRecoverPassword($user));
    }

}
?>
