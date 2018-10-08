<?php

/**
 * This is the model class for table "tbl_audit_trail".
 */
class AuditTrail extends EMongoDocument
{
    /**
     * The followings are the available columns in table 'tbl_audit_trail':
     * @var integer $id
     * @var string $new_value
     * @var string $old_value
     * @var string $action
     * @var string $model
     * @var string $field
     * @var string $stamp
     * @var integer $user_id
     * @var string $model_id
     */
    public $id;
    public $new_value;
    public $old_value;
    public $action;
    public $model;
    public $field;
    public $stamp;
    public $user_id;
    public $model_id;

    /**
     * Returns the static model of the specified AR class.
     * @return AuditTrail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function getCollectionName() {
        return 'tbl_audit_trail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('action, model, field, stamp, model_id', 'required'),
            array('action', 'length', 'max' => 255),
            array('model', 'length', 'max' => 255),
            array('field', 'length', 'max' => 255),
            array('model_id', 'length', 'max' => 255),
            array('user_id', 'length', 'max' => 255),
            array('id, new_value, old_value, action, model, field, stamp, user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'old_value' => Yii::t('auditTrail', 'old_value'),
            'new_value' => Yii::t('auditTrail', 'new_value'),
            'action' => Yii::t('auditTrail', 'action'),
            'model' => Yii::t('auditTrail', 'model'),
            'field' => Yii::t('auditTrail', 'field'),
            'stamp' => Yii::t('auditTrail', 'stamp'),
            'user_id' => Yii::t('auditTrail', 'user_id')
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($options = array()) {
        $criteria = new EMongoCriteria;
        if (isset($this->old_value) && !empty($this->old_value)) {
            $regex = '/' . $this->old_value . '/i';
            $criteria->addCond('old_value', '==', new MongoRegex($regex));
        }
        if (isset($this->new_value) && !empty($this->new_value)) {
            $regex = '/' . $this->new_value . '/i';
            $criteria->addCond('new_value', '==', new MongoRegex($regex));
        }
        if (isset($this->model) && !empty($this->model)) {
            $regex = '/' . $this->model . '/i';
            $criteria->addCond('model', '==', new MongoRegex($regex));
        }
        if (isset($this->field) && !empty($this->field)) {
            $regex = '/' . $this->field . '/i';
            $criteria->addCond('field', '==', new MongoRegex($regex));
        }
        if (isset($this->action) && !empty($this->action)) {
            $criteria->addCond('action', '==', new MongoRegex('/' . $this->action . '/i'));
        }
        if (isset($_GET['stamp_from']) && !empty($_GET['stamp_from']) && isset($_GET['stamp_to']) && !empty($_GET['stamp_to'])) {
            $criteria->stamp = array('$gte' => date('Y-m-d', strtotime($_GET['stamp_from'])) . " 00:00:00.000000", '$lte' => date('Y-m-d', strtotime($_GET['stamp_to'])) . " 23:59:59.000000");
        }
        if (isset($_GET['nom']) || isset($_GET['prenom'])) {
            $criteriaUser = new EMongoCriteria;
            if (!empty($_GET['nom'])) {
                $criteriaUser->nom = $_GET['nom'];
            }
            if (!empty($_GET['prenom'])) {
                $criteriaUser->prenom = $_GET['prenom'];
            }
            $criteriaUser->select(array('_id'));
            $users = User::model()->findAll($criteriaUser);
            $listUsers = array();
            if ($users != null) {
                foreach ($users as $user) {
                    $listUsers[] = $user->_id;
                }
            }
            $criteria->addCond('user_id', 'in', $listUsers);
        }
        $criteria->sort('stamp', EMongoCriteria::SORT_DESC);
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function scopes() {
        return array(
            'recently' => array(
                'order' => ' t.stamp DESC ',
            ),
        );
    }
    
    /**
     * get actions.
     */
    public function getActions() {
        $res = array();
        $res ['CREATE'] = "CREATE";
        $res ['SET'] = "SET";
        $res ['CHANGE'] = "CHANGE";
        $res ['DELETE'] = "DELETE";
        return $res;
    }
    
    /**
     * get the timestamp into a french date format JJ/MM/AAAA
     * @return type
     */
    public function getTimestamp() {
        if ($this->stamp != null)
            return date('d/m/Y H:i:s', strtotime($this->stamp));
        else
            return null;
    }
    
    public function getNewValue() {
        if (!is_array($this->new_value)) {
            return $this->new_value;
        } else {
            return "N/A";
        }
    }

}