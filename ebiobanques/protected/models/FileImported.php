<?php

/**
 * This is the MongoDB Document model class based on table "File_imported".
 */
class FileImported extends LoggableActiveRecord {

    public $id;
    public $biobank_id;
    public $extraction_id;
    public $given_name;
    public $suffix_type;
    public $generated_name;
    public $date_import;
    public $version_format;

    /**
     * Returns the static model of the specified AR class.
     * @return FileImported the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * returns the primary key field for this model
     */
    public function primaryKey() {
        return 'id';
    }

    /**
     * @return string the associated collection name
     */
    public function getCollectionName() {
        return 'file_imported';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('biobank_id, extraction_id, suffix_type, date_import, version_format', 'required'),
            array('biobank_id, suffix_type, version_format', 'numerical', 'integerOnly' => true),
            array('extraction_id', 'length', 'max' => 200),
            array('given_name, generated_name', 'length', 'max' => 250),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, biobank_id, extraction_id, given_name, suffix_type, generated_name, date_import, version_format', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'biobank_id' => 'Biobank',
            'extraction_id' => 'Extraction',
            'given_name' => 'Given Name',
            'suffix_type' => 'Suffix Type',
            'generated_name' => 'Generated Name',
            'date_import' => 'Date Import',
            'version_format' => 'Version Format',
        );
    }

    public function getDateLastImportByBiobank($biobank_id) {
        $criteria = new EMongoCriteria;
        $criteria->biobank_id = $biobank_id;
        $criteria->limit(1);
        $criteria->sort('date_import', EMongoCriteria::SORT_DESC);
        $criteria->select(array('date_import'));
        $result = $this->find($criteria);
        if ($result != null)
            return $result->date_import;
    }

    public function getBiobankName() {
        $biobank = Biobank::model()->findByAttributes(array(
            'id' => $this->biobank_id
        ));
        if ($biobank != null) {
            return $biobank->identifier;
        } else {
            return null;
        }
    }

}
