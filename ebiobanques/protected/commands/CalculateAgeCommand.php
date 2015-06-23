<?php

/**
 * Import de masse depuis json BIOCAP
 *
 */
class CalculateAgeCommand extends CConsoleCommand
{
    /*
     * TODO
     * IMPORTANT - Ajouter la validation du format (json)
     * OPTIONNEL - prévoir chargement de fichiers compressés
     * IMPORTANT - Déplacer le fichier apres succes import
     */

    public function run($args) {
        include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'CommonTools.php';
        $criteria = new EMongoCriteria;
        $criteria->select(array('DDN', 'Date_prlvt', 'age'));
        $samplesCollected = SampleCollected::model()->findAll($criteria);
        foreach ($samplesCollected as $sample) {
//            if (isset($sample->DDN) && isset($sample->Date_prlvt)) {
            if (isset($sample->DDN) && isset($sample->Date_prlvt) && !isset($sample->age)) {
                $sample->initSoftAttribute('age');
                $sample->age = (int) CommonTools::getAgeFromDates($sample->DDN, $sample->Date_prlvt);
                // echo "$sample->age : $sample->Date_prlvt-$sample->DDN \n";
                $sample->update(array('age'), true);
            }
        }
    }

}
?>