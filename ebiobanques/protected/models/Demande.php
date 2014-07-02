<?php

/**
 * This is the model class for table "Demande".
 *
 * The followings are the available columns in table 'Demande':
 * @property integer $id
 * @property integer $id_user
 * @property string $date_demande
 * @property string $detail
 * @property string $titre
 * @property integer $envoi
 *
 * The followings are the available model relations:
 * @property ConcernerEchantillon[] $concernerEchantillons
 * @property User $idUser
 */
class Demande extends EMongoDocument
{
    public $id_user;
    public $date_demande;
    public $detail;
    public $titre;
    public $envoi;
    public $sampleList;

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className
     *        	active record class name.
     * @return Demande the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     *
     * @return string the associated database table name
     */
    public function getCollectionName() {
        return 'Demande';
    }

    public function behaviors() {
        return array('embeddedArrays' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'sampleList', // name of property, that will be used as an array
                'arrayDocClassName' => 'EchDemande'  // class name of embedded documents in array
            ),
            'LoggableBehavior' =>
            'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(
                'id_user',
                'required'
            ),
// 				array (
// 						'id_user',
// 						// 'envoi',
// 						'numerical',
// 						'integerOnly' => true
// 				),
            array(
                'date_demande',
                'date',
                'format' => 'yyyy-M-d H:m:s'
            ),
            array(
                'titre',
                'length',
                'max' => 45
            ),
            array(
                'detail',
                'length',
                'max' => 2000
            ),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
                'id, id_user, date_demande,detail,titre,envoi,sampleList ',
                'safe',
                'on' => 'search'
            )
        );
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_user' => Yii::t('demande', 'id_user'),
            'date_demande' => Yii::t('demande', 'date_demande'),
            'detail' => Yii::t('demande', 'detail'),
            'nbEch' => Yii::t('demande', 'nbEch'),
            'details' => Yii::t('demande', 'details'),
            'titre' => Yii::t('demande', 'titre'),
            'envoi' => Yii::t('demande', 'id_user'),
            'sampleList' => Yii::t('demande', 'id_user'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($caseSensitive = false) {
        // // Warning: Please modify the following code to remove attributes that
        // // should not be searched.
        // $criteria = new CDbCriteria ();
        // $criteria->compare ( 'id', $this->id );
        // $criteria->compare ( 'id_user', $this->id_user );
        // $criteria->compare ( 'date_demande', $this->date_demande, true );
        // $criteria->compare ( 'detail', $this->detail, true );
        // $criteria->compare ( 'titre', $this->titre );
        // //$criteria->compare ( 'envoi', $this->envoi );
        // return new CActiveDataProvider ( $this, array (
        // 'criteria' => $criteria
        // ) );
        return new EMongoDocumentDataProvider($this);
    }

    public function searchForCurrentUser() {
        return $this->searchByUser(Yii::app()->user->id);
    }

    // Warning: Please modify the following code to remove attributes that
    // should not be searched.
    public function searchByUser($id) {
        $criteria = new EMongoCriteria ();

        // $criteria->compare ( 'id', $this->id );
        // $criteria->compare ( 'id_user', $this->id_user );
        // $criteria->compare ( 'date_demande', $this->date_demande, true );
        // $criteria->compare ( 'detail', $this->detail, true );
        // $criteria->compare ( 'titre', $this->titre );
        // $criteria->compare ( 'envoi', $this->envoi );
        $criteria->id_user = $id;
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function isActive() {
        if ($this->_id == Yii::app()->session ['activeDemand'] [0]->_id)
            return true;
        return false;
    }

    public function getShortContent() {
        $result = "";
        if ($this->detail != null) {
            if (strlen($this->detail) > 10) {
                $result = mb_substr($this->detail, 0, 10, 'UTF-8') . "...";
            } else {
                $result = $this->detail;
            }
        }
        return $result;
    }

    /**
     * SUrcharge la methode save pour actualiser la date de demande
     */
    public function saveWithCurrentDate() {
        $this->date_demande = date(CommonTools::MYSQL_DATE_FORMAT);
        return $this->save();
    }

    // public function countSamples() {
    // return ConcernerEchantillon::model ()->count ( 'demande_id =' . $this->id );
    // }
    public function getDateDemande() {
        if (Yii::app()->getLocale()->id == "fr") {
            return CommonTools::toDateFR($this->date_demande);
        } elseif (Yii::app()->getLocale()->id == "en") {
            return CommonTools::toDateEN($this->date_demande);
        }
    }

    public function setDateDemande($date) {
        $this->date_demande = CommonTools::toMysqlDate($date);
    }

    public function countSamples() {
        return sizeof($this->sampleList);
    }

    public function getSamples() {
        $samples = array();
        if ($this->sampleList != null) {
            foreach ($this->sampleList as $sampleDemand) {
                $samples [] = new MongoID($sampleDemand->id_sample);
            }
        }
        $dataProvider = Sample::model()->getSamplesFromArray($samples);
        return $dataProvider;
    }

    public function getArraySamples() {
        return $this->getSamples()->data;
    }

    public function getConcernedBiobanks() {
        $samples = $this->getArraySamples();
        return getBiobanksFromSamples($samples);
    }

    public function getBiobanksFromSamples($samples) {
        $biobankList = array();
        foreach ($samples as $sample) {
            $biobankList [] = $sample->biobank_id;
        }
        $biobankList = array_unique($biobankList);
        return $biobankList;
    }

}