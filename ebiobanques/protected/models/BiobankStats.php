<?php

/**
 * This is the model class for table "BiobankStats".

 *
 * The followings are the available model relations:
 */
class BiobankStats extends LoggableActiveRecord {
    public $biobank_id;
    public $date;
    public $globalRate;
    public $values;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Biobank the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function getCollectionName() {
        return 'biobankStats';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {

        return array(
        );
    }

    public function attributeExportedLabels() {
        return array(
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($caseSensitive = false) {
        return new EMongoDocumentDataProvider($this);
    }

    public static function getByBiobank($biobankId, $limit) {
        $criteria = new EMongoCriteria;
        $criteria->addCond('biobank_id', '==', $biobankId);
        $criteria->sort('date', EMongoCriteria::SORT_DESC);
        $criteria->limit($limit);
        return BiobankStats::model()->findAll($criteria);
    }

}