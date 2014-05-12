<?php

/**
 * This is the model class for table "AdvancedSearchLog".
 *
 * The followings are the available columns in table 'AdvancedSearchLog':
 * @property integer $id
 * @property integer $id_user
 * @property string $search_date
 * @property string $content
 */
class AdvancedSearchLog extends LoggableActiveRecord {
	public $id;
	public $id_user;
	public $search_date;
	public $content;
	
	/**
	 * Returns the static model of the specified AR class.
	 * 
	 * @param string $className
	 *        	active record class name.
	 * @return AdvancedSearchLog the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	
	/**
	 *
	 * @return string the associated database table name
	 */
	public function getCollectionName() {
		return 'advancedSearchLog';
	}

	
	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array (
				array ('id_user,search_date,content', 'required' 
				),
				array ('id','numerical', 'integerOnly' => true 
				),
				
				array (
						'search_date',
						'safe' 
				),
				
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array (
'id_user,search_date,content' ,						
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
		return array (
				'id'=>'Id',
				'id_user'=>'Id User',
				'search_date' => 'Date de recherche',
				'content' => 'contenu de la recherche',
				
		);
	}
	
	/**
	 *
	 * @return array customized attribute exported labels (name=>label)
	 *         Used for export custom list of attributes into xls
	 */
	public function attributeExportedLabels() {
		return array (
				'id'=>'Id',
				'id_user'=>'Id User',
				'search_date' => 'Date de recherche',
				'content' => 'contenu de la recherche',
		)
		;
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * 
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($caseSensitive = false) {

		return new EMongoDocumentDataProvider ( $this );
	}
	
}