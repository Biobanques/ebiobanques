<?php

/**
 * CatalogForm class.
 */
class CatalogForm extends CFormModel
{
	public $keywords;
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('keywords', 'length', 'max'=>400),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'keywords'=>Yii::t('common','keywords'),
		);
	}
}