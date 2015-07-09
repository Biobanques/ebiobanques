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

     */

    public function run($args) {
        $ImportFolder = CommonProperties::$IMPORTFOLDER;
        //increase memory limit on the fly  only for this command
        try {
            ini_set('memory_limit', '-1');
            $filesList = $this->getFiles();



            if (!empty($filesList)) {
                echo 'List of files found : ';
                print_r($filesList);
                /*
                 * Select the more recent file
                 */
                krsort($filesList);
                reset($filesList);
                /*
                 * parse json
                 */
                $extension = pathinfo($ImportFolder . $filesList[key($filesList)], PATHINFO_EXTENSION);
                if ($extension == 'zip') {
                    $zip = new ZipArchive();
                    if ($zip->open($ImportFolder . $filesList[key($filesList)])) {
                        $zip->extractTo($ImportFolder);
                        rename($ImportFolder . $filesList[key($filesList)], $ImportFolder . "Done/" . $filesList[key($filesList)]);
                    }
                    $filesList = $this->getFiles();
                    krsort($filesList);
                    reset($filesList);
                    $extension = pathinfo($ImportFolder . $filesList[key($filesList)], PATHINFO_EXTENSION);
                }
                if ($extension == 'json') {
                    $fileImported = file_get_contents($ImportFolder . $filesList[key($filesList)]);

                    $jsonFile = json_decode($fileImported, true);
                    if ($jsonFile != null) {
                        $dataKey = "";
                        $keys = array_keys($jsonFile);

                        /*
                         * Find SASTableData* index, where datas are stored
                         */
                        foreach ($keys as $key)
                            if (preg_match("/(SASTableData).*/i", $key)) {
                                echo "match $key \n";
                                $dataKey = $key;
                                break;
                            }
                        $arrayOfSample = $jsonFile[$dataKey];
                        /*
                         * Insert into database
                         */
                        $client = Yii::app()->mongodb->getConnection();
                        $db = Yii::app()->mongodb->dbName;
                        /*
                         * Drop collection if exists
                         */
                        if (in_array('sampleCollected', $client->$db->getCollectionNames())) {
                            $client->$db->selectCollection('sampleCollected')->drop();
                        }
                        /*
                         * Insert datas into collection, and move file if success
                         */
                        $client->$db->createCollection('sampleCollected');
                        if ($client->$db->sampleCollected->batchInsert($arrayOfSample)) {
                            echo count($arrayOfSample) . " were successfully imported from " . $filesList[key($filesList)] . "\n";

                            echo "Moving file...";
                            rename($ImportFolder . $filesList[key($filesList)], $ImportFolder . "Done/" . $filesList[key($filesList)]);
                            /*
                             * Perform age calculating from prelev_data and birthdate
                             */
                            echo 'Calculate age from dates...';
                            include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'CommonTools.php';
                            $criteria = new EMongoCriteria;
                            $criteria->select(array('DDN', 'Date_prlvt', 'age'));
                            $samplesCollected = SampleCollected::model()->findAll($criteria);
                            $count = 0;
                            foreach ($samplesCollected as $sample) {

                                if (isset($sample->DDN) && isset($sample->Date_prlvt) && !isset($sample->age)) {
                                    $sample->initSoftAttribute('age');
                                    $sample->age = (int) CommonTools::getAgeFromDates($sample->DDN, $sample->Date_prlvt);

                                    if ($sample->update(array('age'), true))
                                        $count++;
                                }
                            }
                            echo 'Age computed for ' . $count . ' items.' . "\n";
                        }else {
                            echo "error on insert, please check json file";
                            Yii::log("error on insert, please check json file", CLogger::LEVEL_WARNING);
                        }
                    } else
                        echo 'Error on jsdon decode';
                    Yii::log('Error on jsdon decode', CLogger::LEVEL_WARNING);
                }else {
                    echo $ImportFolder . $filesList[key($filesList)] . " n'est pas un fichier json.";
                    Yii::log($ImportFolder . $filesList[key($filesList)] . " n'est pas un fichier json.", CLogger::LEVEL_WARNING);
                }
            } else
                echo'No valid file detected';
            Yii::log('No valid file detected', CLogger::LEVEL_WARNING);

            /*
             *
             */
        } catch (Exception $ex) {
            Yii::log($ex->getTraceAsString(), CLogger::LEVEL_ERROR);
            echo " Une erreur s'est produite lors de l'import de données, consultez les logs pour plus de détails.";
        }
    }

    public function getFiles() {
        $ImportFolder = CommonProperties::$IMPORTFOLDER;
        $folder = opendir($ImportFolder);
        $filesList = array();
        /*
         * List folder files
         */
        $i = 0;
        while ($file = readdir($folder)) {
            if ($file != "." && $file != ".." && $file != "Done")
                $filesList[$i] = $file;
            $i++;
        }
        return $filesList;
    }

}
?>