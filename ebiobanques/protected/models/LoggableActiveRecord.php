<?php

/**
 * classe qui ented l active record et ajoute le comprtement loggable utile pour catcher les actions effectuées sur la base
 * @author nicolas
 *
 */
abstract class LoggableActiveRecord extends EMongoSoftDocument
{

    /**
     * ajout du comportement pour log audittrail
     * @return multitype:string
     */
    public function behaviors() {
        return array(
            'LoggableBehavior' =>
            'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

    /**
     * CUSTOM VALIDATION RULES
     */

    /**
     * Alphabetic case unsensitive characters, including accentued characters, spaces and '-' only.
     */
    public function alphaOnly($attribute) {

        if (!preg_match("/^[a-zàâçéèêëîïôûùüÿñæœ -]*$/i", $this->$attribute))
            $this->addError($this->$attribute, Yii::t('common', 'onlyAlpha'));
    }

    /**
     * Alphabetic case unsensitive characters, including accentued characters, spaces and '-' only. + numeric
     */
    public function alphaNumericOnly($attribute) {
        if (!preg_match("/^[a-zàâçéèêëîïôûùüÿñæœ0-9 -]*$/i", $this->$attribute))
            $this->addError($this->$attribute, Yii::t('common', 'onlyAlphaNumeric'));
    }

    /**
     * phone validator. format : +33010203045
     * @param type $attribute
     * @param type $params
     */
    public function phoneValidator($attribute, $params) {
        if (!preg_match("#^\+33[0-9]{9}$#", $this->$attribute))
            $this->addError($this->$attribute, Yii::t('common', 'InvalidPhoneNumber'));
    }

    public function getShortValue($attribute) {
        return CommonTools::getShortValue($this->$attribute);
    }

}
?>