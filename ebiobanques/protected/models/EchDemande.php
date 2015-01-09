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
class EchDemande extends EMongoEmbeddedDocument {

    public $id_sample;
    public $quantity;

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array(
                'id_sample',
                'required'
        ));
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_sample' => 'Id echantillon',
            'quantity' => 'Quantité',
        );
    }

}
