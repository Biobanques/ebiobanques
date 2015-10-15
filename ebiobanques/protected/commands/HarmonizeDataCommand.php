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
class HarmonizeDataCommand extends CConsoleCommand {

    public function run($args) {
        //uppar case for each last name of contact
        $criteria = new EMongoCriteria;
        $criteria->sort('last_name', EMongoCriteria::SORT_ASC);
        $contacts = Contact::model()->findAll($criteria);
        foreach ($contacts as $model) {
            //last name to upper case automatically /prevent pb to sort and display
            // echo $model->_id."\n";
            $model->last_name = mb_strtoupper($model->last_name, "UTF-8");
            //convertie first name en lower case et mettant les caracteres en utf-8 ( cas possible de bug sur chaines mixtes)
            $model->first_name = mb_strtolower($model->first_name, "UTF-8");
            //phone without withespace, point a 0> +33
            $model->phone = mb_ereg_replace('/\s+/', '', $model->phone);
            $model->phone = mb_ereg_replace('/\./', '', $model->phone);
            //replace first zero and add +33
            $model->phone = mb_ereg_replace('/^0/', '+33', $model->phone);
            //pays = FR
            $model->pays = "FR";
            $model->inactive = 0;
            //catch exception on update if problem ( utf8 encoding  for example?)
            try {
                $model->update();
            } catch (Exception $e) {
                echo 'Exception reçue pour le model: ' . $model->_id . " " . $model->last_name . " " . $model->first_name, $e->getMessage(), "\n";
                //detection de le ncodage si pb d estring
                echo "first name encoding :" . mb_detect_encoding($model->first_name) . "\n";
            }
        }
        //update relation biobank->contact_id if old id contact, si ancien attribut id utilisé alors on mets le nouvel attribut _id
        $criteriaB = new EMongoCriteria;
        $criteriaB->sort('name', EMongoCriteria::SORT_ASC);
        $biobanks = Biobank::model()->findAll($criteriaB);
        foreach ($biobanks as $biobank) {
            $contact=Contact::model()->findByAttributes(array('id' => $biobank->contact_id));
            if ($contact != null){
               // echo "current value from migration:" . $contact->last_name . " " . $contact->first_name."\n";
                $biobank->contact_id=$contact->_id;
                $biobank->update();
            }
        }
    }

}
