<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * FIXME refactor this test class. clean environnement before and after test 
 */
class UploadedFileControllerTest extends PHPUnit_Framework_TestCase
{

    public function testEmpty(){
        $this->assertNull(null);
    }
    /*public static function setUpBeforeClass() {
        /**
         * Create Biobank demo if not exists
         */
       /* if (Biobank::model()->findByPk('demo') == null) {
            $biobankDemo = new Biobank();
            $biobankDemo->_id = 'demoId'.date("Ymd_Hi");
            $biobankDemo->identifier = 'BB-'.date("YmdHi");
            $biobankDemo->name = '00-Biobanque demo'.date("Ymd_Hi");
            $biobankDemo->collection_name = 'collection name demo';
            $biobankDemo->collection_id = 'collection id demo';
            $biobankDemo->diagnosis_available = 'diagnostic divers';
            $adressDemo = new Address();
            $adressDemo->city = 'DemoVille';
            $adressDemo->street = 'DemoRue';
            $adressDemo->zip = '00999';
            $adressDemo->country = 'fr';
            $biobankDemo->address = $adressDemo;
            if (!$biobankDemo->save())
                throw (new Exception("init failed : " . print_r($biobankDemo->errors, true)));
        }

        /**
         * set user as admin
         */
       /* Yii::app()->user->setState('profil', '1');
        parent::setUpBeforeClass();
    }
*/
  /*  public function testUploadEchFile() {

        $_SESSION['biobank_id'] = 'demo';
        $this->assertNull(UploadedFileController::uploadEchFile(null));
        $file = array();
        $file['tmp_name'] = 'temp_name.test';
        $file['name'] = 'name.test';
        $file['size'] = 150000000;
        $this->assertNull(UploadedFileController::uploadEchFile($file));
        $file['size'] = 7500000;
        $this->assertNull(UploadedFileController::uploadEchFile($file));
        $file['name'] = 'name.xls';
        $this->assertNull(UploadedFileController::uploadEchFile($file));
    }*/

}