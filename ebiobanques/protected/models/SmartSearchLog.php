<?php

/**
 * This is the model class for table "SmartSearchLog".
 *
 * The followings are the available columns in table 'SmartSearchLog':
 * @property integer $id
 * @property integer $id_user
 * @property string $search_date
 * @property string $content
 */
class SmartSearchLog extends LoggableActiveRecord {
	public $id;
	public $id_user;
	public $search_date;
	public $content;
	
	/**
	 * Returns the static model of the specified AR class.
	 * 
	 * @param string $className
	 *        	active record class name.
	 * @return SmartSearchLog the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	
	/**
	 *
	 * @return string the associated database table name
	 */
	public function getCollectionName() {
		return 'SmartSearchLog';
	}

	
	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array (
				array ('id_user,content', 'required' 
				),
				array ('id', 'numerical', 'integerOnly' => true 
				),
				
				array (
						'search_date',
						'safe' 
				),
				
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array (
'id,id_user,search_date,content' ,						
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
		$criteria = new CDbCriteria ();

		$criteria->compare ( 'id', $this->id );
		$criteria->compare ( 'id_user', $this->id_user );
		$criteria->compare ( 'search_date', $this->search_date, true );
		$criteria->compare ( 'content', $this->content, true );
		
		
		return new CActiveDataProvider ( $this, array (
				'criteria' => $criteria 
		) );
	}
	public function searchByUser($userId) {
		$criteria = new CDbCriteria ();

		$criteria->compare ( 'id', $this->id );
		$criteria->compare ( 'id_user', $this->id_user );
		$criteria->compare ( 'search_date', $this->search_date, true );
		$criteria->compare ( 'content', $this->content, true );
	
		$criteria->addCondition('id_user='.$userId);
		$result=new CActiveDataProvider ( $this, array (
				'criteria' => $criteria
		)  );

		return $result;
	}
}