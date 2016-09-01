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

    /**
     * pathologies are stored in french and english
     * @var type 
     */
    public $pathologies;
    public $pathologies_en;
    public $longitude;
    public $latitude;
    public $location;

    /**
     * keywords mesh are stored in english and french
     * @var type 
     */
    public $keywords_MeSH;
    public $keywords_MeSH_fr;
    public $acronym;
    public $presentation_en;

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
    public $materialStoredPlasma;
    public $materialStoredRNA;
    public $materialStoredSaliva;
    public $materialStoredSerum;
    public $materialStoredTissueFFPE;
    public $materialStoredTissueFrozen;
    public $materialStoredUrine;
    public $materialStoredBlood;
    public $materialStoredDNA;
    public $materialStoredFaeces;
    public $materialStoredImmortalizedCellLines;
    public $materialTumoralTissue;
    public $materialHealthyTissue;
    public $materialLCR;
    public $materialOther;
    public $sampling_disease_group;
    public $sampling_disease_group_code;

    /**
     * total number of samples, integer value only.
     * Displayed in a format like 10^x.
     * @var type 
     */
    public $nb_total_samples;
    public $collectionDataAccessFee = 'TRUE';
    public $collectionDataAccessJointProjects = 'TRUE';
    public $collectionSampleAccessFee = 'TRUE';
    public $collectionSampleAccessJointProjects = 'TRUE';
    public $PartnerCharterSigned = 'TRUE';

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

    /**
     * array of ICD codes
     */
    public $cims = array();
    public $contact_search;
    protected $qualityCombinate;

    /**
     * get the array of material types
     * @since 1.8.0
     */
    public function getAttributesMaterial() {
        return [
            'materialStoredDNA',
            'materialStoredPlasma',
            'materialStoredSerum',
            'materialStoredUrine',
            'materialStoredSaliva',
            'materialStoredFaeces',
            'materialStoredRNA',
            'materialStoredBlood',
            'materialStoredTissueFrozen',
            'materialStoredTissueFFPE',
            'materialStoredImmortalizedCellLines',
            'materialTumoralTissue',
            'materialHealthyTissue',
            'materialLCR',
            'materialOther',
        ];
    }

    public function getQualityCombinate() {
        return $this->qualityCombinate;
    }

    public function setQualityCombinate($value) {
        $this->qualityCombinate = $value;
    }

    public function removeCimCode($position) {
        if (isset($this->cims[$position])) {
            unset($this->cims[$position]);
        }
        $this->save(false);
    }

    public function addCimCode($cimCode) {
        $cimValidation = CommonTools::validateCimCodeFormat($cimCode);
        $listOfCodes = array();
        foreach ($this->cims as $cim) {
            $listOfCodes[] = $cim['code'];
        }
        if (!in_array($cimCode, $listOfCodes) && $cimValidation) {
            $this->cims[] = array('code' => $cimCode);
            return $this->save(false);
        }

        return false;
    }

    public function getListOfIcd() {
        $result = [];
        $listWords = [];
        $listCims = [];
        if (isset($this->diagnosis_available) && $this->diagnosis_available != '') {
            $listWords = explode(" / ", $this->diagnosis_available);
            foreach ($listWords as $word) {
                if ($word == 'Other') {
                    $result['R00-Z99'] = 'R00-Z99';
                } else if (CommonTools::validateCimCodeFormat($word)) {
                    $result[$word] = $word;
                }
            }
        }
        if (isset($this->cims) && $this->cims != []) {
            foreach ($this->cims as $cim) {
                if ($cim['code'] == 'Other') {
                    $result[$cim['code']] = $cim['R00-Z99'];
                } else if (CommonTools::validateCimCodeFormat($cim['code'])) {
                    $result[$cim['code']] = $cim['code'];
                }
            }
        }
        return $result;
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
        if (isset($this->address) && $this->address != null && (!isset($this->location) || $this->location == null)) {
            CommonTools::getLatLong($this, false);
        }

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
            /**
             * nb_total_samples : integer postive only
             */
            array('nb_total_samples', 'numerical',
                'integerOnly' => true,
                'min' => 1,),
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
            array('qualityCombinate,identifier, name,collection_id, collection_name,diagnosis_available, contact_id, contact_search,address,address.city,responsable_op,responsable_qual,responsable_adj,keywords_MeSH,tauxCompletude', 'safe', 'on' => 'search'),
            /**
             * Custom validator, for validation if some value
             */
            array('diagnosis_available', 'diagValidator', 'message' => '{attribute} is required when biobank_class is set to \'biobankClinical\'.', 'on' => 'insert,update'),
            /**
             * safes attributes : attributes not modified by th eapplication so without validation rule
             */
            array('id', 'safe'),
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
            'identifier' => Yii::t('common', 'biobank.identifier'), //
            'name' => Yii::t('common', 'biobank.name'),
            'acronym' => Yii::t('common', 'biobank.acronym'),
            'presentation' => Yii::t('common', 'biobank.presentation'),
            'presentation_en' => Yii::t('common', 'biobank.presentation_en'),
            'collection_id' => Yii::t('common', 'biobank.collection_id'),
            'materialStoredDNA' => Yii::t('common', 'biobank.materialStoredDNA'),
            'materialStoredPlasma' => Yii::t('common', 'biobank.materialStoredPlasma'),
            'materialStoredSerum' => Yii::t('common', 'biobank.materialStoredSerum'),
            'materialStoredTissueFFPE' => Yii::t('common', 'biobank.materialStoredTissueFFPE'),
            'materialStoredTissueFrozen' => Yii::t('common', 'biobank.materialStoredTissueFrozen'),
            'materialStoredRNA' => Yii::t('common', 'biobank.materialStoredRNA'),
            'materialStoredSaliva' => Yii::t('common', 'biobank.materialStoredSaliva'),
            'materialStoredUrine' => Yii::t('common', 'biobank.materialStoredUrine'),
            'materialStoredFaeces' => Yii::t('common', 'biobank.materialStoredFaeces'),
            'materialStoredBlood' => Yii::t('common', 'biobank.materialStoredBlood'),
            'materialStoredImmortalizedCellLines' => Yii::t('common', 'biobank.materialStoredImmortalizedCellLines'),
            'materialTumoralTissue' => Yii::t('common', 'biobank.materialTumoralTissue'),
            'materialHealthyTissue' => Yii::t('common', 'biobank.materialHealthyTissue'),
            'materialLCR' => Yii::t('common', 'biobank.materialLCR'),
            'materialOther' => Yii::t('common', 'biobank.materialOther'),
            'cert_ISO9001' => Yii::t('common', 'biobank.cert_ISO9001'),
            'cert_NFS96900' => Yii::t('common', 'biobank.cert_NFS96900'),
            'cert_autres' => Yii::t('common', 'biobank.cert_autres'),
            'nb_total_samples' => Yii::t('common', 'biobank.nb_total_samples'),
            'website' => Yii::t('common', 'biobank.website'),
            'keywords_MeSH' => Yii::t('common', 'biobank.keywords_MeSH'),
            'keywords_MeSH_fr' => Yii::t('common', 'biobank.keywords_MeSH_fr'),
            'diagnosis_available' => Yii::t('common', 'biobank.diagnosis_available'),
            'pathologies' => Yii::t('common', 'biobank.pathologies'),
            'pathologies_en' => Yii::t('common', 'biobank.pathologies_en'),
            /* oldies */
            'collection_name' => Yii::t('common', 'collection_name'),
            'date_entry' => Yii::t('common', 'date_entry'),
            'folder_reception' => Yii::t('common', 'folder_reception'),
            'folder_done' => Yii::t('common', 'folder_done'),
            'passphrase' => Yii::t('common', 'passphrase'),
            'contact_id' => 'Contact',
            'vitrine[fr]' => 'Texte en francais',
            'vitrine[logo]' => 'Image logo',
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
            'qualityCombinate' => Yii::t('common', 'qualityCombinate'),
            'last_name' => Yii::t('common', 'lastname'),
            'first_name' => Yii::t('common', 'firstname'),
            'phone' => Yii::t('common', 'phone'),
            'email' => Yii::t('common', 'email'),
            'zipcode' => Yii::t('common', 'zipcode'),
            'city' => Yii::t('common', 'city'),
            'sample_type' => Yii::t('common', 'biobank.sample_type'),
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
//        if ($this->qualityCombinate != null && $this->qualityCombinate != "") {
//            $listWords = explode(" ", $this->qualityCombinate);
//            $regexId = "";
//            foreach ($listWords as $word) {
//                $regexId.="$word|";
//            }
//            $regexId = substr($regexId, 0, -1);
//
//            $criteria->createOrGroup('qualite');
//            $criteria->addCondToOrGroup('qualite', array('quality' => new MongoRegex("/($regexId)/i")));
//            $criteria->addCondToOrGroup('qualite', array('cert_ISO9001' => new MongoRegex("/($regexId)/i")));
//            $criteria->addCondToOrGroup('qualite', array('cert_NFS96900' => new MongoRegex("/($regexId)/i")));
//            $criteria->addCondToOrGroup('qualite', array('cert_autres' => new MongoRegex("/($regexId)/i")));
//            $criteria->addOrGroup('qualite');
//        }
        if (isset($this->cert_ISO9001) && $this->cert_ISO9001 != null && $this->cert_ISO9001 != []) {
            $criteria->addCond('cert_ISO9001', 'in', $this->cert_ISO9001);
        }
        if (isset($this->cert_ISO9001) && $this->cert_NFS96900 != null && $this->cert_NFS96900 != []) {
            $criteria->addCond('cert_NFS96900', 'in', $this->cert_NFS96900);
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
            $criteria->contact_id = (string) $this->contact_id;
        if ($this->contact_search != null && $this->contact_search != "") {
            $contactCriteria = new EMongoCriteria();
//            $contactCriteria->addOrGroup('globalName');
            $contactCriteria->addCondToOrGroup('globalName', ['first_name' => new MongoRegex('/' . $this->contact_search . '/i')]);
            $contactCriteria->addCondToOrGroup('globalName', ['last_name' => new MongoRegex('/' . $this->contact_search . '/i')]);
            $contactCriteria->addOrGroup('globalName');
            $contactCriteria->select(['_id' => true]);
            $contacts = Contact::model()->findAll($contactCriteria);
            $listIds = [];
            foreach ($contacts as $contact) {
                $listIds[] = (string) $contact->_id;
            }
            $criteria->addCond('contact_id', 'in', $listIds);
        }
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


//        if (isset($this->textSearchField) && $this->textSearchField != null && $this->textSearchField != '' && isset($this->textSearchValue) && $this->textSearchValue != null && $this->textSearchValue != '') {
//
//            $resultDrop = $this->getDb()->selectCollection('biobank')->deleteIndexes();
//            $this->getDb()->selectCollection('biobank')->createIndex([$this->textSearchField => 'text'], ['name' => 'TextSearchIndex']);
//            $criteria->addCond('$text', '==', ['$search' => $this->textSearchValue]);
//        }

        if (isset($this->presentation) && $this->presentation != null && $this->presentation != '') {
            $textCriteria = str_replace(' ', '||', $this->presentation);
            $criteria->createOrGroup('presentation');
            $criteria->addCondToOrGroup('presentation', ['presentation' => new MongoRegex("/$textCriteria/i")]);
            $criteria->addCondToOrGroup('presentation', ['presentation_en' => new MongoRegex("/$textCriteria/i")]);
            $criteria->addOrGroup('presentation');
        }
        if (isset($this->projetRecherche) && $this->projetRecherche != null && $this->projetRecherche != '') {
            $textCriteria = str_replace(' ', '||', $this->projetRecherche);
            $criteria->createOrGroup('projetRecherche');
            $criteria->addCondToOrGroup('projetRecherche', ['projetRecherche' => new MongoRegex("/$textCriteria/i")]);
            $criteria->addCondToOrGroup('projetRecherche', ['projetRecherche_en' => new MongoRegex("/$textCriteria/i")]);
            $criteria->addOrGroup('projetRecherche');
        }
        if (isset($this->reseaux) && $this->reseaux != null && $this->reseaux != '') {
            $textCriteria = str_replace(' ', '||', $this->reseaux);

            $criteria->addCond('reseaux', '==', new MongoRegex("/$textCriteria/i"));
        }
        if (isset($this->thematiques) && $this->thematiques != null && $this->thematiques != '') {
            $textCriteria = str_replace(' ', '||', $this->thematiques);
            $criteria->createOrGroup('thematiques');
            $criteria->addCondToOrGroup('thematiques', ['thematiques' => new MongoRegex("/$textCriteria/i")]);
            $criteria->addCondToOrGroup('thematiques', ['thematiques_en' => new MongoRegex("/$textCriteria/i")]);
            $criteria->addOrGroup('thematiques');
        }
        if (isset($this->publications) && $this->publications != null && $this->publications != '') {
            $textCriteria = str_replace(' ', '||', $this->publications);

            $criteria->addCond('publications', '==', new MongoRegex("/$textCriteria/i"));
        }

//always sort with alphabetical order on name
        $criteria->sort('name', EMongoCriteria::SORT_ASC);
        Yii::app()->session['criteria'] = $criteria;


        //$dataProvider = Biobank::model()->find($criteria->getConditions())
        $dataProvider = new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
        ));
        return $dataProvider;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * Get the keywords searched and analyze each term
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchCatalogue($keywords, $caseSensitive = false) {
        $criteria = new EMongoCriteria;
        Yii::log('new  search catalog ',Clogger::LEVEL_INFO);
        if ($keywords != null && isset($keywords)) {
            //split des mots cles
            $tabKeywords = explode(" ", $keywords);
            //display keywords:
            Yii::log('keywords for search : '.$keywords,Clogger::LEVEL_INFO);
            //search if each keywords is present into one field (or codition)
            $i=0;
            foreach ($tabKeywords as $keyword) {
                //check if the keyword is an ICD10 code 
                //if yes add a search condition
                
                Yii::log('search word: '.$keyword,Clogger::LEVEL_INFO);
                $orGroupName='orGroup'.$i;
                $criteria->createOrGroup($orGroupName);
                $criteria->addCondToOrGroup($orGroupName, ['identifier' => new MongoRegex('/' . $keyword . '/i')]);
                $criteria->addCondToOrGroup($orGroupName, ['name' => new MongoRegex('/' . $keyword . '/i')]);
                $criteria->addCondToOrGroup($orGroupName, ['keywords_MeSH' => new MongoRegex('/' .$keyword . '/i')]);
                $criteria->addCondToOrGroup($orGroupName, ['keywords_MeSH_fr' => new MongoRegex('/' .$keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['collection_name' => new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['collection_id' => new MongoRegex('/' . $keyword . '/i')]);
                 
                  $criteria->addCondToOrGroup($orGroupName, ['responsable_adj.lastName' => new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['responsable_adj.firstName' => new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['responsable_op.lastName'=> new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['responsable_op.firstName'=> new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['responsable_qual.lastName'=> new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['responsable_qual.firstName'=> new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['address.city'=> new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['presentation' => new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['presentation_en' => new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['projetRecherche' => new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['projetRecherche_en' => new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['reseaux' => new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['thematiques' => new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['thematiques_en' => new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['publications' => new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['pathologies' => new MongoRegex('/' . $keyword . '/i')]);
                  $criteria->addCondToOrGroup($orGroupName, ['pathologies_en' => new MongoRegex('/' . $keyword . '/i')]); 
                  
                 // $criteria->addCondToOrGroup($orGroupName, ['diagnosis_available' => new MongoRegex('/C00-D48/i')]); 
                  
                  
                  if(ICDComparator::isICDCode($keyword)){
                    $ICD10Group=  ICDComparator::getGroup($keyword);
                    if($ICD10Group!=null){
                        Yii::log('add criteria diagnosis avaialbale on icdcode: '.$ICD10Group,Clogger::LEVEL_INFO);
                        $criteria->addCondToOrGroup($orGroupName, ['diagnosis_available' => new MongoRegex('/' . $ICD10Group. '/i')]); 
                    }
                }
                $criteria->addOrGroup($orGroupName);
                $i++;
            }
        }
//always sort with alphabetical order on name
        $criteria->sort('name', EMongoCriteria::SORT_ASC);
        Yii::app()->session['criteria'] = $criteria;


        //$dataProvider = Biobank::model()->find($criteria->getConditions())
        $dataProvider = new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
        ));
        return $dataProvider;
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

    public function setContact(Contact $contact) {
        $this->contact = $contact;
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
                $result[strtolower($contact['lastName'] . '_' . $contact['firstName'])] = (isset($contact['civility']) && $contact['civility'] == "miss" ? 'Mme' : 'M.') . " " . ucfirst(strtolower($contact['firstName'])) . " " . strtoupper($contact['lastName']);
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

    /**
     * get the number of samples in a formatted text.
     * ex : 10 000 - 50 000
     * @since 1.8.1
     */
    public function getSampleNumberFormatted() {
        $res = "< 10 000";
        if ($this->nb_total_samples > 10000)
            $res = "10 000 - 50 000";
        if ($this->nb_total_samples > 50000)
            $res = "50 000 - 100 000";
        if ($this->nb_total_samples > 100000)
            $res = "100 000 - 300 000";
        if ($this->nb_total_samples > 300000)
            $res = "300 000 - 500 000";
        if ($this->nb_total_samples > 500000)
            $res = "500 000 - 1 000 000";
        if ($this->nb_total_samples > 1000000)
            $res = "> 1 000 000";
        return $res;
    }

    /**
     * get the available types of samples in the biobank
     * ex : DNA,Cells 
     * @since 1.8.1
     * @TODO remove ", " at the end of th emethod by replacing characters (find the good php function) 
     */
    public function getSampleTypeFormatted() {
        $res = "";
        foreach ($this->getAttributesMaterial() as $material) {
            if ($this->$material == "TRUE") {
                if (strlen($res) > 2) {
                    $res.=", ";
                }
                $res.=Yii::t('common', 'biobank.' . $material);
            }
        }
        return $res;
    }

    /**
     * get the available options to answer on the status of certification.
     * @return array of status
     * @since 1.8.1
     */
    public function getCertificationOptions() {
        return ['OUI' => Yii::t('common', 'oui'), 'NON' => Yii::t('common', 'non'), 'EN COURS' => Yii::t('common', 'en cours')];
    }

    /**
     * get the certification of the biobank in a formatted text
     * ex : NFS96900, ISO9001
     * @since 1.8.1
     * @TODO remove ", " at the end of th emethod by replacing characters (find the good php function) 
     */
    public function getCertificationFormatted() {
        $res = "";
        if ($this->cert_ISO9001 == "OUI")
            $res.="ISO9001";
        if ($this->cert_NFS96900 == "OUI") {
            if (strlen($res) > 0) {
                $res.=", ";
            }
            $res.="NFS96900";
        }
        if (isset($this->cert_autres) && $this->cert_autres != "/") {
            if (strlen($res) > 0) {
                $res.=", ";
            }
            $res.=$this->cert_autres;
        }
        return $res;
    }

}
