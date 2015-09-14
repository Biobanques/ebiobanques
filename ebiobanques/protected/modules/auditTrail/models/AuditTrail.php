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
    // public $id;
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
            array('new_value, old_value, action, model, field, stamp, user_id, model_id', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
            'action' => 'Action',
            'model' => 'Model',
            'field' => 'Field',
            'stamp' => 'Stamp',
            'user_id' => 'User',
            'model_id' => 'Model',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($options = array()) {
        $criteria = new EMongoCriteria;
        foreach ($this->attributes as $attrName => $attrValue) {
            if ($attrValue != null && $attrValue != "") {
                $criteria->addCond($attrName, '==', new MongoRegex("/" . StringUtils::accentToRegex($attrValue) . "/i"));
            }
        }

        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('attributes' => array(
                    'old_value',
                    'new_value',
                    'action',
                    'model',
                    'field',
                    'stamp',
                    'user_id',
                    'model_id',
                ))
        ));
    }

    public function scopes() {
        return array(
            'recently' => array(
                'order' => ' t.stamp DESC ',
            ),
        );
    }

}