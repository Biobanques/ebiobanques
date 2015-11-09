<?php

/**
 *
 * TODO declarere mieux les proprietes de recherche pour eviter dans les logs les usafe attribute
 * NB : Les champs sont stockés sous la form e destring, même pour le svaleurs numériques.
 * L'affectation d'uen valeur numérique pour la recherche peut entrainer des surprises, convertir le svaleurs numériques via strval() pemret d 'eviter certains écueils.
 *
 * @author nicolas
 *
 */
class SampleCollected extends LoggableActiveRecord
{

    public function afterConstruct() {


        foreach ($this->getKeys() as $key) {

            $this::initSoftAttribute($key);
        }
        parent::afterConstruct();
    }

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
        $rules = array();
        if ($this->scenario == 'insert' || $this->scenario == 'update') {
            foreach ($this->attributes as $name => $value)
                $rules[] = array((string) $name, 'safe');
        }
        return $rules;
    }

    public function attributeLabels() {

        return array(
            'age' => 'Age',
            'diagPpal' => 'Diagnostic principal'
        );
    }

    public function attributeExportedLabels() {
        return array(
            'age' => 'Age',
            'diagPpal' => 'Diagnostic principal'
        );
    }

    public function search($caseSensitive = false) {
        $criteria = new EMongoCriteria ();
        foreach ($this->getSoftAttributeNames() as $key) {
            $value = $this->$key;
            if ($value != '' && $value != null)
                $criteria->addCond($key, "==", new MongoRegex("/" . StringUtils::accentToRegex($this->$key) . "/i"));
        }
        Yii::app()->session['criteria'] = $criteria;
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('attributes' => $this->attributeNames())
        ));
    }

    public function getGroupList() {
        $values = $this->getCollection()->distinct(CommonTools::AGGREGATEDFIELD1);

        //natcasesort($values);
        $partialResult = array();
        $result = array();



        foreach ($values as $value)
            if ($value != "") {
                $romanNumber = explode(".", $value)[0];
                $index = $romanNumber - 1;
//                $index = CommonTools::toNumber($romanNumber) - 1;
                $partialResult[$index] = $value;
            }
        ksort($partialResult);
        foreach ($partialResult as $res) {
            $result[$res] = $res;
        }
        return $result;
    }

    public function getDiagPpal() {
        return "$this->CommonTools::AGGREGATEDFIELD1 - $this->CommonTools::AGGREGATEDFIELD2";
    }

    public function getKeys() {

        return array_keys($this->find()->getAttributes());
    }

    public function getCimoTopoList() {
        $values = $this->getCollection()->distinct('RNCE_LibelleTopo');
        natcasesort($values);
        $result = array();
        foreach ($values as $res) {
            if ($res != '')
                $result[$res] = $res;
        }

        return $result;
    }

    public function getCimoMorphoList() {
        $values = $this->getCollection()->distinct('RNCE_Intitule_CIMO');
        natcasesort($values);
        $result = array();
        foreach ($values as $res) {
            if ($res != '')
                $result[$res] = $res;
        }

        return $result;
    }

}
?>
