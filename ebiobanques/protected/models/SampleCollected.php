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
class SampleCollected extends LoggableActiveRecord
{

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

// This method is required!
    public function getCollectionName() {
        return 'sampleCollected';
    }

    public function behaviors() {
        return array(
            'LoggableBehavior' =>
            'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

    public function rules() {
        return array(
        );
    }

    public function attributeLabels() {

        return array(
        );
    }

    public function attributeExportedLabels() {

        return array(
        );
    }

    public function search($caseSensitive = false) {
        $criteria = new EMongoCriteria ();

        Yii::app()->session['criteria'] = $criteria;
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

}
?>
