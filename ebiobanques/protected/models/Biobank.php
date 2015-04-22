<?php


/**
 * This is the model class for table "Biobank".
 *
 * The followings are the available columns in table 'Biobank':
 * @property integer $id
 * @property string $identifier
 * @property string $name
 * @property string $collection_name
 * @property string $collection_id
 * @property string $date_entry
 * @property string $folder_reception
 * @property string $folder_done
 * @property string $passphrase
 * @property string $contact_id
 *
 * The followings are the available model relations:
 * @property Echantillon[] $echantillons
 * @property FileImported[] $fileImporteds
 */
class Biobank extends LoggableActiveRecord {
    /*
     * Champs obligatoires
     */

    public $id;
    public $identifier;
    public $name;
    public $collection_name;
    public $collection_id;
    public $biobank_class = 'biobankClinical';

    /*
     * Champs facultatifs
     */
    public $date_entry;
    public $folder_reception;
    public $folder_done;
    public $passphrase;
    public $contact_id;
    public $diagnosis_available;
    public $longitude;
    public $latitude;

    /**
     * var array 'logo' 'fr' 'en'
     * @var array
     */
    public $vitrine;

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
        return 'biobank';
    }

    /**
     * Operations sur les attributs obligatoires, pour copie des valeurs si inexistantes
     * @return boolean
     */
    public function beforeValidate() {
        if ($this->name == null) {
            Yii::log('Trying to store a biobank without name, operation refused', CLogger::LEVEL_WARNING);
        } else {
            if ($this->collection_name == null) {
                Yii::log('Trying to store a biobank without collection name, attribute set as name.', CLogger::LEVEL_WARNING);
                $this->collection_name = $this->name;
            }
            if ($this->collection_id == null) {
                Yii::log('Trying to store a biobank without collection id, attribute set as collection name.', CLogger::LEVEL_WARNING);
                $this->collection_id = $this->collection_name;
            }
        } return true;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            /**
             * mandatory attributes
             */
            array('identifier,name,collection_name,collection_id,contact_id', 'required', 'on' => 'insert,update'),
            /**
             * Check unique in db
             * FIXME : EMONgoUniqueValidator doesn t work
             */
            //array('identifier,name', 'EMongoUniqueValidator', 'on' => 'insert,update'),
            /**
             * max passphrase length, required by crypt API used
             */
            array('passphrase', 'length', 'max' => 8),
            /**
             * max folder length, limited but high
             */
            array('folder_reception', 'length', 'max' => 100),
            array('folder_done', 'length', 'max' => 100),
            array('date_entry', 'type', 'type' => 'date', 'message' => '{attribute}: is invalid  date(dd/mm/yyyy)!', 'dateFormat' => 'dd/MM/yyyy'),
            /**
             * Custom validator, for validation if some value
             */
            array('diagnosis_available', 'diagValidator', 'message' => '{attribute} is required when biobank_class is set to \'biobankClinical\'.', 'on' => 'insert,update'),
            /**
             * safes attributes : attributes not modified by th eapplication so without validation rule
             */
            array('id', 'safe'),
        );
    }

    /**
     * Custom validation rules
     */
    public function diagValidator($attributes, $params) {
        if ($this->biobank_class == 'biobankClinical') {
            $diagValid = CValidator::createValidator('required', $this, $attributes, $params);
            $diagValid->validate($this);
        }
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'identifier' => Yii::t('common', 'identifier'),
            'name' => Yii::t('common', 'name'),
            'collection_name' => Yii::t('common', 'collection_name'),
            'collection_id' => Yii::t('common', 'collection_id'),
            'date_entry' => Yii::t('common', 'date_entry'),
            'folder_reception' => Yii::t('common', 'folder_reception'),
            'folder_done' => Yii::t('common', 'folder_done'),
            'passphrase' => Yii::t('common', 'passphrase'),
            'contact_id' => 'Contact',
            'vitrine[fr]' => 'Texte en francais',
            'vitrine[logo]' => 'Image logo'
        );
    }

    public function attributeExportedLabels() {
        return array(
            'id' => 'ID',
            'identifier' => Yii::t('common', 'identifier'),
            'name' => Yii::t('common', 'name'),
            'collection_name' => Yii::t('common', 'collection_name'),
            'collection_id' => Yii::t('common', 'collection_id'),
            'date_entry' => Yii::t('common', 'date_entry'),
            'folder_reception' => Yii::t('common', 'folder_reception'),
            'folder_done' => Yii::t('common', 'folder_done'),
            'passphrase' => Yii::t('common', 'passphrase'),
            'contact_id' => 'Contact',
            'vitrine[page_accueil_fr]' => 'Page d\'accueil en français'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($caseSensitive = false) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new EMongoCriteria;
        if ($this->identifier != null)
            $criteria->addCond('identifier', '==', new MongoRegex('/' . $this->identifier . '*/i'));
        if ($this->name != null)
            $criteria->addCond('name', '==', new MongoRegex('/' . $this->name . '*/i'));
        if ($this->collection_name != null)
            $criteria->addCond('collection_name', '==', new MongoRegex('/' . $this->collection_name . '*/i'));
        //always sort with alphabetical order
        $criteria->sort('name', EMongoCriteria::SORT_ASC);
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function getContact() {
        $result =null;
        //check if the string is a mongo id string
        if (MongoId::isValid($this->contact_id)) {
            if ($this->contact_id != null) {
                $result = Contact::model()->findByPk(new MongoID($this->contact_id));
                if ($result == null) {
                    $result = Contact::model()->findByAttributes(array("id" => $this->contact_id));
                }
            } 
        }
        return $result;
    }

    /**
     * retourne le contact formaté en chaine courte.
     * Vide si null
     */
    public function getShortContact() {
        $contact = $this->getContact();
        if ($contact != null)
            return $contact != null ? $contact->last_name . " " . $contact->first_name : "";
    }

    /**
     * retourne l email du contact s il existe
     * @return string
     */
    public function getEmailContact() {
        $contact = $this->getContact();
        if ($contact != null && $contact->email != null)
            return $contact->email;
        else
            return null;
    }

    /**
     * retourne le telephone du contact s il existe
     * @return string
     */
    public function getPhoneContact() {
        $contact = $this->getContact();
        if ($contact != null && $contact->phone != null)
            return $contact->phone;
        else
            return null;
    }

    /**
     * get an array of biobanks used by dropDownLIst.
     * The first line is blank to allow empty case.
     */
    public function getArrayBiobanks() {
        $res = array();
        $biobanks = $this->findAll();
        foreach ($biobanks as $row) {
            $res[(string) $row->_id] = mb_strcut($row->identifier." ".$row->name, 0, 75);
        }
        return $res;
    }

    /**
     * retourne un tableau de biobank avec une seule option.
     * utile pour les dropdown list, cas d un utilisateur avec droit admin de sa biobanque
     */
    public function getArrayBiobank($idBiobank) {
        $res = array();
        $biobank = $this->findByPK(new MongoId($idBiobank));
        $res[$biobank->_id] = $biobank->identifier;

        return $res;
    }

    /**
     * retourne le modele de la biobanque fournit par l id
     * null sinon
     */
    public function getBiobank($idBiobank) {
        $result = null;
        $result = $this->findByPk($idBiobank);
        return $result;
    }

    /**
     * retourne le nom  de la biobanque s il en existe une avec l id, non défini sinon
     * util dans les grids de présentation pour user.
     * null sinon
     */
    public function getBiobankName($idBiobank) {
        $result = "Non défini";
        $biobank = $this->getBiobank($idBiobank);
        if ($biobank != null) {
            $result = $biobank->identifier;
        }
        return $result;
    }

    public function getVitrineLink() {
        if (isset($this->vitrine) && $this->vitrine != null)
            return Yii::app()->createUrl('vitrine/view', array('id' => $this->_id));
        else
            return null;
    }

    /**
     *
     * get the logo object for this biobank, null if not setted
     * @return Logo
     */
    public function getLogo() {
        $result = null;
        if (isset($this->vitrine) && isset($this->vitrine['logo'])) {
            $result = Logo::model()->findByPk(new MongoId($this->vitrine['logo']));
        }
        return $result;
    }

    public function getAdmin() {

        $result = null;
        $user = User::model()->findByAttributes(array('biobank_id' => $this->_id));
        if ($user != null)
            $result = $user;
        return $result;
    }

//
    public function setAdmin($id) {

        if ($id != null && $id != "")
            $this->admin = User::model()->findByPK(new MongoId($id));
        else
            $this->admin = null;
    }

}
