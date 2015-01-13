<?php

class Logo extends EMongoGridFS
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

    // this method should return the collection name for storing files
    public function getCollectionName() {
        return 'logo';
    }

    // normal rules method, if you use metadata field, set it as a 'safe' attribute
    public function rules() {
        return array(
            array('filename, metadata', 'safe'),
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

    public function isBiobankDefined($attributes, $params) {
        if (!isset($this->metadata['biobank_id']))
            $this->addError('filename', 'Biobank_id is not set.');
    }

    /**
     * display th ecurrent logo into html.
     * @return html img
     */
    public function toHtml() {
        $splitStringArray = split(".", $this->filename);
        $extension=end($splitStringArray);
        $result="<img src=\"".CommonTools::data_uri($this->getBytes(),"image/".$extension)."\"\" alt=\"1 photo\" style=\"height:120px;\"/>";
        return $result;
    }
}