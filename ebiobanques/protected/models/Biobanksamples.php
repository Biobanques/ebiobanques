<?php

/**
 * This is the model class for table "Biobank".
 *
 * The followings are the available columns in table 'Biobank':
 */
class Biobanksamples extends LoggableActiveRecord
{
    /*
     * Champs obligatoires
     */
    public $_id;
    public $origin;
    public $countmen;
    public $countwomen;
    public $countnot;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Biobank the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /**
     * @return string the associated database table name
     */
    public function getCollectionName() {
        return 'biobanksamples4';
    }
    public function attributeLabels() {

        return array(
            'origine' => 'Origine de l\'échantillon',
            'countwomen' => 'Nb d\'échantillons masculin',
            'countmen' => 'Nb d\'échantillons feminin',
            'countnot' => 'Nb d\'échantillons non renseignés',
            'count' => 'Nb d\'échantillon'
        );
    }

}