<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Address extends EMongoSoftEmbeddedDocument
{
    /**
     *
     * @var string $street
     */
    public $street;
    /**
     *
     * @var string $zip
     */
    public $zip;
    /**
     *
     * @var string $city
     */
    public $city;
    /**
     *
     * @var string $country
     */
    public $country;

    // We may define rules for embedded document too
    public function rules() {
        return array(
            array('street,city,zip,country', 'required', 'on' => 'insert, update'),
            array('street,city,zip,country', 'safe', 'on' => 'search'),
        );
    }

    // And attribute names too
    public function attributeLabels() {
        return array(
            'street' => Yii::t('adress', 'street'),
            'city' => Yii::t('adress', 'city'),
            'zip' => Yii::t('adress', 'zip'),
            'country' => Yii::t('adress', 'country'),
        );
    }

    public function attributeNames() {
        return array(
            'street',
            'zip',
            'city',
            'country',
        );
    }

    // NOTE: for embedded documents we do not define static model method!
    //       we do not define getCollectionName method either.
}