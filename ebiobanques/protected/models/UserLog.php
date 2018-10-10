<?php

/**
 * Object to store basic user
 * @author nmalservet
 *
 */
class UserLog extends EMongoDocument
{
    public $username;
    public $email;
    public $profil;
    public $biobank_name;
    public $biobank_id;
    public $connectionDate;


    // This has to be defined in every model, this is same as with standard Yii ActiveRecord
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    // This method is required!
    public function getCollectionName()
    {
        return 'userLog';
    }

    public function rules()
    {
        $result = array(
            array('username, email, profil, connectionDate', 'required'),
            array('username, email, profil, biobank_name, biobank_id, connectionDate', 'safe', 'on' => 'search, update')
        );
        return $result;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'username' => Yii::t('common', 'Login'),
            'email' => Yii::t('common', 'email'),
            'profil' => Yii::t('common', 'profil'),
            'biobank_name' => Yii::t('common', 'biobank.name'),
            'biobank_id' => Yii::t('common', 'biobank.identifier'),
            'connectionDate' => 'Dernière connexion'
        );
    }

    public function search($caseSensitive = false)
    {
        $criteria = new EMongoCriteria;
        if (isset($this->username) && !empty($this->username)) {
            $criteria->addCond('username', '==', new MongoRegex('/' . $this->username . '/i'));
        }
        if (isset($this->email) && !empty($this->email)) {
            $criteria->addCond('email', '==', new MongoRegex('/' . $this->email . '/i'));
        }
        if (isset($this->biobank_name) && !empty($this->biobank_name)) {
            $criteria->addCond('biobank_name', '==', new MongoRegex('/' . $this->biobank_name . '/i'));
        }
        if (isset($this->biobank_id) && !empty($this->biobank_id)) {
            $criteria->addCond('biobank_id', '==', new MongoRegex('/' . $this->biobank_id . '/i'));
        }
        if (isset($_GET['connectionDate_from']) && !empty($_GET['connectionDate_from']) && isset($_GET['connectionDate_to']) && !empty($_GET['connectionDate_to'])) {
            $criteria->connectionDate = array('$gte' => date('Y-m-d', strtotime($_GET['connectionDate_from'])) . " 00:00:00.000000", '$lte' => date('Y-m-d', strtotime($_GET['connectionDate_to'])) . " 23:59:59.000000");
        }
        Yii::app()->session['criteria'] = $criteria;
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'connectionDate DESC',
            )
        ));
    }
    
    /**
     * get the last connection date into a french date format JJ/MM/AAAA
     * @return type
     */
    public function getConnectionDate() {
        if ($this->connectionDate != null) {
            return date('d/m/Y H:i', strtotime($this->connectionDate));
        } else {
            return null;
        }
    }
    
    public function getProfil($profil) {
        $user = User::model()->getArrayProfil();
        return $user[$profil];
    }
    
}