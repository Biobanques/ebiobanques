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
        Yii::beginProfile('XLS_To_CSV');
        $bytes = CommonTools::toCsv($file);
        Yii::endProfile('XLS_To_CSV');
        Yii::beginProfile('analyzeAndImportCsv');
        $resultAnalyse = CommonTools::analyzeCsv($bytes, $biobank_id, $file_imported_id, $add);
        Yii::endProfile('analyzeAndImportCsv');
        $errors = $resultAnalyse['errors'];
        $error = count($errors);
        if ($resultAnalyse['inserted'] > 0) {
            $added = CommonTools::addToImportedFiles($file);
            if ($added == true)
                Yii::log('ExcelFile ajouté aux file_imported', CLogger::LEVEL_INFO, 'importFile');
            $file->metadata['samplesAdded'] = $resultAnalyse['inserted'];
            $file->metadata['addToOld'] = $add ? true : false;
        }



        if ($error == 0)
            Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success') . '<br>All samples where successfully imported');
        else {

            Yii::app()->user->setFlash('notice', Yii::app()->user->getFlash('success') . "<br>$error elements were not correctly imported. Please ask admin for more details");
            Yii::app()->user->setFlash('success', null);

            $file->metadata['errors'] = $errors;
            $file->save();
        }

        return $file;
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
        Yii::log("limit : " . ini_get('memory_limit'), 'info');
        ini_set('memory_limit', '512M');
        Yii::log("limit after set: " . ini_get('memory_limit'), 'info');
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

        Yii::log("load excel file", 'info');

        $excel = $reader->load($path);
        // $excel->setActiveSheetIndex(1);
        Yii::log("excel file loaded", 'info');
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

                    $errorList = array();
                    foreach ($model->errors as $errorKey => $errorValue) {
                        $errorList[] = array('attributeName' => $errorKey, 'errorValue' => $errorValue);
                    }

                    $listBadSamples[] = array('row' => $row, 'attributes' => $errorList);
//                    $listBadSamples[] = array('row' => $row, 'attributes' => array($model->errors));
                } else {

                    $tempSaveList[] = $model->attributes;
//                        $tempSaveList->add($model->attributes);


                    $newSamples[] = $model->_id;
                }
            }
            $row++;
            if ($row != 2 && $row % 400 == 2 && !empty($tempSaveList)) {
                Yii::log("Nb treated : " . $row, CLogger::LEVEL_ERROR, 'importFile');
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

          //        while (($data = fgetcsv($import, 1000, ",")) !== FALSE) {
          //
          //
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
         */

        fclose($import);
        if (!$add && count($newSamples) > 0) {
            $deleteCriteria = new EMongoCriteria();
            $deleteCriteria->biobank_id('==', $biobank_id);
            $deleteCriteria->_id('notIn', $newSamples);
            Sample::model()->deleteAll($deleteCriteria);
        }
        if (count($listBadSamples) != 0) {

            $log = '';
            foreach ($listBadSamples as $lineNumber => $errors) {
                $log = 'Error with manual import. File id : ' . $fileImportedId . ' - line : ' . $lineNumber;
                Yii::log($log, CLogger::LEVEL_ERROR, 'importFile');
            }
        }

        return array('errors' => $listBadSamples, 'inserted' => count($newSamples));
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
            'tr' => Yii::t('listCountries', 'tr'),
            'FR' => Yii::t('listCountries', 'fr'),
            'UK' => Yii::t('listCountries', 'uk'),
            'US' => Yii::t('listCountries', 'us'),
            'ES' => Yii::t('listCountries', 'es'),
            'DE' => Yii::t('listCountries', 'de'),
            'AT' => Yii::t('listCountries', 'at'),
            'BG' => Yii::t('listCountries', 'bg'),
            'CY' => Yii::t('listCountries', 'cy'),
            'HR' => Yii::t('listCountries', 'hr'),
            'EE' => Yii::t('listCountries', 'ee'),
            'FI' => Yii::t('listCountries', 'fi'),
            'GR' => Yii::t('listCountries', 'gr'),
            'HU' => Yii::t('listCountries', 'hu'),
            'IE' => Yii::t('listCountries', 'ie'),
            'IT' => Yii::t('listCountries', 'it'),
            'LV' => Yii::t('listCountries', 'lv'),
            'LT' => Yii::t('listCountries', 'lt'),
            'LU' => Yii::t('listCountries', 'lu'),
            'MT' => Yii::t('listCountries', 'mt'),
            'CZ' => Yii::t('listCountries', 'cz'),
            'RO' => Yii::t('listCountries', 'ro'),
            'SK' => Yii::t('listCountries', 'sk'),
            'SI' => Yii::t('listCountries', 'si'),
            'SE' => Yii::t('listCountries', 'se'),
            'IT' => Yii::t('listCountries', 'it'),
            'RU' => Yii::t('listCountries', 'ru'),
            'BE' => Yii::t('listCountries', 'be'),
            'CH' => Yii::t('listCountries', 'ch'),
            'PT' => Yii::t('listCountries', 'pt'),
            'NL' => Yii::t('listCountries', 'nl'),
            'PL' => Yii::t('listCountries', 'pl'),
            'DB' => Yii::t('listCountries', 'dk'),
            'UA' => Yii::t('listCountries', 'ua'),
            'CA' => Yii::t('listCountries', 'ca'),
            'CN' => Yii::t('listCountries', 'cn'),
            'JP' => Yii::t('listCountries', 'jp'),
            'TR' => Yii::t('listCountries', 'tr'),
            'Fr' => Yii::t('listCountries', 'fr'),
            'Uk' => Yii::t('listCountries', 'uk'),
            'Us' => Yii::t('listCountries', 'us'),
            'Es' => Yii::t('listCountries', 'es'),
            'De' => Yii::t('listCountries', 'de'),
            'At' => Yii::t('listCountries', 'at'),
            'Bg' => Yii::t('listCountries', 'bg'),
            'Cy' => Yii::t('listCountries', 'cy'),
            'Hr' => Yii::t('listCountries', 'hr'),
            'Ee' => Yii::t('listCountries', 'ee'),
            'Fi' => Yii::t('listCountries', 'fi'),
            'Gr' => Yii::t('listCountries', 'gr'),
            'Hu' => Yii::t('listCountries', 'hu'),
            'Ie' => Yii::t('listCountries', 'ie'),
            'It' => Yii::t('listCountries', 'it'),
            'Lv' => Yii::t('listCountries', 'lv'),
            'Lt' => Yii::t('listCountries', 'lt'),
            'Lu' => Yii::t('listCountries', 'lu'),
            'Mt' => Yii::t('listCountries', 'mt'),
            'Cz' => Yii::t('listCountries', 'cz'),
            'Ro' => Yii::t('listCountries', 'ro'),
            'Sk' => Yii::t('listCountries', 'sk'),
            'Si' => Yii::t('listCountries', 'si'),
            'Se' => Yii::t('listCountries', 'se'),
            'It' => Yii::t('listCountries', 'it'),
            'Ru' => Yii::t('listCountries', 'ru'),
            'Be' => Yii::t('listCountries', 'be'),
            'Ch' => Yii::t('listCountries', 'ch'),
            'Pt' => Yii::t('listCountries', 'pt'),
            'Nl' => Yii::t('listCountries', 'nl'),
            'Pl' => Yii::t('listCountries', 'pl'),
            'Dk' => Yii::t('listCountries', 'dk'),
            'Ua' => Yii::t('listCountries', 'ua'),
            'Ca' => Yii::t('listCountries', 'ca'),
            'Cn' => Yii::t('listCountries', 'cn'),
            'Jp' => Yii::t('listCountries', 'jp'),
            'Tr' => Yii::t('listCountries', 'tr')
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

    public function getAllFieldsarray($collectionClass) {
        $db = Yii::app()->getComponent('mongodb')->getDbInstance();
        $result = array();
        // $db = Biobank::model()->getDb();
        // $biobankCollection = Biobank::model()->getCollection();
        $mr = $db->command(array(
            "mapreduce" => $collectionClass,
            //   "query" => array('id' => '11'),
            "map" => "function() {
    for (var key in this) { emit(key,null); }
  }",
            "reduce" => "function(key, stuff) { return key; }",
            "out" => Array("inline" => TRUE)
        ));
        foreach ($mr['results'] as $mrResult) {
            $result[$mrResult['_id']] = $mrResult['_id'];
        }
        natcasesort($result);

        return $result;
    }

    /**
     * Converts bytes into human readable file size.
     *
     * @param string $bytes
     * @return string human readable file size (2,87 Мб)
     * @author Mogilev Arseny
     */
    function FileSizeConvert($bytes) {
        $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
                break;
            }
        }
        return $result;
    }

    public function validateCimCodeFormat($cimCode) {
        $result = false;
        if (preg_match("/(^[A-Z]{1}[0-9]{2}$)|(^[A-Z]{1}[0-9]{2}\\-{1}[A-Z]{1}[0-9]{2}$)|(^[A-Z]{1}[0-9]{2}\\.{1}[0-9]{1}$)/", $cimCode) === 1)
            $result = true;
        return $result;
    }

    public static function getLatLong($biobank, $saveAfterFind = true) {
        Yii::log('Trying to get location from biobank ' . $biobank->identifier, CLogger::LEVEL_WARNING);
        if (isset($biobank->address->street) && isset($biobank->address->city) && isset($biobank->address->zip) && isset($biobank->address->country)) {

            $requestAddress = str_ireplace(' ', '+', $biobank->address->street) . '+' . $biobank->address->zip . '+' . str_ireplace(' ', '+', $biobank->address->city) . '+' . $biobank->address->country;
            try {
                $requestAddress = CommonTools::url($requestAddress);

                $completeAddress = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $requestAddress;
                $request = new EHttpClient($completeAddress);

                $response = $request->request('GET');
                $var = json_decode($response->getBody());
                Yii::log(print_r($var, true), CLogger::LEVEL_WARNING);

                if ($var->status != "ZERO_RESULTS" && $var->status != "INVALID_REQUEST") {
                    Yii::log("formated address : $requestAddress", CLogger::LEVEL_WARNING);
                    Yii::log("complete google url: $completeAddress", CLogger::LEVEL_WARNING);
                    //  print_r($var->results[0]->geometry->location);
                    $biobank->latitude = $var->results[0]->geometry->location->lat;
                    $biobank->longitude = $var->results[0]->geometry->location->lng;
                    if (!property_exists($biobank, 'location'))
                        $biobank->initSoftAttribute('location');
                    $biobank->location = array('type' => 'Point', 'coordinates' => array($biobank->longitude, $biobank->latitude));
                    if ($saveAfterFind)
                        $biobank->save();
                } else
                    Yii::log('Can\'t find coordinates from adress for biobank :' . $biobank->identifier, CLogger::LEVEL_ERROR);
            } catch (Exception $ex) {
                Yii::log("An exception occured, coordinates can't be set from google API \n " . $ex->getTraceAsString(), CLogger::LEVEL_WARNING);
            }
        } else {
            Yii::log('Can\'t find coordinates from adress for biobank :' . $biobank->identifier, CLogger::LEVEL_ERROR);
        }
    }

    /**
     * Format url for google API
     * @param type $url
     * @return type
     */
    public static function url($url) {
        try {
            $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
            $url = trim($url, "-");
            //$url = @iconv("utf-8", "us-ascii//IGNORE", $url);
            $url = @iconv("UTF-8", "ASCII//TRANSLIT/", $url);
            $url = strtolower($url);
            $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
            Yii::log("Formated url :" . $url, CLogger::LEVEL_ERROR);
            return $url;
        } catch (Exception $ex) {
            Yii::log("Can't format this url" . $ex->getTraceAsString(), CLogger::LEVEL_ERROR);
        }
    }

    /**
     *
     * return the string encoded into ASCII
     * use //IGNORE instead of translit since php 5.4
     * because this method iconv return false and problem
     * if illegal characters are presents.
     * if pb during conversion return an empty string
     * @param type $string in UTF-8 format
     */
    public static function convertStringToAscii($string) {
        setlocale(LC_ALL, 'en_GB');
        $result = "";
        try {
            $result = @iconv("UTF-8", "ASCII//TRANSLIT/", $string);
        } catch (Exception $ex) {
            Yii::log('Pb converting string: : ' . $string, CLogger::LEVEL_ERROR);
        }
        return $result;
    }

}
