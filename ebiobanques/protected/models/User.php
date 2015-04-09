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
        $result = array(
            array('verifyCode', 'CaptchaExtendedValidator', 'allowEmpty' => !CCaptcha::checkRequirements()),
            array('profil, inactif, biobank_id,gsm, telephone', 'numerical', 'integerOnly' => true),
            array('prenom,nom', 'alphaOnly'),
            array('login', 'alphaNumericOnly'),
            array('prenom, nom, login, password, email', 'length', 'max' => 250),
            array('gsm', 'telPresent'),
            array('gsm, telephone', 'length', 'min' => 8),
            array('prenom, nom, login, password, email', 'required'),
            array('email', 'CEmailValidator', 'allowEmpty' => false),
            array('login', 'EMongoUniqueValidator'),
            array('password', 'pwdStrength'),
            array('password', 'length', 'min' => 6),
            array('prenom, nom, login, password, email, telephone, gsm, profil, inactif, biobank_id', 'safe', 'on' => 'search'),
        );
        if (!CommonProperties::$DEV_MODE)
            $result[] = array('email', 'EMongoUniqueValidator');
        return $result;
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
        if ($result != "" && $arr [$result] != null) {
            $result = $arr [$result];
        } else {
            $result = "Not defined";
        }
        return $result;
    }

    /**
     * @return type
     */
    public function getInactif() {
        $result = $this->inactif;
        $arr = $this->getArrayInactif();
        if ($result != "" && $arr [$result] != null) {
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
        $res ['0'] = "standard user";
        $res ['1'] = "admin systeme";
        $res ['2'] = "admin de biobanque";
        return $res;
    }

    /**
     * get an array of inactif
     */
    public function getArrayInactif() {
        $res = array();
        $res ['0'] = "actif";
        $res ['1'] = "inactif";
        return $res;
    }

    /**
     * Custom validation rules
     */
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

    public function telPresent() {
        if (in_array($this->telephone, array("", null)) && in_array($this->gsm, array("", null)))
            $this->addError('gsm', Yii::t('common', 'atLeastOneTel'));
    }

    /**
     * Alphabetic case unsensitive characters, including accentued characters, spaces and '-' only.
     */
    public function alphaOnly() {
        if (!preg_match("/^[a-zàâçéèêëîïôûùüÿñæœ -]*$/i", $this->nom))
            $this->addError('nom', Yii::t('common', 'onlyAlpha'));
        if (!preg_match("/^[a-zàâçéèêëîïôûùüÿñæœ -]*$/i", $this->prenom))
            $this->addError('prenom', Yii::t('common', 'onlyAlpha'));
    }

    /**
     * Alphabetic case unsensitive characters, including accentued characters, spaces and '-' only. + numeric
     */
    public function alphaNumericOnly() {
        if (!preg_match("/^[a-zàâçéèêëîïôûùüÿñæœ0-9 -]*$/i", $this->nom))
            $this->addError('login', Yii::t('common', 'onlyAlphaNumeric'));
    }

}