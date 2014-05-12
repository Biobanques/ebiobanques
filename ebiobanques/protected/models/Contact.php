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
 * @property integer $pays
 * @property string $code_postal
 * @property integer $inactive
 */
class Contact extends LoggableActiveRecord {

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
            array('first_name, last_name,email', 'required'),
            array('pays, inactive, biobank_id,', 'numerical', 'integerOnly' => true),
            array('first_name, last_name, email, phone', 'length', 'max' => 250),
            array('adresse', 'length', 'max' => 200),
            array('ville', 'length', 'max' => 50),
            array('code_postal', 'length', 'max' => 10),
            array('id, first_name, last_name, email, phone, adresse, ville, pays, code_postal, inactive', 'safe', 'on' => 'search'),
        );
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
        if ($this->biobank_id != null) {
            $biobank = Biobank::model()->findByAttributes(array('id' => $this->biobank_id));
            $criteria->id = $biobank->contact_id;
        }
        if ($this->inactive != null) {
            $criteria->addCond('inactive', '==', $this->inactive);
        }
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
        $contacts = $this->findAll();
        foreach ($contacts as $row) {
            $res[$row->id] = $row->first_name . " " . $row->last_name;
        }
        return $res;
    }

}
