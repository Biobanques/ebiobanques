<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Contact_resp extends EMongoSoftEmbeddedDocument
{
    
    /**
     *
     * @var string $firstName
     */
    public $first_name;
    /**
     *
     * @var string $lastName
     */
    public $last_name;
    /**
     *
     * @var string $email
     */
    public $email;
    /**
     *
     * @var string $country
     */
    public $phone;

    // We may define rules for embedded document too
    public function rules() {
        return array(
            array('first_name,last_name,email,phone', 'safe'),
            array('email', 'CEmailValidator', 'allowEmpty' => true),
            array('phone', 'phoneValidator', 'language' => 'fr'),
        );
    }

    // And attribute names too
    public function attributeLabels() {
        return array(
           'first_name' => Yii::t('common', 'firstname'),
            'last_name' => Yii::t('common', 'lastname'),
            'email' => Yii::t('common', 'email'),
            'phone' => Yii::t('common', 'phone'),
        );
    }

    public function phoneValidator($attribute, $params) {
        if (!isset($params['allowEmpty']))
            $params['allowEmpty'] = true;
        if ($params['allowEmpty'] == true && empty($this->$attribute))
            return true;
        if (!preg_match("#^\+33[0-9]{9}$#", $this->$attribute))
            $this->addError($attribute, Yii::t('common', 'InvalidPhoneNumber'));
    }

    public function attributeNames() {
        return array(
            
            'first_name',
            'last_name',
            'email',
            'phone'
        );
    }

    public function getFullNameForDDList() {
        return $this->last_name . '_' . $this->first_name;
    }

    // NOTE: for embedded documents we do not define static model method!
}