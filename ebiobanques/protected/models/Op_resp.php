<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Op_resp extends EMongoSoftEmbeddedDocument
{
    /**
     *
     * @var string $firstName
     */
    public $firstName;
    /**
     *
     * @var string $lastName
     */
    public $lastName;
    /**
     *
     * @var string $email
     */
    public $email;
    /**
     *
     * @var string $country
     */
    public $direct_phone;

    // We may define rules for embedded document too
    public function rules() {
        return array(
            array('firstName,lastName,email,direct_phone', 'safe'),
            array('email', 'CEmailValidator', 'allowEmpty' => true),
            array('direct_phone', 'phoneValidator', 'language' => 'fr'),
        );
    }

    // And attribute names too
    public function attributeLabels() {
        return array(
            'firstName' => Yii::t('responsible', 'firstName'),
            'lastName' => Yii::t('responsible', 'lastName'),
            'email' => Yii::t('responsible', 'email'),
            'direct_phone' => Yii::t('responsible', 'direct_phone')
        );
    }

    public function phoneValidator($attribute, $params) {
        if (!preg_match("#^\+33[0-9]{9}$#", $this->$attribute))
            $this->addError($attribute, Yii::t('common', 'InvalidPhoneNumber'));
    }

    public function attributeNames() {
        return array(
            'firstName',
            'lastName',
            'email',
            'direct_phone'
        );
    }

    // NOTE: for embedded documents we do not define static model method!
}