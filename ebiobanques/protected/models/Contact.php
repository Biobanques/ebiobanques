<?php

/**
 * This is the model class for table "Contact".
 *
 * The followings are the available columns in table 'Contact':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $adresse
 * @property string $ville
 * @property string $pays
 * @property string $code_postal
 * @property integer $inactive
 */
class Contact extends LoggableActiveRecord {

    /**
     * id is deprectaed. use _id to store relation with contact
     * @var type 
     * @deprecated since version 1.4
     */
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $adresse;
    public $ville;
    public $pays;
    public $code_postal;
    public $inactive;

    /**
     * biobank attached to this contact
     * a contact must be attached to a biobank. A biobank must have one main contact
     * @var type 
     */
    public $biobank_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Contact the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function getCollectionName() {
        return 'contact';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {

        return array(
            /**
             * Mandatory attributes
             */
            array('first_name, last_name,email,phone,adresse,ville, code_postal,pays,inactive,biobank_id', 'required'),
            /**
             * Email validation
             */
            array('email', 'CEmailValidator', 'allowEmpty' => false),
            /**
             * Alphabetic only, defined in LoggableActiveRecord class
             */
            array('first_name, last_name, pays', 'alphaOnly'),
            array('pays', 'length', 'max' => 2),
            array('email', 'EMongoUniqueValidator'),
            array('code_postal', 'numerical', 'integerOnly' => true),
            array('code_postal', 'length', 'max' => 5),
            /**
             * Global custom phone validator, defined in LoggableActiveRecord class
             */
            array('phone', 'phoneValidator', 'language' => $this->pays),
            /**
             * id is a safe attribute, not to modified by user
             */
            array('id', 'safe'),
        );
    }

    /**
     * Custom validation rules
     */

    /**
     * Alphabetic case unsensitive characters, including accentued characters, spaces and '-' only. + numeric
     */
    public function alphaNumericOnly() {
        if (!preg_match("/^[a-zàâçéèêëîïôûùüÿñæœ0-9 -]*$/i", $this->nom))
            $this->addError('login', Yii::t('common', 'onlyAlphaNumeric'));
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'first_name' => Yii::t('common', 'firstname'),
            'last_name' => Yii::t('common', 'lastname'),
            'email' => Yii::t('common', 'email'),
            'phone' => Yii::t('common', 'phone'),
            'adresse' => Yii::t('common', 'adress'),
            'ville' => Yii::t('common', 'city'),
            'pays' => Yii::t('common', 'country'),
            'code_postal' => Yii::t('common', 'zipcode'),
            'inactive' => Yii::t('common', 'inactive'),
            'biobank' => Yii::t('common', 'biobanks'),
            'biobank_id' => Yii::t('common', 'biobanks'),
        );
    }

    public function attributeExportedLabels() {
        return array(
            'id' => 'ID',
            'first_name' => Yii::t('common', 'firstname'),
            'last_name' => Yii::t('common', 'lastname'),
            'email' => Yii::t('common', 'email'),
            'phone' => Yii::t('common', 'phone'),
            'adresse' => Yii::t('common', 'adress'),
            'biobank' => Yii::t('common', 'biobanks'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($caseSensitive = false) {
        $criteria = new EMongoCriteria;
        if ($this->first_name != null)
            $criteria->addCond('first_name', '==', new MongoRegex('/' . $this->first_name . '*/i'));
        if ($this->last_name != null)
            $criteria->addCond('last_name', '==', new MongoRegex('/' . $this->last_name . '*/i'));
        if ($this->ville != null)
            $criteria->addCond('ville', '==', new MongoRegex('/' . $this->ville . '*/i'));
        if ($this->pays != null)
            $criteria->addCond('pays', '==', new MongoRegex('/' . $this->pays . '*/i'));
        if ($this->inactive != null) {
            $criteria->addCond('inactive', '==', $this->inactive);
        }
        //always sort with alphabetical order
        $criteria->sort('last_name', EMongoCriteria::SORT_ASC);
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * get an array of contacts used by dropDownLIst.
     * The first line is blank to allow empty case.
     */
    public function getArrayContacts() {
        $res = array();
        $criteria = new EMongoCriteria;
        $criteria->sort('last_name', EMongoCriteria::SORT_ASC);
        $contacts = $this->findAll($criteria);
        foreach ($contacts as $row) {
            $res[(string) $row->_id] = $row->last_name . " " . $row->first_name;
        }
        return $res;
    }

    /**
     * get biobank name of this contact
     * usefull in view contacts for site
     * @return type
     */
    public function getBiobankName() {
        $result = 'Not defined';
        if ($this->biobank_id != null && isset($this->biobank_id)) {
            $biobank = Biobank::model()->findByPK(new MongoID($this->biobank_id));
            if (isset($biobank)) {
                $result = $biobank->name;
            }
        }
        return $result;
    }

}
