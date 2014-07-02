<?php

/**
 * This is the model class for table "mail_queue".
 *
 * The followings are the available columns in table 'mail_queue':
 *
 */
class mailqueue extends LoggableActiveRecord
{
	
	public $emailto;
	public $subject;
	public $body;
	public $headers;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return categorie the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function getCollectionName()
	{
		return 'mail_queue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('emailto,subject,body,headers', 'required'),
			array('emailto', 'length', 'max'=>255),
			array('subject', 'length', 'max'=>500),
			array('body', 'length', 'max'=>5000),
			array('headers', 'length', 'max'=>500),
			array('id, emailto', 'safe', 'on'=>'search'),
		);
	}



	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'_id' => 'ID',
			'emailto' => 'To',
			'subject' => 'Subject',
			'body' => 'Body',
			'headers' => 'Headers',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($caseSensitive=false)
	{

		$criteria=new EMongoCriteria;
		$criteria->_id=$this->_id;
		return new EMongoDocumentDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}