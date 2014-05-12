<?php

/**
 * Calcul des statistiques par biobanques pour le benchmarking.
 * Insertion des resultats dans la base de données
 *
 */
class CreateStatsCommand extends CConsoleCommand {

    public function run($args) {
        include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'StatTools.php';
        $biobanks = Biobank::model()->findAll(array('select' => array('id')));
        foreach ($biobanks as $biobank) {
            $result = StatTools::saveBiobankStats($biobank->id);
            $message = $result === true ?
                    "Statistiques de la biobanque n°$biobank->id bien calculées" :
                    "Une erreur est apparue lors de la sauvegarde des statistiques de la biobanque n°$biobank->id : $result";
            echo $message . "\n";
        }
        StatTools::saveAverageRate();
        echo "Statistiques globales enregistrées. \n";
    }

//    public function actionTest() {
//        include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'StatTools.php';
//        $date = new DateTime;
//        $searchDate = $date->format('Y-m-d');
//        $criteria = new EMongoCriteria;
//        $criteria->biobank_id = "0";
//        $criteria->date = new MongoRegex('/' . $searchDate . '.*/i');
//        $criteria->date = new MongoRegex("/$searchDate.*/i");
//        $globalStats = !empty(BiobankStats::model()->find($criteria)) && BiobankStats::model()->find($criteria) != null ?
//                BiobankStats::model()->find($criteria) : new BiobankStats();
//        echo "$globalStats->date\n$globalStats->biobank_id\n";
//    }
}
?>