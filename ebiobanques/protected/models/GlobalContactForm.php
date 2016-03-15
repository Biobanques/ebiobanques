<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GlobalContactForm extends CFormModel
{
    public $biobank_id;
    public $last_name;
    public $ville;
    public $pays;
    public $profils;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
                // array('','required')
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
        );
    }

}