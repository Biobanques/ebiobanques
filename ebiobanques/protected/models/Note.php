<?php

/**
 * classe embarquée Note, définit les objets Notes dans les echantillons
 * @author matthieu
 *
 */
class Note extends EMongoEmbeddedDocument {
	public $key;
	public $value;
	


	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array (
				array (
						'key',
						'required'
				));
	}		


	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
				'key' => 'Clé',
				'value' => 'valeur',
		);
	}

}