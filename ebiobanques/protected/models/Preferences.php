<?php

/**
 * This is the model class for table "Preferences".
 *
 * The followings are the available columns in table 'Preferences':
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_depositor
 * @property integer $id_sample
 * @property integer $consent_ethical
 * @property integer $gender
 * @property integer $age
 * @property integer $collect_date
 * @property integer $storage_conditions
 * @property integer $consent
 * @property integer $supply
 * @property integer $max_delay_delivery
 * @property integer $detail_treatment
 * @property integer $disease_outcome
 * @property integer $authentication_method
 * @property integer $patient_birth_date
 * @property integer $tumor_diagnosis
 * @property integer $biobank_id
 * @property integer $notes
 *
 */
class Preferences extends EMongoSoftEmbeddedDocument
{
    public $id_depositor;
    public $id_sample;
    public $consent_ethical;
    public $gender = 1;
    public $age = 1;
    public $collect_date;
    public $storage_conditions = 1;
    public $consent;
    public $supply;
    public $max_delay_delivery;
    public $detail_treatment;
    public $disease_outcome;
    public $authentication_method;
    public $patient_birth_date;
    public $tumor_diagnosis;
    public $biobank_id = 1;
    public $notes = 1;
    public $collection_name = 1;
    public $collection_id;

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('id_depositor,id_sample ,consent_ethical ,gender ,age ,collect_date ,storage_conditions
 ,consent ,supply ,max_delay_delivery ,detail_treatment ,disease_outcome ,authentication_method ,patient_birth_date ,tumor_diagnosis
 ,biobank_id,notes,
 collection_name, collection_id', 'length', 'max' => 1
            ),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
                'id_user ,id_depositor,id_sample ,consent_ethical ,gender ,age ,collect_date ,storage_conditions
 ,consent ,supply ,max_delay_delivery ,detail_treatment ,disease_outcome ,authentication_method ,patient_birth_date ,tumor_diagnosis
 ,biobank_id ,notes,
 collection_name, collection_id',
                'safe',
                'on' => 'search,insert,update'
            )
        );
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {

        return array(
            'id_user' => Yii::t('common', 'idUser'),
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
            'collection_name' => Biobank::model()->getAttributeLabel('collection_name'),
            'collection_id' => Biobank::model()->getAttributeLabel('collection_id'),
        );
    }

//	public function attributeLabels() {
//		return array (
//
//				'id_user'=>'Id User',
//				'id_depositor' => 'Id Depositor',
//				'id_sample' => 'Id Sample',
//				'consent_ethical' => 'Consent Ethical',
//				'gender' => 'Gender',
//				'age' => 'Age',
//				'collect_date' => 'Collect Date',
//				'storage_conditions' => 'Storage Conditions',
//				'consent' => 'Consent',
//				'supply' => 'Supply',
//				'max_delay_delivery' => 'Max Delay Delivery',
//				'detail_treatment' => 'Detail Treatment',
//				'disease_outcome' => 'Disease Outcome',
//				'authentication_method' => 'Authentication Method',
//				'patient_birth_date' => 'Patient Birth Date',
//				'tumor_diagnosis' => 'Tumor Diagnosis',
//				'biobank_id' => 'Biobank',
//				'notes' => 'Notes',
//		);
//	}

    /**
     *
     * @return array customized attribute exported labels (name=>label)
     *         Used for export custom list of attributes into xls
     */
    public function attributeExportedLabels() {
        return array(
            'id_user' => 'Id User',
            'id_depositor' => 'Id Depositor',
            'id_sample' => 'Id Sample',
            'consent_ethical' => 'Consent Ethical',
            'gender' => 'Gender',
            'age' => 'Age',
            'collect_date' => 'Collect Date',
            'storage_conditions' => 'Storage Conditions',
            'consent' => 'Consent',
            'supply' => 'Supply',
            'max_delay_delivery' => 'Max Delay Delivery',
            'detail_treatment' => 'Detail Treatment',
            'disease_outcome' => 'Disease Outcome',
            'authentication_method' => 'Authentication Method',
            'patient_birth_date' => 'Patient Birth Date',
            'tumor_diagnosis' => 'Tumor Diagnosis',
            'biobank_id' => 'Biobank',
            'notes' => 'Notes',
                )
        ;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($caseSensitive = false) {
        return new EMongoDocumentDataProvider($this);
    }

    public function searchByUser($userId) {
        $criteria = new EMongoCriteria ();
        $criteria->id_user = $userId;
        $result = new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
        ));

        return $result;
    }

}