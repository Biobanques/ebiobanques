<?php

class UploadedFile extends EMongoGridFS
{
    /**
     * This field is optional, but:
     * from PHP MongoDB driver manual:
     *
     * 'You should be able to use any files created by MongoGridFS with any other drivers, and vice versa.
     * However, some drivers expect that all metadata associated with a file be in a "metadata" field.
     * If you're going to be using other languages, it's a good idea to wrap info you might want them
     * to see in a "metadata" field.'
     *
     * @var array $metadata array of additional info/metadata about a file
     */
    public $filename;
    public $metadata = array();
    public $uploadDate;
    // public $length;

    /**
     * property to store the value if add samples at the end or replace
     */
    // protected $addOrReplace;
    // this method should return the collection name for storing files
    public function getCollectionName() {
        return 'uploadedEchFile';
    }

    public function behaviors() {
        return array(
            'LoggableBehavior' =>
            'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

    // normal rules method, if you use metadata field, set it as a 'safe' attribute
    public function rules() {
        return array(
            array('filename, metadata', 'safe'),
            //array('length', 'safe', 'on' => 'search'),
            // array('addOrReplace', 'unsafe'),
            array('filename,uploadDate', 'required'),
            array('metadata', 'isBiobankDefined'),
        );
    }

    /**
     * Just like normal ActiveRecord/EMongoDocument classes
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array(
            'formLabel' => 'Fichier à importer'
        );
    }

    public function isBiobankDefined($attributes, $params) {
        if (!isset($this->metadata['biobank_id']))
            $this->addError('filename', 'Biobank_id is not set.');
    }

    public function getAddOrReplace() {
        return $this->metadata['addToOld'];
    }

    public function setAddOrReplace($value) {
        $this->metadata['addToOld'] = $value;
    }

}