<?php

/**
 * SampleSmartForm class.
 */
class BiobankIdentifierForm extends CFormModel
{
    public $identifier;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('identifier', 'length', 'max' => 400),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'identifier' => Yii::t('common', 'selectBrif'),
        );
    }

}