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
    protected $passwordCompare;
    public $email;
    public $telephone;
    public $gsm;
    public $profil = "0";
    public $inactif = "1";
    public $biobank_id;
    protected $verifyCode;
    /**
     *
     * @var MongoDate
     */
    public $inscription_date;

    public function getPasswordCompare() {
        return $this->passwordCompare;
    }

    public function setPasswordCompare($value) {
        $this->passwordCompare = $value;
    }

    public function getVerifyCode() {
        return $this->verifyCode;
    }

    public function setVerifyCode($code) {
        $this->verifyCode = $code;
    }

    public function getPrenom() {
        return ucfirst($this->prenom);
    }
    
     public function getShortName() {
         return ucfirst($this->nom ." ". $this->prenom);
     }

    public function getInscription_date() {
        if (Yii::app()->language == 'fr')
            return date('d/m/Y', $this->inscription_date->sec);
        return date('Y-m-d', $this->inscription_date->sec);
//        return date('d/m/Y', $this->inscription_date->sec);
    }

    public function getActifLink() {
        if ($this->inactif === "0")
            return array(
                'label' => Yii::t('common','disable'), 'url' => Yii::app()->createAbsoluteUrl("user/desactivate", array("id" => "$this->_id")));
        if ($this->inactif === "1")
            return array(
                'label' =>  Yii::t('common','validate'), 'url' => Yii::app()->createAbsoluteUrl("user/validate", array("id" => "$this->_id")));
        return array('label' => 'check Value : error', 'url' => '');
    }

// public $preferences;

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

    public function behaviors() {
        return array(
            'LoggableBehavior' =>
            'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        $result = array(
            //array('verifyCode', 'CaptchaExtendedValidator', 'allowEmpty' => false, 'on' => 'subscribe'),
            array('profil, inactif, gsm, telephone', 'numerical', 'integerOnly' => true),
            array('prenom,nom', 'alphaOnly'),
            array('login', 'alphaNumericOnly'),
            array('password', 'compare', 'compareAttribute' => 'passwordCompare', 'on' => 'subscribe,userUpdate'),
            array('prenom, nom, login, password, email', 'length', 'max' => 250),
            array('gsm', 'telPresent'),
            array('gsm, telephone', 'length', 'min' => 8),
            array('prenom, nom, login, password, email,inscription_date', 'required'),
            array('email', 'CEmailValidator', 'allowEmpty' => false),
            array('login', 'EMongoUniqueValidator', 'on' => 'subscribe,create'),
            array('password', 'pwdStrength'),
            array('password', 'length', 'min' => 6),
            array('prenom, nom, login, password, email, telephone, gsm, profil, inactif, biobank_id', 'safe', 'on' => 'search'),
            array('biobank_id,preferences', 'safe'),
            array('passwordCompare', 'safe', 'on' => 'subscribe,userUpdate'),
            array('passwordCompare', 'required', 'on' => 'subscribe,userUpdate'),
            array('inscription_date', 'required', 'on' => 'insert,update'),
            array('inscription_date', 'safe', 'on' => 'search'),
        );
        if (!CommonProperties::$DEV_MODE)
            $result[] = array('email', 'EMongoUniqueValidator');
        return $result;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($caseSensitive = false) {

        $criteria = new EMongoCriteria;

        foreach ($this->getSafeAttributeNames()as $attribute) {
            if ($this->$attribute != null && $attribute != 'preferences') {
                if ($attribute == 'inscription_date') {
                    /**
                     * @todo Implements search mechanism to search by year, month, exact date, with
                     * automatic detection of date format
                     */
                    //$criteria->addCond($attribute, ">=", new MongoDate(strtotime($this->$attribute)));
                } else if ($attribute == 'profil' || $attribute == 'inactif' || $attribute == 'biobank_id') {
                    $criteria->addCond($attribute, '==', $this->$attribute);
                } else
                    $criteria->addCond($attribute, '==', new MongoRegex('/' . $this->$attribute . '*/i'));
            }
        }

        $criteria->sort('inscription_date', EMongoCriteria::SORT_DESC);
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'nom',
                    'prenom',
                    /**
                     * @todo add custom comparator to sort by biobank name
                     */
                    //'biobank_id',
                    'inscription_date',
                    'profil',
                    'inactif'
                )
            )
                )
        );
    }

    public function embeddedDocuments() {
        return array(
            'preferences' => 'Preferences',
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
            'passwordCompare' => Yii::t('common', 'passwordCompare'),
            'email' => Yii::t('common', 'email'),
            'telephone' => Yii::t('common', 'phone'),
            'gsm' => Yii::t('common', 'gsm'),
            'profil' => Yii::t('common', 'profil'),
            'inactif' => Yii::t('common', 'inactive'),
            'biobank_id' => Yii::t('common', 'biobank'),
            'verifyCode' => Yii::t('common', 'verifyCode'),
        );
    }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeExportedLabelsForSql() {
        return array(
            'id' => 'id',
            'prenom' => Yii::t('common', 'firstname'),
            'nom' => Yii::t('common', 'lastname'),
            'login' => Yii::t('common', 'Login'),
            'password' => Yii::t('common', 'password'),
            'email' => Yii::t('common', 'email'),
            'telephone' => Yii::t('common', 'phone'),
            'gsm' => Yii::t('common', 'gsm'),
            'profil' => Yii::t('common', 'profil'),
            'inactif' => Yii::t('common', 'inactive'),
            'biobank_id' => Yii::t('common', 'biobank')
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
        $res ["0"] = Yii::t('common','standard_user');
        $res ["1"] = Yii::t('common','system_admin');
        $res ["2"] = Yii::t('common','biobank_admin');
        return $res;
    }

    /**
     * get an array of inactif
     */
    public function getArrayInactif() {
        $res = array();
        $res ["0"] = Yii::t('common','active');
        $res ["1"] = Yii::t('common','inactive');
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

    protected function beforeSave() {
        if (parent::beforeSave()) {
            // something happens here
            unset($this->verifyCode);
            $this->cleanAttributesFormat();
            return true;
        } else
            return false;
    }

    /**
     * Set inscription date if model is new record, or extract it from MongoId if not already set.
     * @return boolean
     */
    protected function beforeValidate() {
        if ($this->getIsNewRecord()) {
            $this->inscription_date = new MongoDate ();
        } else if (!isset($this->inscription_date) || $this->inscription_date == '') {
            CommonTools::extractDate($this);
        }

        return parent::beforeValidate();
    }

    /**
     * format attributes of the model to help sort and visibility.
     */
    public function cleanAttributesFormat() {
        $this->cleanNames();
        $this->cleanPhones();
    }

    /** clean the attributes names an dfirst name to hamronize
     */
    public function cleanNames() {
        $this->nom = mb_strtoupper($this->nom, "UTF-8");
        //convertie first name en lower case et mettant les caracteres en utf-8 ( cas possible de bug sur chaines mixtes)
        $this->prenom = mb_strtolower($this->prenom, "UTF-8");
    }

    /**
     * clean teh phones attributes to internationalize
     */
    public function cleanPhones() {
        //phone without withespace, point a 0> +33
        $this->telephone = $this->cleanPhone($this->telephone);
        $this->gsm = $this->cleanPhone($this->gsm);
    }

    public function cleanPhone($phone) {
        if ($phone != null) {
            $phoneN = mb_ereg_replace('/\s+/', '', $phone);
            $phoneN = mb_ereg_replace('/\./', '', $phoneN);
            //replace first zero and add +33
            $phoneN = mb_ereg_replace('/^0/', '+33', $phoneN);
            return $phoneN;
        } else
            return null;
    }

    public function getBiobankName() {
        $result = null;
        if (isset($this->biobank_id) && $this->biobank_id != null && $this->biobank_id != '') {
            $biobank = Biobank::model()->findByPk(new MongoId($this->biobank_id));
            if ($biobank != null) {
                $result = $biobank->name;
            }
        }
        return $result;
    }

}