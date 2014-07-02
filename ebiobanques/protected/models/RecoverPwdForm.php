<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RecoverPwdForm extends CFormModel
{
    public $email;
    public $identifier;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('email', 'CEmailValidator', 'allowEmpty' => true),
            array('identifier', 'type', 'type' => 'string')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'email' => Yii::t('common', 'email'),
            'identifier' => Yii::t('common', 'identifier')
        );
    }

    public function validateFields() {
        $mixedResult = array();
        $result = false;
        $message = '';
        $user = null;
        if (!empty($this->email) || !empty($this->identifier)) {
            if (!empty($this->email) && !empty($this->identifier)) {
                $criteria = new EMongoCriteria();
                $criteria->email = $this->email;
                $criteria->login = $this->identifier;
                $user = User::model()->find($criteria);
                if ($user != null) {
                    $result = true;
                    $message = Yii::t('common', 'recoverMessageSent', array('{userEmail}' => $user->email));
                } else {
                    $result = false;
                    $message = Yii::t('common', 'noUserWithEmailAndIdentifier', array('{badEmail}' => $this->email, '{badIdentifier}' => $this->identifier));
                }
            } elseif (!empty($this->email)) {
                $criteria = new EMongoCriteria();
                $criteria->email = $this->email;
                $user = User::model()->find($criteria);
                if ($user != null) {
                    $result = true;
                    $message = Yii::t('common', 'recoverMessageSent', array('{userEmail}' => $user->email));
                } else {
                    $result = false;
                    $message = Yii::t('common', 'noUserWithEmail', array('{badEmail}' => $this->email));
                }
            } elseif (!empty($this->identifier)) {
                $criteria = new EMongoCriteria();
                $criteria->login = $this->identifier;
                $user = User::model()->find($criteria);
                if ($user != null) {
                    $result = true;
                    $message = Yii::t('common', 'recoverMessageSent', array('{userEmail}' => $user->email));
                } else {
                    $result = false;
                    $message = Yii::t('common', 'noUserWithIdentifier', array('{badIdentifier}' => $this->identifier));
                }
            }
        } else {
            $result = false;
            $message = Yii::t('common', 'atLeastOneField');
        }
        $mixedResult['user'] = $user;
        $mixedResult['result'] = $result;
        $mixedResult['message'] = $message;
        return $mixedResult;
    }

}