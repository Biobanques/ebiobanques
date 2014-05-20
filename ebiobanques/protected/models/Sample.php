<?php

/**
 *
 * TODO declarere mieux les proprietes de recherche pour eviter dans les logs les usafe attribute
 * NB : Les champs sont stockés sous la form e destring, même pour le svaleurs numériques.
 * L'affectation d'uen valeur numérique pour la recherche peut entrainer des surprises, convertir le svaleurs numériques via strval() pemret d 'eviter certains écueils.
 *  * @property integer $id
 * @property string $id_depositor
 * @property string $id_sample
 * @property string $consent_ethical
 * format stocké M, F, U pour male female, unkown
 * @property string $gender
 *
 * @property int $age
 * @property string $collect_date
 * @property string $storage_conditions
 * @property string $consent
 * @property string $supply
 * @property integer $max_delay_delivery
 * @property string $detail_treatment
 * @property string $disease_outcome
 * @property string $authentication_method
 * @property string $patient_birth_date
 * @property string $tumor_diagnosis
 * @property integer $biobank_id
 * @property integer $file_imported_id
 * @author nicolas
 *
 */
class Sample extends EMongoDocument
{
    /**
     * champs classiques d echantillons
     */
    public $id;
    public $biobank_id;
    public $consent_ethical;
    public $id_depositor;
    public $id_sample;
    public $gender;
    /* age code en int */
    public $age;
    /* format ISO-standard (8601) time format AAAA-MM-JJThh:mm:ss */
    public $collect_date;
    public $storage_conditions;
    public $consent;
    public $supply;
    public $max_delay_delivery;
    public $detail_treatment;
    public $disease_outcome;
    public $authentication_method;
    /*
     * TODO : format mal recupéré homogénéisé la source
     */
    public $patient_birth_date;
    public $tumor_diagnosis;
    public $file_imported_id;
    public $notes;
    public $field_notes;
    /**
     * format string uniquement pas de int
     * @var type
     */
    public $field_age_min;
    /**
     * format string uniquement pas de int
     * @var type
     */
    public $field_age_max;

    // This has to be defined in every model, this is same as with standard Yii ActiveRecord
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    // This method is required!
    public function getCollectionName() {
        return 'echantillon';
    }

    public function behaviors() {
        return array('embeddedArrays' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'notes', // name of property, that will be used as an array
                'arrayDocClassName' => 'Note'  // class name of embedded documents in array
            ),
            'LoggableBehavior' =>
            'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

    public function rules() {
        return array(
            array(
                'id_sample, biobank_id, file_imported_id',
                'required'
            ),
            array(
                'age, max_delay_delivery, biobank_id, file_imported_id',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'id_depositor, id_sample, supply, detail_treatment, disease_outcome, authentication_method, tumor_diagnosis',
                'length',
                'max' => 45
            ),
            array(
                'consent_ethical, gender, consent',
                'length',
                'max' => 1
            ),
            array(
                'storage_conditions',
                'length',
                'max' => 2
            ),
            array(
                'collect_date, patient_birth_date',
                'safe'
            ),
            array(
                'field_notes',
                'length',
                'max' => 60
            ),
            array(
                'field_age_min',
                'length',
                'max' => 3
            ),
            array(
                'field_age_max',
                'length',
                'max' => 3
            ),
            array(
                'id, id_depositor, id_sample, consent_ethical, gender, age, collect_date, storage_conditions, consent, supply, max_delay_delivery, detail_treatment, disease_outcome, authentication_method, patient_birth_date, tumor_diagnosis, biobank_id, file_imported_id,field_notes,notes,concernerEchantillon',
                'safe',
                'on' => 'search'
            )
        );
    }

    public function attributeLabels() {

        return array(
            'id' => Yii::t('sample', 'id'),
            'biobank_id' => Yii::t('sample', 'biobank_id'),
            'consent_ethical' => Yii::t('sample', 'consent_ethical'),
            'id_depositor' => Yii::t('sample', 'id_depositor'),
            'id_sample' => Yii::t('sample', 'id_sample'),
            'gender' => Yii::t('sample', 'gender'),
            'age' => Yii::t('sample', 'age'),
            'collect_date' => Yii::t('sample', 'collect_date'),
            'storage_conditions' => Yii::t('sample', 'storage_conditions'),
            'consent' => Yii::t('sample', 'consent'),
            'supply' => Yii::t('sample', 'supply'),
            'max_delay_delivery' => Yii::t('sample', 'max_delay_delivery'),
            'detail_treatment' => Yii::t('sample', 'detail_treatment'),
            'disease_outcome' => Yii::t('sample', 'disease_outcome'),
            'authentication_method' => Yii::t('sample', 'authentication_method'),
            'patient_birth_date' => Yii::t('sample', 'patient_birth_date'),
            'tumor_diagnosis' => Yii::t('sample', 'tumor_diagnosis'),
            'file_imported_id' => Yii::t('sample', 'file_imported_id'),
            'notes' => Yii::t('sample', 'notes'),
            'field_notes' => Yii::t('sample', 'field_notes'),
            'field_age_min' => Yii::t('sample', 'field_age_min'),
            'field_age_max' => Yii::t('sample', 'field_age_max'),
        );
    }

    public function search($caseSensitive = false) {
        return $this->searchWithNotes();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchWithNotes() {
        $criteria = new EMongoCriteria ();
        if (isset($this->biobank_id) && !empty($this->biobank_id)) {
            $criteria->biobank_id = "" . $this->biobank_id . "";
        }

        if (isset($this->gender) && !empty($this->gender) && $this->gender != "U") {
            $criteria->gender = "" . $this->gender . "";
        }

        if (isset($this->id_depositor) && !empty($this->id_depositor)) {
            $criteria->id_depositor = "" . $this->id_depositor . "";
        }
        if (isset($this->id_sample) && !empty($this->id_sample)) {
            $criteria->id_sample = "" . $this->id_sample . "";
        }
        if (isset($this->storage_conditions) && !empty($this->storage_conditions) && $this->storage_conditions != "U") {
            $criteria->storage_conditions = "" . $this->storage_conditions . "";
        }
        if (isset($this->consent) && !empty($this->consent) && $this->consent != "U") {
            $criteria->consent = "" . $this->consent . "";
        }
        if (isset($this->max_delay_delivery) && !empty($this->max_delay_delivery)) {
            $criteria->max_delay_delivery = "" . $this->max_delay_delivery . "";
        }
        if (isset($this->detail_treatment) && !empty($this->detail_treatment)) {
            $criteria->detail_treatment = "" . $this->detail_treatment . "";
        }
        if (isset($this->disease_outcome) && !empty($this->disease_outcome)) {
            $criteria->disease_outcome = "" . $this->disease_outcome . "";
        }

        if (isset($this->tumor_diagnosis) && !empty($this->tumor_diagnosis)) {
            $criteria->tumor_diagnosis = "" . $this->tumor_diagnosis . "";
        }
        // // recherche dans notes
        if (isset($this->field_notes) && !empty($this->field_notes)) {
            $criteria->addCond('notes.value', '==', new MongoRegex('/' . $this->field_notes . '*/i'));
        }
        if (isset($this->field_age_min) && !empty($this->field_age_min)) {
            $criteria->addcond('age', '>=', strval($this->field_age_min));
        }
        if (isset($this->field_age_max) && !empty($this->field_age_max)) {
            $criteria->addcond('age', '<=', strval($this->field_age_max));
        }
        // Yii::app()->session['criteria']=$criteria;
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
                ));
    }

    /**
     * get des notes version courte pour affichage sur tableau admin.
     */
    public function getShortNotes() {
        $result = "";
        //TODO reactiver cette partie quand operationnelle
        if ($this->notes != null && !empty($this->notes)) {
            foreach ($this->notes as $note) {
                if ($note != null)
                    $result .= $note->value;
            }
            if (count($result > 7)) {
                $result = mb_substr($result, 0, 10, 'UTF-8') . "...";
            }
        }
        return $result;
    }

    public function searchByBiobank($biobankId) {
        $criteria = new EMongoCriteria ();
        $criteria->biobank_id = $biobankId;
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
                ));
    }

    public function getBiobankName() {
        $biobank = Biobank::model()->findByAttributes(array(
            'id' => $this->biobank_id
                ));
        return $biobank->identifier;
    }

    /**
     * return teh literal value of storage condition
     * if 80 then -80°C etc.
     * if null set U for unknown
     */
    public function getLiteralStorageCondition() {
        $result = $this->storage_conditions;
        $arr = $this->getArrayStorage();
        if (empty($result))
            $result = 'U';
        if ($arr [$result] != null)
            $result = $arr [$result];
        else
            $result = $arr ['U'];
        return $result;
    }

    /**
     * get an array of consent used by dropDownLIst.
     */
    public function getArrayConsent() {
        $res = array();
        $res ["Y"] = "Yes";
        $res ["N"] = "No";
        $res ["U"] = "Unkown";
        return $res;
    }

    /**
     * get an array of genders used by dropDownLIst.
     */
    public function getArrayGender() {
        $res = array();
        $res ["M"] = "Male";
        $res ["F"] = "Female";
        $res ["U"] = "Unkown";
        return $res;
    }

    /**
     * get an array of storage used by dropDownLIst.
     */
    public function getArrayStorage() {
        $res = array();
        $res ["U"] = "Unknown";
        $res ["LN"] = "Liquid Nitrogen";
        $res ["80"] = "-80°C";
        $res ["RT"] = "Room Temperature";
        return $res;
    }

    public function isInDemand() {
        $result = false;
        $demande = Yii::app()->session ['activeDemand'] [0];
        $sampleList = array();
        if (!empty($demande->sampleList)) {
            foreach ($demande->sampleList as $samples)
                $sampleList [] = $samples->id_sample;
            if (in_array($this->_id, $sampleList))
                $result = true;
        }
        return $result;
    }

    public function getSamplesFromArray($samples) {
        $criteria = new EMongoCriteria ();
        $criteria->addCond('_id', 'in', $samples);
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
                ));
    }

}
?>