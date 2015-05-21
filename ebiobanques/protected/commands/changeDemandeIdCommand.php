<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class changeDemandeIdCommand extends CConsoleCommand
{

    public function run($args) {
        echo 'Run for demandes';
        $demandes = Demande::model()->findAll();

        foreach ($demandes as $demande) {
            if ($demande->id_user != null) {
                if (is_a($demande->id_user, "MongoId")) {
                    $user = User::model()->findByPk($demande->id_user);
                    if ($user != null && $user != "") {
                        $demande->id_user = (string) $user->_id;
                        $demande->update();
                    }
                } else {
                    $user = User::model()->findByAttributes(array('id' => $demande->id_user));
                    if ($user != null && $user != "") {
                        $demande->id_user = (string) $user->_id;
                        $demande->update();
                    }
                    $user = User::model()->findByAttributes(array('_id' => $demande->id_user));
                    if ($user != null && $user != "") {
                        $demande->id_user = (string) $user->_id;
                        $demande->update();
                    }
                }
            }
        }
    }

}