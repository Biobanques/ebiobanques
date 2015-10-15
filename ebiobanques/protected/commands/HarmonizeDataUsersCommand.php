<?php

/**
 * Description of HarmonizeDataUsers
 * command to harmonize users data old
 * @author nicolas
 */
class HarmonizeDataUsersCommand extends CConsoleCommand {

    public function run($args) {
        //upper case for each last name of contact
        $criteria = new EMongoCriteria;
        $criteria->sort('nom', EMongoCriteria::SORT_ASC);
        $users = User::model()->findAll($criteria);
        foreach ($users as $model) {
            $model->cleanAttributesFormat();
            //catch exception on update if problem ( utf8 encoding  for example?)
            try {
                $model->update();
            } catch (Exception $e) {
                echo 'Exception reçue pour le model: ' . $model->_id . " " . $model->nom . " " . $model->prenom, $e->getMessage(), "\n";
            }
        }
    }
}
