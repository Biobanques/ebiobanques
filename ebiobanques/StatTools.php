<?php

/**
 * classe de statistiques utiles.
 */
class StatTools
{

    /**
     * retourne la reparttion des echantillons par ville
     * Fournit un tableau aossicatif de nom entier
     *
     * @return array[array(string,int)]
     */
    public static function getRepartitionSamplesByTown() {
        $result = array();
        $biobanks = Biobank::model()->findAll();
        foreach ($biobanks as $biobank) {
            $criteria = new EMongoCriteria ();
            $criteria->biobank_id = (string) $biobank->_id;
            $compte = Sample::model()->count($criteria);
            if ($compte != 0)
                $result [] = array(
                    $biobank->address->city,
                    $compte
                );
        }
        return $result;
    }

    /**
     * retourne un tableau assoicatif des comptes de reception d echantillons par mois ( 12 derniers mois)
     * FIXME refaire cet algo avec file_imported sur mongo sinon c pas top
     * @return array[array(string,int)]
     */
    public static function getCountReceptionByMonth() {
        $result = array();
        $format = "Y-m-d 00:00:00";
        $dateJour = date($format);
        /**
         * filtre des fichiers de reception par date<br>
         * compte des echantillons par fichier et ajoute à la somme
         */
        for ($i = 0; $i < 13; $i ++) {
//            $currentMonth = date("m", strtotime('-' . $i . ' month' . $dateJour));
//            $currentYear = date("Y", strtotime('-' . $i . ' month' . $dateJour));
//            $filterDate = $currentYear . "-" . $currentMonth . "%";
//            $monthCount = 0;
//            $fileCriteria = new EMongoCriteria;
//            $fileCriteria->date_import = new MongoRegex('/' . $filterDate . '*/i');
            $currentMonth = date("M", strtotime('-' . $i . ' month' . $dateJour));
            $currentYear = date("Y", strtotime('-' . $i . ' month' . $dateJour));
            $regexString = '/[a-z]{3} ' . $currentMonth . ' [0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2} [a-z]{3} ' . $currentYear . '/i';
            $fileCriteria = new EMongoCriteria;
            $fileCriteria->date_import = new MongoRegex($regexString);
            $monthCount = 0;
            $files = FileImported::model()->findAll($fileCriteria);

            if ((count($files)) > 0) {
                $arrayOfFilesId = array();
                foreach ($files as $fichier) {

                    $arrayOfFilesId [] = (string) $fichier->_id;
                }
                $criteria = new EMongoCriteria ();
                $criteria->file_imported_id('in', $arrayOfFilesId);
                $monthCount += Sample::model()->count($criteria);
            }
            $result [] = array(
                $currentMonth . "/" . $currentYear,
                $monthCount
            );
        }

        return $result;
    }

    /**
     * retourne un tableau assoicatif des comptes de reception d echantillons par mois ( 12 derniers mois)
     * pour la biobanque fournie en parametre
     *
     * @param $var Biobank(id)
     * @return array[array(string,int)]
     */
    public static function getCountReceptionByMonthAndBiobank($biobank_id) {

        $result = array();
        $format = "Y-m-d 00:00:00";
        $dateJour = date($format);
        /**
         * filtre des fichiers de reception par date et par biobanque<br>
         * compte des echantillons par fichier et ajoute à la somme
         */
        for ($i = 0; $i < 13; $i ++) {
            $currentMonth = date("m", strtotime('-' . $i . ' month' . $dateJour));
            $currentYear = date("Y", strtotime('-' . $i . ' month' . $dateJour));
            $filterDate = $currentYear . "-" . $currentMonth . "%";
            $monthCount = 0;

            $fileCriteria = new EMongoCriteria;
            $fileCriteria->biobank_id = $biobank_id;
            $fileCriteria->date_import = new MongoRegex('/' . $filterDate . '*/i');
            $files = FileImported::model()->findAll($fileCriteria);
            if ((count($files)) > 0) {
                $arrayOfFilesId = array();
                foreach ($files as $fichier) {

                    $arrayOfFilesId [] = (string) $fichier->_id;
                }
                $criteria = new EMongoCriteria ();
                $criteria->file_imported_id('in', $arrayOfFilesId);
                $monthCount += Sample::model()->count($criteria);
            }

            $result [] = array(
                $currentMonth . "/" . $currentYear,
                $monthCount
            );
        }
        return $result;
    }

    /**
     * retourne un tableau assoicatif des comptes de reception de fichiers par mois ( 12 derniers mois)
     *
     * @return array[array(string,int)]
     */
    public static function getCountFilesReceptionByMonth() {
        $result = array();
        $format = "Y-m-d 00:00:00";
        $dateJour = date($format);
        /**
         * filtre des fichiers de reception par date<br>
         */
        for ($i = 0; $i < 13; $i ++) {
//            $currentMonth = date("m", strtotime('-' . $i . ' month' . $dateJour));
//            $currentYear = date("Y", strtotime('-' . $i . ' month' . $dateJour));
//            $filterDate = $currentYear . "-" . $currentMonth . "%";
//            $criteria = new EMongoCriteria;
//            $criteria->date_import = new MongoRegex('/' . $filterDate . '*/i');
            $currentMonth = date("M", strtotime('-' . $i . ' month' . $dateJour));
            $currentYear = date("Y", strtotime('-' . $i . ' month' . $dateJour));
            $filterDate = $currentYear . "-" . $currentMonth . "%";
            $criteria = new EMongoCriteria;
            $regexString = '/[a-z]{3} ' . $currentMonth . ' [0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2} [a-z]{3} ' . $currentYear . '/i';
            $criteria->date_import = new MongoRegex($regexString);

            $monthCount = FileImported::model()->count($criteria);
            $result [] = array(
                $currentMonth . " " . $currentYear,
                $monthCount
            );
        }
        return $result;
    }

    public static function getCountFilesReceptionByMonthAndBiobank($biobank_id) {
        $result = array();
        $format = "Y-m-d 00:00:00";
        $dateJour = date($format);
        /**
         * filtre des fichiers de reception par date<br>
         */
        for ($i = 0; $i < 13; $i ++) {
            $monthCount = 0;
            $currentMonth = date("m", strtotime('-' . $i . ' month' . $dateJour));
            $currentYear = date("Y", strtotime('-' . $i . ' month' . $dateJour));
            $filterDate = $currentYear . "-" . $currentMonth . "%";

            $criteria = new EMongoCriteria;
            $criteria->biobank_id = $biobank_id;
            $criteria->date_import = new MongoRegex('/' . $filterDate . '*/i');
            $monthCount = FileImported::model()->count($criteria);
            $result [] = array(
                $currentMonth . "/" . $currentYear,
                $monthCount
            );
        }

        return $result;
    }

    public static function getAttributesForRating() {
        return array(
            'id_depositor' => array('notin' => array(null, "")),
            'id_sample' => array("notin" => array(null, "")),
            'consent_ethical' => array("notin" => array(null, "")),
            'gender' => array("notin" => array(null, "I", "U")),
            'age' => array("notin" => array(null, "", "0", 0)),
            'collect_date' => array('notin' => array(null, "")),
            'storage_conditions' => array('notin' => array(null, "")),
            'consent' => array('notin' => array(null, "", "U"), 'in' => array('Y', 'N')),
            'supply' => array('notin' => array(null, "")),
            'max_delay_delivery' => array('notin' => array(null, "")),
            'detail_treatment' => array('notin' => array(null, "")),
            'authentication_method' => array('notin' => array(null, "")),
            'patient_birth_date' => array('notin' => array(null, "", "0000-00-00")),
            'tumor_diagnosis' => array('notin' => array(null, "")),
            'disease_outcome' => array('notin' => array(null, "")),
        );
    }

    /**
     * effectue le calcul de statistiques de la biobanque fournie en parametre si elle possede des echantillons,
     * @param type $biobank_id
     * @return null
     */
    public static function getCompletionRateByBiobank($biobank_id) {
        //nombre total d'échantillons de la biobanque
        $criteria = new EMongoCriteria;
        $criteria->biobank_id = $biobank_id;
        $compte = Sample::model()->count($criteria);
        if ($compte != 0 && $compte != null) {
            $details = array();
            $rateCount = 0;
            $listAttributes = StatTools::getAttributesForRating();
            foreach ($listAttributes as $attributeName => $attributeConstraint) {
                $echCriteria = new EMongoCriteria;
                $echCriteria->biobank_id = $biobank_id;
                $echCriteria->addCond($attributeName, "exists", true);
                if (is_array($attributeConstraint)) {
                    foreach ($attributeConstraint as $operator => $values) {
                        $echCriteria->addCond($attributeName, $operator, $values);
                    }
                }
                $nbEch = Sample::model()->count($echCriteria);
                $details[$attributeName] = round(($nbEch / $compte) * 100, 2);
                $rateCount+=$nbEch;
            }
            $rate = $rateCount / ($compte * count($listAttributes));
            return array($rate * 100, $details);
        } else
            return null;
    }

    /**
     * Recupere le dernier objet biobankStats en base pour la biobanque concernée si il date du jour même, ou en créé un nouveau
     * recupere les statistiques de la biobanque en parametre, et les enregistre en base avec la date/heure mise à jour
     * @param type $biobankId
     * @return string
     */
    public function saveBiobankStats($biobankId) {
        $date = new DateTime;
        $searchDate = $date->format('Y-m-d');
        $biobankStats = BiobankStats::model()->findByAttributes(array('biobank_id' => $biobankId, 'date' => new MongoRegex("/$searchDate.*/i"))) != null ?
                BiobankStats::model()->findByAttributes(array('biobank_id' => $biobankId, 'date' => new MongoRegex("/$searchDate.*/i"))) : new BiobankStats();
        $datas = StatTools::getCompletionRateByBiobank($biobankId);
        if ($datas != null) {
            $biobankStats->biobank_id = $biobankId;
            $biobankStats->date = $date->format(DateTime::ISO8601);
            $biobankStats->globalRate = $datas[0];
            $details = $datas[1];
            $biobankStats->values = $details;
            return $biobankStats->save();
        } else
            return 'Pas de données pour cette biobanque.';
    }

    /**
     * Recupere les dernieres statistiques de chaque buiobanque, et calcule les statisqtiues globales
     * @return type
     */
    public function getAverageRate() {
        $result = array();
        $listAttributes = StatTools::getAttributesForRating();
        $bbStatsCriteria = new EMongoCriteria;
        $bbStatsCriteria->addCond('biobank_id', '!=', '0');
        // $biobanksStats = BiobankStats::model()->findAll($bbStatsCriteria);
        $biobanksStats = array();
        $collAggregate = BiobankStats::model()->getCollection()->aggregate(
                array(
            '$sort' => array(
                'date' => -1
            ))
                , array(
            '$group' => array(
                '_id' => '$biobank_id',
                'biobank' => array(
                    //   '$first' => '$$ROOT'
                    '$first' => array(
                        'values' => '$values',
                        'date' => '$date',
                    )
                )
            )
                )
        );
        foreach ($collAggregate['result'] as $firstResult) {
            $stats = new BiobankStats;
            $stats->setAttributes($firstResult['biobank'], false);
            $biobanksStats[] = $stats;
        }

        $rateCount = 0;
        foreach ($listAttributes as $attributeName => $attributeConstraint) {
            $partialResult = 0;

            foreach ($biobanksStats as $BiobankStats) {
                if (isset($BiobankStats->values[$attributeName])) {
                    $partialResult+=$BiobankStats->values[$attributeName];
                }
            }
            $result['values'][$attributeName] = $partialResult / count($biobanksStats);
            $rateCount+=$result['values'][$attributeName];
        }
        $result['globalRate'] = $rateCount / count($listAttributes);
        return $result;
    }

    /**
     * Recupere le dernier objet biobankStats pour la biobanque id=0 (stats globales) en base si il date du jour même,
     * ou en créé un nouveau
     * @return type
     */
    public function saveAverageRate() {
        $averageRate = StatTools::getAverageRate();
        $date = new DateTime;
        $searchDate = $date->format('Y-m-d');
        $globalStats = BiobankStats::model()->findByAttributes(array('biobank_id' => "0", 'date' => new MongoRegex("/$searchDate.*/i"))) != null ?
                BiobankStats::model()->findByAttributes(array('biobank_id' => "0", 'date' => new MongoRegex("/$searchDate.*/i"))) : new BiobankStats();

        $globalStats->biobank_id = '0';
        $globalStats->date = $date->format(DateTime::ISO8601);
        $globalStats->globalRate = $averageRate['globalRate'];
        $globalStats->values = $averageRate['values'];
        return $globalStats->save();
    }

}
?>