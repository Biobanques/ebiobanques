<?php

require_once 'protected/extensions/ExcelExt/PHPExcel/Reader/IReadFilter.php';

class MyReadFilter implements PHPExcel_Reader_IReadFilter
{

    public function readCell($column, $row, $worksheetName = '') {
        // Read title row and rows 20 - 30
        if ($row == 1 || ($row >= 0 && $row <= 10)) {
            return true;
        }

        return false;
    }

}

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

    public static function getConnectedUser() {
        return User::model()->findByPk(Yii::app()->user->id);
    }

    public static function getPreferences() {

        $user = CommonTools::getConnectedUser();
        $user->disableBehavior('LoggableBehavior');
        $result = $user->preferences;
        $user->save();
        return $result;
    }

    public function getPhoneRegex() {
        $regexArray = array(
            'fr' => array('regex' => '#^\+33[0-9]{9}$#', 'readable' => '+33 123456789'),
                // 'en' => array('regex' => '#^\+33[0-9]{9}$#', 'readable' => '+33 123456789'),
        );
        return $regexArray;
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
        $resultAnalyse = CommonTools::analyzeCsv($bytes, $biobank_id, $file_imported_id, $add);
        $error = $resultAnalyse['error'];
        if ($resultAnalyse['inserted'] > 0) {
            $added = CommonTools::addToImportedFiles($file);
            if ($added == true)
                Yii::log('ExcelFile ajouté aux file_imported');
        }



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
        Yii::log("limit : " . ini_get('memory_limit'), 'error');
        ini_set('memory_limit', '512M');
        Yii::log("limit after set: " . ini_get('memory_limit'), 'error');
        set_time_limit('1200');
//        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_sqlite3;
//        $cacheSettings = array();
//        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        //PHPExcel_Settings::setCacheStorageMethod($cacheMethod);

        $path = Yii::app()->basePath . "/runtime/tmp_files/temp_$file->filename";
        /*
         * Création du fichier sur le disque
         */
        $fres = $file->write($path);
        $reader = PHPExcel_IOFactory::createReader($excelFormat);
        // $message1 = PHPExcel_Settings::getCacheStorageMethod();
        // $message2 = PHPExcel_Settings::getCacheStorageClass();
        //  Yii::log("cacheMethod : " . $message1 . ", CacheClass : " . $message2, 'error');
        /*
         * Chargement par phpExcel
         */
        // $reader->setReadDataOnly(true);
//        $reader->setReadFilter(new MyReadFilter());

        Yii::log("load excel file", 'error');

        $excel = $reader->load($path);
        // $excel->setActiveSheetIndex(1);
        Yii::log("excel file loaded", 'error');
        unset($reader);
        /*
         * Ecriture en .csv
         */
        $writer = PHPExcel_IOFactory::createWriter($excel, 'CSV');
        $writer->setPreCalculateFormulas(false);
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
//        $tempSaveList = new MongoInsertBatch(Sample::model()->getCollection());
        $tempSaveList = array();
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
                $model->_id = new MongoId();
                while (!$model->validate(array('_id')))
                    $model->_id = new MongoId();
                $model->biobank_id = $biobank_id;
                $model->file_imported_id = $fileImportedId;

                foreach ($keysArray as $key2 => $value2) {
                    if ($value2 != "biobank_id" && $value2 != "file_imported_id")
                        if (in_array($value2, Sample::model()->attributeNames())) {

                            $model->$value2 = $data[$key2];
                            if (!$model->validate(array($value2))) {

                                //   Yii::log("Problem with item" . $model->getAttributeLabel($value2) . ",set to null.\n " . implode(", ", $model->errors[$value2]), CLogger::LEVEL_ERROR);
                                $model->$value2 = null;
                            }
                        } else {


                            $note = new Note();
                            $note->key = $value2;
                            $note->value = $data[$key2];
                            $model->notes[] = $note->attributes;
                        }
                }

                if (!$model->validate()) {
                    Yii::log("Problem with sample validation " . print_R($model->errors, true), CLogger::LEVEL_ERROR);
                    $listBadSamples[] = $row;
                } else {

                    $tempSaveList[] = $model->attributes;
//                        $tempSaveList->add($model->attributes);


                    $newSamples[] = $model->_id;
                }
            }
            $row++;
            if ($row != 2 && $row % 400 == 2 && !empty($tempSaveList)) {
                Yii::log("Nb treated : " . $row, 'error');
                Sample::model()->getCollection()->batchInsert($tempSaveList, array());
                $tempSaveList = array();

                //$tempSaveList->execute(array());
                //$tempSaveList = new MongoInsertBatch(Sample::model()->getCollection());
            }
        }
        if (!empty($tempSaveList)) {
            Sample::model()->getCollection()->batchInsert($tempSaveList, array("w" => 1));
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
        }

        return array('error' => count($listBadSamples), 'inserted' => count($newSamples));
    }

    public function addToImportedFiles($file) {
        $fileImported = new FileImported;
        $fileImported->_id = $file->_id;
        $fileImported->biobank_id = $file->metadata['biobank_id'];
        $fileImported->extraction_id = time();
        $fileImported->given_name = $file->filename;
        $fileImported->suffix_type = '3';
        $fileImported->generated_name = $file->filename;

        $fileImported->date_import = $file->uploadDate->toDateTime()->format('Y-m-d H:i:s');
        $fileImported->version_format = '2';
        if ($fileImported->save())
            return true;
        else {
            $errors = $fileImported->getErrors();
            Yii::log('Impossible to store xls file info in FileImported !', CLogger::LEVEL_ERROR);
            foreach ($errors as $attributeName => $errorAttribute)
                Yii::log($attributeName . " : " . implode(', ', $errorAttribute), CLogger::LEVEL_ERROR);
        }
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

    /**
     * get an array of country used by dropDownList.
     */
    public function getArrayCountries() {
        return array(
            'fr' => Yii::t('listCountries', 'fr'),
            'uk' => Yii::t('listCountries', 'uk'),
            'us' => Yii::t('listCountries', 'us'),
            'es' => Yii::t('listCountries', 'es'),
            'de' => Yii::t('listCountries', 'de'),
            'at' => Yii::t('listCountries', 'at'),
            'bg' => Yii::t('listCountries', 'bg'),
            'cy' => Yii::t('listCountries', 'cy'),
            'hr' => Yii::t('listCountries', 'hr'),
            'ee' => Yii::t('listCountries', 'ee'),
            'fi' => Yii::t('listCountries', 'fi'),
            'gr' => Yii::t('listCountries', 'gr'),
            'hu' => Yii::t('listCountries', 'hu'),
            'ie' => Yii::t('listCountries', 'ie'),
            'it' => Yii::t('listCountries', 'it'),
            'lv' => Yii::t('listCountries', 'lv'),
            'lt' => Yii::t('listCountries', 'lt'),
            'lu' => Yii::t('listCountries', 'lu'),
            'mt' => Yii::t('listCountries', 'mt'),
            'cz' => Yii::t('listCountries', 'cz'),
            'ro' => Yii::t('listCountries', 'ro'),
            'sk' => Yii::t('listCountries', 'sk'),
            'si' => Yii::t('listCountries', 'si'),
            'se' => Yii::t('listCountries', 'se'),
            'it' => Yii::t('listCountries', 'it'),
            'ru' => Yii::t('listCountries', 'ru'),
            'be' => Yii::t('listCountries', 'be'),
            'ch' => Yii::t('listCountries', 'ch'),
            'pt' => Yii::t('listCountries', 'pt'),
            'nl' => Yii::t('listCountries', 'nl'),
            'pl' => Yii::t('listCountries', 'pl'),
            'dk' => Yii::t('listCountries', 'dk'),
            'ua' => Yii::t('listCountries', 'ua'),
            'ca' => Yii::t('listCountries', 'ca'),
            'cn' => Yii::t('listCountries', 'cn'),
            'jp' => Yii::t('listCountries', 'jp'),
            'tr' => Yii::t('listCountries', 'tr')
        );
    }

    /**
     * get an array of countries sorted by value.
     */
    public function getArrayCountriesSorted() {
        $resArraySorted = new ArrayObject(CommonTools::getArrayCountries());
        $resArraySorted->asort();
        return $resArraySorted;
    }

}