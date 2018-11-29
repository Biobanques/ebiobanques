<?php

/**
 * Calcul des statistiques par biobanques pour le benchmarking.
 * Insertion des resultats dans la base de données
 *
 */
class UpdateIdBiobankAndUserEmptyCommand extends CConsoleCommand
{

    public function run($args) {
        
        $biobanks = Biobank::model()->findAll();
        $listIdBiobanks = array();
        foreach ($biobanks as $b) {
            if ($b->id != null || $b->id != "") {
                array_push($listIdBiobanks, $b->id);
            }
        }
        $indexBiobank = 1;
        foreach ($biobanks as $b) {
            if ($b->id == null || $b->id == "") {
                while (in_array($indexBiobank, $listIdBiobanks)) {
                    $indexBiobank++;
                }
                $b->id = $indexBiobank;
                array_push($listIdBiobanks, $indexBiobank);
                $b->save();
            }
        }
        
        $users = User::model()->findAll();
        $listIdUsers = array();
        foreach ($users as $u) {
            if ($u->id != null || $u->id != "") {
                array_push($listIdUsers, $u->id);
            }
        }
        $indexUser = 1;
        foreach ($users as $u) {
            if ($u->id == null || $u->id == "") {
                while (in_array($indexUser, $listIdUsers)) {
                    $indexUser++;
                }
                $u->id = $indexUser;
                array_push($listIdUsers, $indexUser);
                $u->save();
            }
        }
    }

}
?>