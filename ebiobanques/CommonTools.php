<?php

/**
 * class of Common tools to use in all functions.
 * can agregate some common constants.
 * @author nicolas malservet
 * @since version 0.1
 */
class CommonTools
{
    /*
     * FORMAT DATE
     */
    const MYSQL_DATE_FORMAT = "Y-m-d H:i:s";
    const MYSQL_DATE_DAY_FORMAT = "Y-m-d 00:00:00";
    const FRENCH_DATE_FORMAT = "H:i:s d/m/Y";
    const FRENCH_SHORT_DATE_FORMAT = "d/m/Y";
    const ENGLISH_SHORT_DATE_FORMAT = "Y-m-d";
    const FRENCH_HD_DATE_FORMAT = "d/m/Y H:i";
    const ENGLISH_HD_DATE_FORMAT = "Y-m-d H:i";
    const HOUR_DATE_FORMAT = "H:i";
    const AGGREGATEDFIELD1 = "RNCE_Lib3_GroupeICCC";
    const AGGREGATEDFIELD2 = "RNCE_Lib3_SousGroupeICCC";

    /*
     * limit number of lines for excel export to prevent memory issue
     */
    const XLS_EXPORT_NB = 500;

    /**
     * get if the server is in dev mode.
     * @return boolean
     */
    public static function isInDevMode() {
        return CommonProperties::$DEV_MODE;
    }

    /**
     * translate a mysql date to en franch format dd/mm/yyyy
     * @param unknown $madate
     */
    public static function toShortDateFR($madate) {
        return CommonTools::toDate(CommonTools::FRENCH_SHORT_DATE_FORMAT, $madate);
    }

    /**
     * translate a mysql date to en english date short format yyyy-mm-dd.
     * @param type $madate
     * @return type
     */
    public static function toShortDateEN($madate) {
        return CommonTools::toDate(CommonTools::ENGLISH_SHORT_DATE_FORMAT, $madate);
    }

    /**
     * translate a mysql date format into a french long format dd/mm/yyyy hh:mm
     * @param unknown $madate
     */
    public static function toDateFR($madate) {
        return CommonTools::toDate(CommonTools::FRENCH_HD_DATE_FORMAT, $madate);
    }

    public static function toDateEN($madate) {
        return CommonTools::toDate(CommonTools::ENGLISH_HD_DATE_FORMAT, $madate);
    }

    /**
     * method to encapsulate controls on date translation, null, empty
     * @param type $format
     * @param type $mydate
     * @return type
     */
    public static function toDate($format, $mydate) {
        $result = "";
        if ($mydate != "") {
            $result = date($format, strtotime($mydate));
        }
        return $result;
    }

    /**
     *
     *
     * Transforme un fichier binaire dans le format mime indiqué.
     * @param type $bin
     * @param type $mime
     * @return string
     */
    public static function data_uri($bin, $mime) {
        $base64 = base64_encode($bin);
        return ('data:' . $mime . ';base64,' . $base64);
    }

    /**
     * FIXME fonction etrange retour bizarre, action de controller melangée
     * @return type
     */
    public static function getBiobankInfo() {
        $id = $_SESSION['biobank_id'];
        $biobank = Biobank::getBiobank($id);
        if ($biobank != null) {
            if (isset($biobank->logo) && $biobank->logo != null) {
                $logo = ($biobank->logo);
                $_SESSION['vitrine'] = array('biobank' => $biobank, 'biobankLogo' => $logo);
            }
            return $id;
        } else {
            Yii::app()->user->setFlash('error', yii::t('common', 'noBiobankFound'));
            //Yii::app()->controller->redirect(Yii::app()->createUrl('site/biobanks'));
        }
    }

    public static function importFile($file, $add) {
        $error = 0;

        $biobank_id = $file->metadata['biobank_id'];
        $file_imported_id = $file->_id;
        $bytes = CommonTools::toCsv($file);
        $error = CommonTools::analyzeCsv($bytes, $biobank_id, $file_imported_id, $add);



        if ($error == 0)
            Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success') . '<br>All samples where successfully imported');
        else {
            Yii::app()->user->setFlash('notice', Yii::app()->user->getFlash('success') . "<br>$error elements were not correctly imported. Please ask admin for more details");
            Yii::app()->user->setFlash('success', null);
        }
    }

    public static function toCsv($file) {
        $splitted = explode(".", $file->filename);
        $extension = end($splitted);
        switch ($extension) {
            case 'csv':
                return $file->getBytes();
            case 'xls':
                return CommonTools::xlsToCsv($file, 'Excel5');
            case 'xlsx':
                return CommonTools::xlsToCsv($file, 'Excel2007');
            default:

                Yii::app()->user->setFlash('error', "bad extension :$extension , $file->filename");
        }
        return null;
    }

    public static function xlsToCsv($file, $excelFormat) {
        $result = 0;
        require_once 'protected/extensions/ExcelExt/PHPExcel.php';
        $path = Yii::app()->basePath . "/runtime/tmp_files/temp_$file->filename";
        /*
         * Création du fichier sur le disque
         */
        $fres = $file->write($path);
        $reader = PHPExcel_IOFactory::createReader($excelFormat);
        /*
         * Chargement par phpExcel
         */
        $excel = $reader->load($path);
        /*
         * Ecriture en .csv
         */
        $writer = PHPExcel_IOFactory::createWriter($excel, 'CSV');
        $writer->save("$path.csv");
        /*
         * Récupération du csv
         */
        $result = file_get_contents("$path.csv");
        /*
         * Suppression des fichiers temporaires
         */
        unlink($path);
        unlink("$path.csv");
        return $result;
    }

    protected static function analyzeCsv($bytes, $biobank_id, $fileImportedId, $add) {

        $import = fopen(CommonTools::data_uri($bytes, 'text/csv'), 'r');
        $row = 1;
        $keysArray = array();
        $listBadSamples = array();
        $newSamples = array();
        /**
         * Version 1 : Les champs non repertorés sont ajoutés en notes
         */
        while (($data = fgetcsv($import, 1000, ",")) !== FALSE) {
            /*
             * Traitement de la ligne d'entete
             */
            if ($row == 1) {
                foreach ($data as $key => $value) {
                    if ($value != null && $value != "")
                        $keysArray[$key] = $value;
                }
            } else {
                $model = new Sample();
                $model->disableBehavior('LoggableBehavior');
                $model->biobank_id = $biobank_id;
                $model->file_imported_id = $fileImportedId;

                foreach ($keysArray as $key2 => $value2) {
                    if (in_array($value2, Sample::model()->attributeNames())) {

                        $model->$value2 = $data[$key2];
                        if (!$model->validate($value2)) {

                            Yii::log("Problem with item" . $model->getAttributeLabel($value2) . ",set to null.", CLogger::LEVEL_ERROR);
                            $model->$value2 = null;
                        }
                    } else {


                        $note = new Note();
                        $note->key = $value2;
                        $note->value = $data[$key2];
                        $model->notes[] = $note;
                    }
                }

                if (!$model->save()) {
                    $listBadSamples[] = $row;
                } else {
                    $newSamples[] = $model->_id;
                }
            }
            $row++;
        }

        /*
         * Version 2 : seuls nes champs dont la colonne est annotée avec le préfixe 'notes' sont pris en note
         */


//        while (($data = fgetcsv($import, 1000, ",")) !== FALSE) {
//
//            /*
//             * Traitement de la ligne d'entete
//             */
//
//
//
//            if ($row == 1) {
//                foreach ($data as $key => $value) {
//                    if (in_array($value, Sample::model()->attributeNames())) {
//                        $keysArray[$key] = $value;
//                    } elseif (substr($value, 0, 5) == 'notes') {
//                        $keysArray[$key] = $value;
//                    }
//                }
//                /*
//                 * Traitement des lignes de données
//                 */
//            } else {
//                $model = new Sample();
//                $model->disableBehavior('LoggableBehavior');
//                $model->biobank_id = $biobank_id;
//                $model->file_imported_id = $fileImportedId;
//                foreach ($keysArray as $key2 => $value2) {
//                    if (substr($value2, 0, 5) != 'notes') {
//
//                        $model->$value2 = $data[$key2];
//                        if (!$model->validate($value2)) {
//
//                            Yii::log("Problem with item" . $model->getAttributeLabel($value2) . ",set to null.", CLogger::LEVEL_ERROR);
//                            $model->$value2 = null;
//                        }
//                    } else {
//
//                        $noteKey = end(explode(':', $value2));
//                        $note = new Note();
//                        $note->key = $noteKey;
//                        $note->value = $data[$key2];
//                        $model->notes[] = $note;
//                    }
//                }
//
//                if (!$model->save()) {
//                    $listBadSamples[] = $row;
//                } else {
//                    $newSamples[] = $model->_id;
//                }
//            }
//            $row++;
//        }


        fclose($import);
        if (!$add && count($newSamples) > 0) {
            $deleteCriteria = new EMongoCriteria();
            $deleteCriteria->biobank_id('==', $biobank_id);
            $deleteCriteria->_id('notIn', $newSamples);
            Sample::model()->deleteAll($deleteCriteria);
        }
        if (count($listBadSamples) != 0) {
            $log = '';
            foreach ($listBadSamples as $badSample) {
                $log = 'Error with manual import. File id : ' . $fileImportedId . ' - line : ' . $badSample;
                Yii::log($log, CLogger::LEVEL_ERROR);
            }
        }return count($listBadSamples);
    }

    public static function getIntPhone($phone) {
        //  echo "$phone - ";
        $phone = str_replace(" ", "", $phone);
        //echo "$phone - ";
        $phone = str_replace(".", "", $phone);
        //echo "$phone - ";
        $phone = str_replace("-", "", $phone);
        //echo "$phone - ";
        $phone = str_replace("/", "", $phone);
        //echo "$phone - ";
        $phone = substr_replace($phone, "+33", 0, 1);
        //echo "$phone - ";
        $phone = mb_strcut($phone, 0, 12);
        return $phone;
    }

    public static function getSoftwareList() {
        $listSoftware = array(
            'cresalys',
            'msaccess',
            'filemaker',
            'excel',
            'tumorotek',
            'databiotec',
            'tdbiobank',
            'mbiolims'
        );
        foreach ($listSoftware as $software)
            $result[$software] = $software;
        return $result;
    }

    public static function getShortValue($initialValue) {
        if (is_string($initialValue) && mb_strlen($initialValue) >= 75) {
            return mb_substr($initialValue, 0, 75) . '...';
        } else
            return $initialValue;
    }

    public static function getAgeFromDates($date0, $date1) {
        $date_0 = date_create_from_format(CommonTools::FRENCH_SHORT_DATE_FORMAT, $date0);
        //    $d0 = new DateTime($date_0);
        $date_1 = date_create_from_format(CommonTools::FRENCH_SHORT_DATE_FORMAT, $date1);
        //  $d1 = new DateTime($date_1);

        if ($date_0 != null && $date_1 != null) {


            $diff = $date_0->diff($date_1);
            return $diff->y;
        }
        return null;
    }

    function toNumber($roman) {
        $conv = array(
            array("letter" => 'I', "number" => 1),
            array("letter" => 'V', "number" => 5),
            array("letter" => 'X', "number" => 10),
            array("letter" => 'L', "number" => 50),
            array("letter" => 'C', "number" => 100),
            array("letter" => 'D', "number" => 500),
            array("letter" => 'M', "number" => 1000),
            array("letter" => 0, "number" => 0)
        );
        $arabic = 0;
        $state = 0;
        $sidx = 0;
        $len = strlen($roman) - 1;

        while ($len >= 0) {
            $i = 0;
            $sidx = $len;

            while ($conv[$i]['number'] > 0) {
                if (strtoupper($roman[$sidx]) == $conv[$i]['letter']) {
                    if ($state > $conv[$i]['number']) {
                        $arabic -= $conv[$i]['number'];
                    } else {
                        $arabic += $conv[$i]['number'];
                        $state = $conv[$i]['number'];
                    }
                }
                $i++;
            }

            $len--;
        }

        return($arabic);
    }

}