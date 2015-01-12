<?php

/**
 * This is the MongoDB Document model class based on table "User".
 */
class User extends LoggableActiveRecord
{
    public $id;
    public $prenom;
    public $nom;
    public $login;
    public $password;
    public $email;
    public $telephone;
    public $gsm;
    public $profil;
    public $inactif;
    public $biobank_id;
    public $verifyCode;

    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * returns the primary key field for this model
     */

    /**
     * @return string the associated collection name
     */
    public function getCollectionName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
//			array('verifyCode', 'CaptchaExtendedValidator', 'allowEmpty'=>!CCaptcha::checkRequirements()),
            array('profil, inactif, biobank_id,gsm, telephone', 'numerical', 'integerOnly' => true),
            array('prenom, nom, login, password, email', 'length', 'max' => 250),
            array('gsm, telephone', 'length', 'min' => 8),
            array('prenom, nom, login, password, email, gsm', 'required'),
            array('email', 'CEmailValidator', 'allowEmpty' => false),
            array('login,email', 'EMongoUniqueValidator'),
            array('password', 'pwdStrength'),
            array('password', 'length', 'min' => 6),
            array('prenom, nom, login, password, email, telephone, gsm, profil, inactif, biobank_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            '_id' => 'ID',
            'prenom' => Yii::t('common', 'firstname'),
            'nom' => Yii::t('common', 'lastname'),
            'login' => Yii::t('common', 'Login'),
            'password' => Yii::t('common', 'password'),
            'email' => Yii::t('common', 'email'),
            'telephone' => Yii::t('common', 'phone'),
            'gsm' => Yii::t('common', 'gsm'),
            'profil' => Yii::t('common', 'profil'),
            'inactif' => Yii::t('common', 'inactif'),
            'biobank_id' => Yii::t('common', 'idBiobanque'),
            'verifyCode' => Yii::t('common', 'verifyCode'),
        );
    }

    /**
     * profils : 0 : utilisateur, 1 : admin sys, 2 :admin d une biobanque
     * @return type
     */
    public function getProfil() {
        $result = $this->profil;
        $arr = $this->getArrayProfil();
        if (empty($result))
            $result = 'U';
        if ($arr [$result] != null)
            $result = $arr [$result];
        else
            $result = $arr ['U'];
        return $result;
    }
    
        /**
     * @return type
     */
    public function getInactif() {
        $result = $this->inactif;
        $arr = $this->getArrayInactif();
        if (!empty($result)&&$arr [$result] != null) {
            $result = $arr [$result];
        } else {
            $result = "Not defined";
        }
        return $result;
    }
    
     /**
     * get an array of consent used by dropDownLIst.
     */
    public function getArrayProfil() {
        $res = array();
        $res ["O"] = "standard user";
        $res ["1"] = "admin systeme";
        $res ["2"] = "admin de biobanque";
        return $res;
    }
    
      /**
     * get an array of inactif
     */
    public function getArrayInactif() {
        $res = array();
        $res ["O"] = "actif";
        $res ["1"] = "inactif";
        return $res;
    }

    public function pwdStrength() {
        $nbDigit = 0;
        $length = strlen($this->password);
        for ($i = 0; $i < $length; $i++) {
            if (is_numeric($this->password[$i]))
                $nbDigit++;
        }
        if ($nbDigit < 2)
            $this->addError('password', Yii::t('common', 'notEnoughDigits'));
    }

}