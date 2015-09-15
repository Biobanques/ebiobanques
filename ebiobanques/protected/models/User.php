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
            array('verifyCode', 'CaptchaExtendedValidator', 'allowEmpty' => false, 'on' => 'subscribe'),
            array('profil, inactif, gsm, telephone', 'numerical', 'integerOnly' => true),
            array('prenom,nom', 'alphaOnly'),
            array('login', 'alphaNumericOnly'),
            array('prenom, nom, login, password, email', 'length', 'max' => 250),
            array('gsm', 'telPresent'),
            array('gsm, telephone', 'length', 'min' => 8),
            array('prenom, nom, login, password, email', 'required'),
            array('email', 'CEmailValidator', 'allowEmpty' => false),
            array('login', 'EMongoUniqueValidator', 'on' => 'subscribe,create'),
            array('password', 'pwdStrength'),
            array('password', 'length', 'min' => 6),
            array('prenom, nom, login, password, email, telephone, gsm, profil, inactif, biobank_id', 'safe', 'on' => 'search'),
            array('biobank_id', 'safe'),
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
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new EMongoCriteria;
        if ($this->nom != null)
            $criteria->addCond('nom', '==', new MongoRegex('/' . $this->nom . '*/i'));
        if ($this->prenom != null)
            $criteria->addCond('prenom', '==', new MongoRegex('/' . $this->name . '*/i'));
        //always sort with alphabetical order
        $criteria->sort('nom', EMongoCriteria::SORT_ASC);
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('attributes' => $this->attributeNames())
        ));
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
        if (!preg_match("/^[a-zàâçéèêëîïôûùüÿñæœ0-9 -]*$/i", $this->login))
            $this->addError('login', Yii::t('common', 'onlyAlphaNumeric'));
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {
            // something happens here
            $this->cleanAttributesFormat();
            return true;
        } else
            return false;
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