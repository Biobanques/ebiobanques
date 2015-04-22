<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HarmonizeDataCommand
 *
 * @author nicolas
 */
class HarmonizeDataCommand extends CConsoleCommand
{

    public function run($args) {
        //uppar case for each last name of contact
        $criteria = new EMongoCriteria;
        $criteria->sort('last_name', EMongoCriteria::SORT_ASC);
        $contacts = Contact::model()->findAll($criteria);
        foreach ($contacts as $model) {
            //last name to upper case automatically /prevent pb to sort and display
            $model->last_name=strtoupper($model->last_name);
            $model->update();
        }
        }
    
}
