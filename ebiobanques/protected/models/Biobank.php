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
class Biobank extends LoggableActiveRecord
{
    public $id;
    public $identifier;
    public $name = 'Non défini';
    public $collection_name = 'Non définie';
    public $collection_id;
    public $date_entry;
    public $folder_reception;
    public $folder_done;
    public $passphrase;
    public $contact_id;
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
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('id, identifier, name, collection_name, folder_reception, folder_done, passphrase,', 'required'),
            array('id,contact_id', 'numerical', 'integerOnly' => true),
            array('identifier, name, collection_name, collection_id', 'length', 'max' => 45),
            array('folder_reception, folder_done, passphrase', 'length', 'max' => 200),
            array('date_entry', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, identifier, name, collection_name, collection_id,contact_id, date_entry, folder_reception, folder_done, passphrase,vitrine', 'safe', 'on' => 'search'),
        );
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
            'vitrine[logo]' => 'Emplacement du logo'
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
            'vitrine["fr"]' => 'Texte en francais'
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
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function getContact() {
        $contact = Contact::model()->findByAttributes(array('id' => $this->contact_id));
        return $contact;
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
            $res[$row->id] = $row->identifier;
        }
        return $res;
    }

    /**
     * retourne un tableau de biobank avec une seule option.
     * utile pour les dropdown list, cas d un utilisateur avec droit admin de sa biobanque
     */
    public function getArrayBiobank($idBiobank) {
        $res = array();
        $biobank = $this->findByAttributes(array('id' => $idBiobank));
        $res[$biobank->id] = $biobank->identifier;

        return $res;
    }

    /**
     * retourne le modele de la biobanque fournit par l id
     * null sinon
     */
    public function getBiobank($idBiobank) {
        $result = null;
        $c = new EMongoCriteria;
        $c->id('==', $idBiobank);
        $biobanks = Biobank::model()->findAll($c);
        if (count($biobanks) == 1) {
            $result = $biobanks[0];
        }
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
            $result = $biobank->name;
        }
        return $result;
    }

    public function getVitrineLink() {
        if (isset($this->vitrine) && $this->vitrine != null)
            return Yii::app()->createUrl('vitrine/view', array('id' => $this->id));
        else
            return null;
    }

}