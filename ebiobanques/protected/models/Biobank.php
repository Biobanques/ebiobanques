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
    /*
     * Champs obligatoires
     */
    public $id;
    public $identifier;
    public $name;
    public $long_name;
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
    public $location;
    public $keywords_MeSH;
    /**
     * var array 'logo' 'fr' 'en'
     * @var array
     */
    public $vitrine;
    /**
     * fields agregated related to the sampling activity
     */
    /**
     * values fixed: general population, disease
     * @var type
     */
    public $sampling_practice;
    /**
     * free text
     * @var type
     */
    public $sampling_disease_group;
    public $sampling_disease_group_code;
    /**
     * fields agregated relatives to the number of samples.
     * NBS : acronym of Number of Biological Samples
     * Default vallue is "empty". O indicate that there is no sample
     */
    public $nbs_dna_samples_affected;
    public $nbs_dna_samples_relatives;
    public $nbs_cdna_samples_affected;
    public $nbs_cdna_samples_relatives;
    public $nbs_wholeblood_samples_affected;
    public $nbs_wholeblood_samples_relatives;
    public $nbs_bloodcellisolates_samples_affected;
    public $nbs_bloodcellisolates_samples_relatives;
    public $nbs_serum_samples_affected;
    public $nbs_serum_samples_relatives;
    public $nbs_plasma_samples_affected;
    public $nbs_plasma_samples_relatives;
    public $nbs_fluids_samples_affected;
    public $nbs_fluids_samples_relatives;
    public $nbs_tissuescryopreserved_samples_affected;
    public $nbs_tissuescryopreserved_samples_relatives;
    public $nbs_tissuesparaffinembedded_samples_affected;
    public $nbs_tissuesparaffinembedded_samples_relatives;
    public $nbs_celllines_samples_affected;
    public $nbs_celllines_samples_relatives;
    public $nbs_other_samples_affected;
    public $nbs_other_samples_relatives;
    // public $website;
    /**
     * specify the type of samples if other. Free text.
     */
    public $nbs_other_specification;
    protected $qualityCombinate;

    public function getQualityCombinate() {
        return $this->qualityCombinate;
    }

    public function setQualityCombinate($value) {
        $this->qualityCombinate = $value;
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Biobank the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Embedded adress
     */
    public function embeddedDocuments() {
        return array(
            'address' => 'Address',
            'responsable_op' => 'Op_resp',
            'responsable_qual' => 'Qual_resp',
            'responsable_adj' => 'Adj_resp',
        );
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

    public function rules() {

        $rules = array(
            /**
             * mandatory attributes
             */
            array('identifier,name,collection_name,collection_id', 'required', 'on' => 'insert,update'),
            /**
             * Check unique in db
             * FIXME : EMONgoUniqueValidator doesn t work
             */
            array('identifier,name', 'CustomMongoUniqueValidator', 'on' => 'insert,update'),
            array('identifier', 'syntaxIdentifierValidator'),
            /**
             * max passphrase length, required by crypt API used
             */
            array('passphrase', 'length', 'max' => 8),
            /**
             * max folder length, limited but high
             */
            array('folder_reception', 'length', 'max' => 100),
            array('identifier', 'length', 'max' => 15),
            array('name', 'length', 'max' => 50),
            array('long_name', 'length', 'max' => 500),
            array('folder_done', 'length', 'max' => 100),
            /*
             * sampling data agregated
             */
            array('sampling_disease_group,sampling_disease_group_code
    ,nbs_dna_samples_affected,nbs_dna_samples_relatives,nbs_cdna_samples_affected
    ,nbs_cdna_samples_relatives,nbs_wholeblood_samples_affected
    ,nbs_wholeblood_samples_relatives
    ,nbs_bloodcellisolates_samples_affected
    ,nbs_bloodcellisolates_samples_relatives
    ,nbs_serum_samples_affected
    ,nbs_serum_samples_relatives
    ,nbs_plasma_samples_affected
    ,nbs_plasma_samples_relatives
    ,nbs_fluids_samples_affected
    ,nbs_fluids_samples_relatives
    ,nbs_tissuescryopreserved_samples_affected
    ,nbs_tissuescryopreserved_samples_relatives
    ,nbs_tissuesparaffinembedded_samples_affected
    ,nbs_tissuesparaffinembedded_samples_relatives
    ,nbs_celllines_samples_affected
    ,nbs_celllines_samples_relatives
    ,nbs_other_samples_affected
    ,nbs_other_samples_relatives', 'length', 'max' => 10),
            array('sampling_practice', 'length', 'max' => 2),
            array('nbs_other_specification', 'length', 'max' => 50),
            array('date_entry', 'type', 'type' => 'date', 'message' => '{attribute}: is invalid  date(dd/mm/yyyy)!', 'dateFormat' => 'dd/MM/yyyy'),
            array('qualityCombinate,identifier, name,collection_id, collection_name,diagnosis_available, contact_id, address,responsable_op,responsable_qual,responsable_adj,keywords_MeSH,tauxCompletude', 'safe', 'on' => 'search'),
            /**
             * Custom validator, for validation if some value
             */
            array('diagnosis_available', 'diagValidator', 'message' => '{attribute} is required when biobank_class is set to \'biobankClinical\'.', 'on' => 'insert,update'),
            /**
             * safes attributes : attributes not modified by th eapplication so without validation rule
             */
            array('id,', 'safe'),
        );
        if ($this->scenario == 'insert' || $this->scenario == 'update' || $this->scenario == 'search') {
            foreach ($this->attributes as $name => $value)
                $rules[] = array((string) $name, 'safe');
        }

        return $rules;
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

    public function syntaxIdentifierValidator($param) {
        if (!preg_match("/^[a-zA-Z0-9-]*$/i", $this->$param))
            $this->addError($param, 'L\'identifiant ne peut être composé que de lettres non accentuées, de chiffres et du signe "-"');
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'identifier' => Yii::t('common', 'identifier'), //
            'name' => Yii::t('common', 'name'),
            'collection_name' => Yii::t('common', 'collection_name'),
            'collection_id' => Yii::t('common', 'collection_id'),
            'date_entry' => Yii::t('common', 'date_entry'),
            'folder_reception' => Yii::t('common', 'folder_reception'),
            'folder_done' => Yii::t('common', 'folder_done'),
            'passphrase' => Yii::t('common', 'passphrase'),
            'contact_id' => 'Contact',
            'vitrine[fr]' => 'Texte en francais',
            'vitrine[logo]' => 'Image logo',
            'diagnosis_available' => Yii::t('common', 'diagnosisAvailable'),
            'keywords_MeSH' => 'keywords MeSH',
            'sampling_disease_group' => 'Disease group',
            'sampling_disease_group_code' => 'Disease groupe code',
            'nbs_dna_samples_affected' => 'DNA samples affected',
            'nbs_dna_samples_relatives' => 'DNA samples relatives',
            'nbs_cdna_samples_affected' => 'cDNA samples affected',
            'nbs_cdna_samples_relatives' => 'cDNA samples relatives',
            'nbs_wholeblood_samples_affected' => 'whole blood samples affected',
            'nbs_wholeblood_samples_relatives' => 'whole blood samples relatives',
            'nbs_bloodcellisolates_samples_affected' => 'blood cell isolates samples affected',
            'nbs_bloodcellisolates_samples_relatives' => 'blood cell isolates samples relatives',
            'nbs_serum_samples_affected' => 'serum samples affected',
            'nbs_serum_samples_relatives' => 'serum sample<br />s relatives',
            'nbs_plasma_samples_affected' => 'Plasma samples affected',
            'nbs_plasma_samples_relatives' => 'Plasma samples relatives',
            'nbs_fluids_samples_affected' => 'Fluids samples affected',
            'nbs_fluids_samples_relatives' => 'Fluids samples relatives',
            'nbs_tissuescryopreserved_samples_affected' => 'Tissues cryopreserved samples affected',
            'nbs_tissuescryopreserved_samples_relatives' => 'Tissues cryopreserved samples related',
            'nbs_tissuesparaffinembedded_samples_affected' => 'Tissues paraffin embedded samples affected',
            'nbs_tissuesparaffinembedded_samples_relatives' => 'Tissues paraffin embedded samples relatives',
            'nbs_celllines_samples_affected' => 'Cell lines samples affected',
            'nbs_celllines_samples_relatives' => 'Cell lines samples relatives',
            'nbs_other_samples_affected' => 'Other samples affected',
            'nbs_other_samples_relatives' => 'Other samples relatives',
            'sampling_practice' => 'General sampling practice',
            'address' => Yii::t('adress', 'address'),
            'responsable_op' => Yii::t('responsible', 'responsible_op'),
            'responsable_qual' => Yii::t('responsible', 'responsible_qual'),
            'responsable_adj' => Yii::t('responsible', 'responsable_adj'),
            'website' => Yii::t('common', 'website'),
            'qualityCombinate' => Yii::t('common', 'qualityCombinate'),
        );
    }

    public function attributeExportedLabels() {
        return array(
            //'_id' => 'ID',
            'name' => Yii::t('common', 'name'),
            'identifier' => Yii::t('common', 'identifier'),
            //'collection_name' => Yii::t('common', 'collection_name'),
            // 'contact_id' =>Yii::t('common', 'contact'),
            'address' => Yii::t('adress', 'address'),
            //'diagnosis_available' => Yii::t('common', 'diagnosisAvailable'),
            'website' => Yii::t('common', 'website'),
            'presentation' => Yii::t('common', 'presentation'),
            'thematiques' => Yii::t('common', 'thematiques'),
            'presentation_en' => Yii::t('common', 'presentation_en'),
            'thematiques_en' => Yii::t('common', 'thematiques_en'),
            'projetRecherche' => Yii::t('common', 'projetRecherche'),
            'projetRecherche_en' => Yii::t('common', 'projetRecherche_en'),
            'publications' => Yii::t('common', 'publications'),
            'reseaux' => Yii::t('common', 'reseaux'),
            'qualite' => Yii::t('common', 'qualite'),
            'qualite_en' => Yii::t('common', 'qualite_en'),
            'shortContact' => Yii::t('common', 'shortContact'),
            'emailContact' => Yii::t('common', 'emailContact'),
            'phoneContact' => Yii::t('common', 'phoneContact'),
            'responsable_op' => Yii::t('responsible', 'responsible_op'),
            'responsable_qual' => Yii::t('responsible', 'responsible_qual'),
            'responsable_adj' => Yii::t('responsible', 'responsable_adj'),
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
            $criteria->addCond('identifier', '==', new MongoRegex('/' . $this->identifier . '/i'));
        if ($this->responsable_op != null) {

        }

        if ($this->name != null)
            $criteria->addCond('name', '==', new MongoRegex('/' . $this->name . '/i'));
        if ($this->collection_name != null && $this->collection_name != "") {
            $listWords = explode(" ", $this->collection_name);
            $regex = "";
            foreach ($listWords as $word) {
                $regex.="$word|";
            }
            $regex = substr($regex, 0, -1);
            $criteria->addCond('collection_name', '==', new MongoRegex("/($regex)/i"));
        }
        if ($this->collection_id != null && $this->collection_id != "") {
            $listWords = explode(" ", $this->collection_id);
            $regexId = "";
            foreach ($listWords as $word) {
                $regexId.="$word|";
            }
            $regexId = substr($regexId, 0, -1);
            $criteria->addCond('collection_id', '==', new MongoRegex("/($regexId)/i"));
        }
        if ($this->qualityCombinate != null && $this->qualityCombinate != "") {
            $listWords = explode(" ", $this->qualityCombinate);
            $regexId = "";
            foreach ($listWords as $word) {
                $regexId.="$word|";
            }
            $regexId = substr($regexId, 0, -1);

            $criteria->createOrGroup('qualite');
            $criteria->addCondToOrGroup('qualite', array('quality' => new MongoRegex("/($regexId)/i")));
            $criteria->addCondToOrGroup('qualite', array('cert_ISO9001' => new MongoRegex("/($regexId)/i")));
            $criteria->addCondToOrGroup('qualite', array('cert_NFS96900' => new MongoRegex("/($regexId)/i")));
            $criteria->addCondToOrGroup('qualite', array('cert_autres' => new MongoRegex("/($regexId)/i")));
            $criteria->addOrGroup('qualite');
        }
        if ($this->diagnosis_available != null && $this->diagnosis_available != "") {
            $listWords = explode(" ", $this->diagnosis_available);
            $regexId = "";
            foreach ($listWords as $word) {
                $regexId.="$word|";
            }
            $regexId = substr($regexId, 0, -1);
            $criteria->addCond('diagnosis_available', '==', new MongoRegex("/($regexId)/i"));
        }
        if ($this->keywords_MeSH != null && $this->keywords_MeSH != "") {
            $listWords = explode(" ", $this->keywords_MeSH);
            $regexId = "";
            foreach ($listWords as $word) {
                $regexId.="$word|";
            }
            $regexId = substr($regexId, 0, -1);
            $criteria->addCond('keywords_MeSH', '==', new MongoRegex("/($regexId)/i"));
        }
        if ($this->contact_id != null && $this->contact_id != "")
            $criteria->contact_id = $this->contact_id;




        if (isset($this->responsable_adj) && $this->responsable_adj->lastName != null) {
            $criteria->addCond('responsable_adj.lastName', '==', new MongoRegex('/' . $this->responsable_adj->lastName . '/i'));
        }
        if (isset($this->responsable_adj) && $this->responsable_adj->firstName != null) {
            $criteria->addCond('responsable_adj.firstName', '==', new MongoRegex('/' . $this->responsable_adj->firstName . '/i'));
        }
        if (isset($this->responsable_op) && $this->responsable_op->lastName != null) {
            $criteria->addCond('responsable_op.lastName', '==', new MongoRegex('/' . $this->responsable_op->lastName . '/i'));
        }
        if (isset($this->responsable_op) && $this->responsable_op->firstName != null) {
            $criteria->addCond('responsable_op.firstName', '==', new MongoRegex('/' . $this->responsable_op->firstName . '/i'));
        }
        if (isset($this->responsable_qual) && $this->responsable_qual->lastName != null) {
            $criteria->addCond('responsable_qual.lastName', '==', new MongoRegex('/' . $this->responsable_qual->lastName . '/i'));
        }
        if (isset($this->responsable_qual) && $this->responsable_qual->firstName != null) {
            $criteria->addCond('responsable_qual.firstName', '==', new MongoRegex('/' . $this->responsable_qual->firstName . '/i'));
        }





        if (isset($this->address) && $this->address->city != null) {
            if ($this->address->city == '0') {
                $criteria->address->city = null;
            } else {
                $criteria->addCond('address.city', '==', new MongoRegex('/' . $this->address->city . '/i'));
            }
        }
        if (isset($this->address) && $this->address->country != null) {
            if ($this->address->country == '0') {
                $criteria->address->country = null;
            } else {
                $criteria->addCond('address.country', '==', new MongoRegex('/' . $this->address->country . '/i'));
            }
        }
//always sort with alphabetical order on name
        $criteria->sort('name', EMongoCriteria::SORT_ASC);
        Yii::app()->session['criteria'] = $criteria;
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function getContact() {
        $result = null;
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

    public function getDetailledStats() {
        return BiobankCompletionTools::getBiobankCompletudeRate($this->_id);
    }

    public function getTauxCompletude() {
        return $this->getDetailledStats()['fieldsPresent']['totalRate'];
    }

    public function getRoundedTauxCompletude() {
        return round($this->getTauxCompletude() * 100, 2);
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
     * retourne le resposnable formaté en chaine courte.
     * Vide si null
     */
    public function getShortResponsableOp() {
        $responsable_op = $this->responsable_op;
        if ($responsable_op != null)
            return $responsable_op != null ? $responsable_op->lastName . " " . $responsable_op->firstName : "";
    }

    public function getShortResponsableAdj() {
        $responsable_adj = $this->responsable_adj;
        if ($responsable_adj != null)
            return $responsable_adj != null ? $responsable_adj->lastName . " " . $responsable_adj->firstName : "";
    }

    public function getShortResponsableQual() {
        $responsable_qual = $this->responsable_qual;
        if ($responsable_qual != null)
            return $responsable_qual != null ? $responsable_qual->lastName . " " . $responsable_qual->firstName : "";
    }

    /**
     * retourne le contact formaté en chaine courte inversée (Prénom nom).
     * Vide si null
     */
    public function getShortContactInv() {
        $contact = $this->getContact();
        if ($contact != null) {
            $contact->first_name = ucfirst($contact->first_name);
            return $contact->first_name . " " . $contact->last_name;
        } else
            return "";
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
     * retourne le telephone du contact s il existe en format 01....., sans +33
     * @return string
     * @deprecated Use CommonFormatter instead of this ugly method.
     */
    public function getPhoneContactPDF() {
        $contact = $this->getContact();
        if ($contact != null && $contact->phone != null) {
            $contact->phone = '0' . substr($contact->phone, 3);
            return $contact->phone;
        } else
            return null;
    }

    /**
     * get an array of biobanks used by dropDownLIst.
     * The first line is blank to allow empty case.
     */
    public function getArrayActiveContact() {
        $result = array();
        $criteria = new EMongoCriteria;
        $criteria->select(array('_id', 'contact_id'));
        $biobankListe = Biobank::model()->findAll($criteria);
        foreach ($biobankListe as $biobank) {
            if ($biobank->contact_id != null && $biobank->contact_id != "") {
                $contactCriteria = new EMongoCriteria;
                $contactCriteria->_id = new MongoId($biobank->contact_id);
                $contactCriteria->select(array('_id', 'first_name', 'last_name'));
                $contact = Contact::model()->find($contactCriteria);
                $result[(string) $contact->_id] = $contact->last_name . " " . $contact->first_name;
            }
        }
        asort($result);
        return ($result);
    }

    /**
     * retourne un tableau de biobank avec une seule option.
     * utile pour les dropdown list, cas d un utilisateur avec droit admin de sa biobanque
     */
    public function getArrayBiobank($idBiobank) {
        $res = array();
        if ($idBiobank != null) {
            $biobank = Biobank::model()->findByPK(new MongoId($idBiobank));
            if ($biobank != null) {
                $res[(string) $biobank->_id] = $biobank->identifier;
            }
        }
        return $res;
    }

    /**
     * retourne un tableau de biobank avec une seule option.
     * utile pour les dropdown list, cas d un utilisateur avec droit admin de sa biobanque
     */
    public function getArrayBiobanks() {
        $res = array();

        $biobanks = Biobank::model()->findAll();
        foreach ($biobanks as $biobank)
            $res[(string) $biobank->_id] = $biobank->name;
        natcasesort($res);
        return $res;
    }

    /**
     * retourne le modele de la biobanque fournit par l id mongo
     * null sinon
     */
    public function getBiobank($mongoId) {
        if ($mongoId != null) {
            return Biobank::model()->findByPk(new MongoId($mongoId));
        } else {
            return null;
        }
    }

    /**
     * retourne le nom  de la biobanque s il en existe une avec l id, non défini sinon
     * util dans les grids de présentation pour user.
     * null sinon
     */
    public function getBiobankName($idBiobank = null) {
        $result = "Non défini";
        if ($idBiobank == null)
            return $this->name;
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

    public function setAdmin($id) {

        if ($id != null && $id != "")
            $this->admin = User::model()->findByPK(new MongoId($id));
        else
            $this->admin = null;
    }

    /**
     *
     * @return type
     */
    public function getAddress() {
        return ( $this->address->street . "\n"
                . $this->address->zip . " " . $this->address->city . "\n"
                . Yii::t('listCountries', $this->address->country));
    }

    public function getResponsableOp() {
        return ( Yii::t('responsible', $this->responsable_op->civility) . " " . $this->responsable_op->firstName . " " . $this->responsable_op->lastName . "\n" . $this->responsable_op->email . "\n" . $this->responsable_op->direct_phone);
    }

    public function getResponsableAdj() {
        return ( Yii::t('responsible', $this->responsable_adj->civility) . " " . $this->responsable_adj->firstName . " " . $this->responsable_adj->lastName . "\n" . $this->responsable_adj->email . "\n" . $this->responsable_adj->direct_phone);
    }

    public function getResponsableQual() {
        return ( Yii::t('responsible', $this->responsable_qual->civility) . " " . $this->responsable_qual->firstName . " " . $this->responsable_qual->lastName . "\n" . $this->responsable_qual->email . "\n" . $this->responsable_qual->direct_phone);
    }

    /**
     *
     * @return only the city of biobanks
     */
    public function getCity() {
        return ($this->address->city . "\n"
                . Yii::t('listCountries', $this->address->country));
    }

    public function getIdentifierAndName() {
        return "$this->identifier - $this->name";
    }

    /**
     * get an array of consent used by dropDownLIst.
     */
    public function getArraySamplingPractice() {
        $res = array();
        $res ['0'] = "general population";
        $res ['1'] = "disease";
        $res ['2'] = "general population and disease";
        return $res;
    }

    /**
     * get the literal sampling practice
     * Not defined if null
     */
    public function getSamplingPractice() {
        $result = $this->sampling_practice;
        $arr = $this->getArraySamplingPractice();
        if ($result != "" && $arr [$result] != null) {
            $result = $arr [$result];
        } else {
            $result = "Not defined";
        }
        return $result;
    }

    public function getWebsite() {
        if (isset($this->website) && $this->website != null && $this->website != '' && $this->website != '/')
            return $this->website;
        return null;
    }

    public function getWebsiteWithHttp() {
        if (isset($this->website) && $this->website != null && $this->website != '' && $this->website != '/') {
            if (strpos($this->website, 'http://') === false && strpos($this->website, 'https://') === false) {
                $this->website = 'http://' . $this->website;
            }
            return $this->website;
        }
        return null;
    }

    public function getFormattedWebsite() {
        if (isset($this->website) && $this->website != null && $this->website != '' && $this->website != '/') {
            if (strpos($this->website, 'http://') === false && strpos($this->website, 'https://') === false) {
                $this->website = 'http://' . $this->website;
            }
            return CHtml::link($this->website, $this->website, array("target" => "_blank"));
        }
        return '';
    }

    public function beforeSave() {
        if (isset($this->website) && $this->website != null && $this->website != '' && $this->website != '/') {
            if (strpos($this->website, 'http://') === false && strpos($this->website, 'https://') === false) {
                $this->website = 'http://' . $this->website;
            }
        }
        return parent::beforeSave();
    }

    public function getEmbeddedContactsList() {
        foreach (array('responsable_op', 'responsable_adj', 'responsable_qual')as $fieldName) {
            $newVal = $fieldName . "List";
            $$newVal = array();
            $$newVal = $this->getContactList($fieldName);
        }
        $result = array_merge($responsable_opList, $responsable_adjList, $responsable_qualList);
        return $result;
    }

    public function getContactList($fieldName) {
        return $this->getCollection()->distinct($fieldName);
    }

    public function getRespDropdownList($fieldName) {
        $list = $this->getContactList($fieldName);
        $result = array();

        foreach ($list as $contact) {
            if (isset($contact['lastName']) && $contact['lastName'] != '')
                $result[strtolower($contact['lastName'] . '_' . $contact['firstName'])] = ($contact['civility'] == "miss" ? 'Mme' : 'M.') . " " . ucfirst(strtolower($contact['firstName'])) . " " . strtoupper($contact['lastName']);
        }
        ksort($result);

        return $result;
    }

    public function getContactsFormatted($resp_types, $biobankIdCriteria = null, $nameCriteria = null, $cityCriteria = null, $countryCriteria = null) {
        $result = array();

        foreach ($resp_types as $resp_type) {
            $match = array();
            $match[$resp_type . '.lastName'] = array(
                '$nin' => array(
                    null,
                    ''
                ),
            );
            if ($nameCriteria != null)
                $match[$resp_type . '.lastName'] = new MongoRegex('/' . $nameCriteria . '/i');
            if ($biobankIdCriteria != null)
                $match['_id'] = new MongoId($biobankIdCriteria);
            if ($cityCriteria != null)
                $match['address.city'] = new MongoRegex('/' . $cityCriteria . '/i');
            if ($countryCriteria != null)
                $match['address.country'] = new MongoRegex('/' . $countryCriteria . '/i');
//            $arrayQuery = array(
//                array(
//                    '$match' =>
//                    $match
//                ),
//                array(
//                    '$project' =>
//                    array(
//                        '_id' => 1,
//                        'adresse' => '$address.street',
//                        'city' => '$address.city',
//                        'zip' => '$address.zip',
//                        'country' => '$address.country',
//                        $resp_type => 1,
//                        'type' =>
//                        array(
//                            '$literal' =>
//                            array(
//                                $resp_type
//                            ),
//                        ),
//                    ),
//                ),
//                array(
//                    '$unwind' => '$type',
//                ),
//                array(
//                    '$group' =>
//                    array(
//                        '_id' => '$_id',
//                        'city' =>
//                        array(
//                            '$first' => '$city',
//                        ),
//                        'country' =>
//                        array(
//                            '$first' => '$country',
//                        ),
//                        'zip' =>
//                        array(
//                            '$first' => '$zip',
//                        ),
//                        'adresse' =>
//                        array(
//                            '$first' => '$adresse',
//                        ),
//                        $resp_type =>
//                        array(
//                            '$first' => '$' . $resp_type,
//                        ),
//                        'responsables' =>
//                        array(
//                            '$push' =>
//                            array(
//                                '$cond' =>
//                                array(
//                                    array(
//                                        '$eq' =>
//                                        array(
//                                            '$type',
//                                            $resp_type,
//                                        ),
//                                    ),
//                                    '$' . $resp_type,
//                                    false
//                                ),
//                            ),
//                        ),
//                    ),
//                ),
//                array(
//                    '$project' =>
//                    array(
//                        '_id' => 1,
//                        'adresse' => 1,
//                        'zip' => 1,
//                        'city' => 1,
//                        'country' => 1,
//                        'responsables' => 1,
//                    ),
//                ),
//                array(
//                    '$unwind' => '$responsables',
//                ),
//                array(
//                    '$project' =>
//                    array(
//                        'biobank_id' => '$_id',
//                        'adresse' => '$adresse',
//                        'code_postal' => '$zip',
//                        'pays' => '$country',
//                        'ville' => '$city',
//                        'civility' => '$responsables.civility',
//                        'first_name' => '$responsables.firstName',
//                        'last_name' => '$responsables.lastName',
//                        'email' => '$responsables.email',
//                        'phone' => '$responsables.direct_phone',
//                        'contactType' => array('$literal' => $resp_type)
//                    ),
//                ),
//            );
            $arrayQuery = array(
                array(
                    '$match' =>
                    $match
                ),
                array(
                    '$project' =>
                    array(
                        'biobank_id' => '$_id',
                        'adresse' => '$address.street',
                        'ville' => '$address.city',
                        'code_postal' => '$address.zip',
                        'pays' => '$address.country',
                        'civility' => '$' . $resp_type . '.civility',
                        'first_name' => '$' . $resp_type . '.firstName',
                        'last_name' => '$' . $resp_type . '.lastName',
                        'email' => '$' . $resp_type . '.email',
                        'phone' => '$' . $resp_type . '.direct_phone',
                        'contactType' => array('$literal' => $resp_type)
            )));

            $partialResult = $this->getCollection("biobank")->aggregate($arrayQuery);
            $result = array_merge($result, $partialResult['result']);
        }
        return $result;
    }

}