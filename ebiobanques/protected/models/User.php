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
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//			array('verifyCode', 'CaptchaExtendedValidator', 'allowEmpty'=>!CCaptcha::checkRequirements()),
            array('profil, inactif, biobank_id,gsm, telephone', 'numerical', 'integerOnly' => true),
            array('prenom, nom, login, password, email', 'length', 'max' => 250),
            array('gsm, telephone', 'length', 'min' => 8),
            array('prenom, nom, login, password, email, gsm', 'required'),
            array('email', 'CEmailValidator', 'allowEmpty' => false),
// 				array('login,email','CUniqueValidator'),
            array('login,email', 'EMongoUniqueValidator'),
            array('password', 'pwdStrength'),
            array('password', 'length', 'min' => 6),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
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

    public function getProfil() {
        $literalProfil = ($this->profil == 0 ? 'utilisateur' : 'administrateur de la biobanque');
        return $literalProfil;
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