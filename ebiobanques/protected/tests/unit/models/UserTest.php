<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserTest
 *
 * @author matthieu
 */
class UserTest extends PHPUnit_Framework_TestCase
{

    public function testBeforeValidate() {
        $user = new User();
        $user->_id = new MongoId();
        $user->prenom = 'prenomTest';
        $user->nom = 'nomTest';
        $user->login = 'loginTest';
        $user->password = 'pawdTest';
        $user->email = 'emailTest@test.mail';
        $user->telephone = '0101020201';
        $user->gsm = '0606070706';
        $user->profil = '1';
        $user->inactif = '0';
        $user->biobank_id = null;

        $this->assertNull($user->inscription_date);
        $user->validate();
        $dateInserted = $user->inscription_date;
        $this->assertNotNull($dateInserted);
        //Check if method override existing inscription date
        $user->setIsNewRecord(false);
        sleep(3);
        $user->validate();
        $this->assertEquals($dateInserted, $user->inscription_date);
        $user->inscription_date = null;
        $user->validate();
        $this->assertNotNull($user->inscription_date);
    }

}