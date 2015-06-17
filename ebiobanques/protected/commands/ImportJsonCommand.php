<?php

/**
 * Import de masse depuis json BIOCAP
 *
 */
class ImportJsonCommand extends CConsoleCommand
{
    /*
     * TODO
     * IMPORTANT - Ajouter la validation du format (json)
     * OPTIONNEL - prévoir chargement de fichiers compressés
     * IMPORTANT - Déplacer le fichier apres succes import
     */

    public function run($args) {
        $ImportFolder = CommonProperties::$IMPORTFOLDER;
        $folder = opendir($ImportFolder);
        /*
         * List folder files
         */
        while ($file = readdir($folder)) {
            if ($file != "." && $file != "..")
                $filesList[filectime($ImportFolder . $file)] = $file;
        }
        if (!empty($filesList)) {
            /*
             * Select the more recent file
             */
            krsort($filesList);
            reset($filesList);
            /*
             * parse json
             */
            $fileImported = file_get_contents($ImportFolder . $filesList[key($filesList)]);

            $jsonFile = json_decode($fileImported, true);
            $arrayOfSample = $jsonFile['SASTableData+IMPORT_TOTAL_IDF_ECH'];
            /*
             * Insert into database
             */
            $client = Yii::app()->mongodb->getConnection();
            $db = Yii::app()->mongodb->dbName;

            $client->$db->createCollection('sampleCollected');

//        foreach ($arrayOfSample as $sample)
//            $client->biocap->createCollection('sampleCollected')->insert($sample);
            $client->$db->sampleCollected->batchInsert($arrayOfSample);
            echo count($arrayOfSample) . " were successfully imported from " . $filesList[key($filesList)] . "\n";
        } else
            echo'No valid file detected';
    }

}
?>