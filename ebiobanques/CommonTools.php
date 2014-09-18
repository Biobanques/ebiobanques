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
     * Trasforme un fichier binaire dans le format mime indiqué.
     * @param type $bin
     * @param type $mime
     * @return string
     */
    public static function data_uri($bin, $mime) {
        $base64 = base64_encode($bin);
        return ('data:' . $mime . ';base64,' . $base64);
    }

    public static function getBiobankInfo() {
        $id = $_SESSION['biobank_id'];

        $biobank = Biobank::getBiobank($id);
        if ($biobank != null) {
            $pk = $biobank->vitrine['logo'];
            $logo = Logo::model()->findByPk(new MongoId($pk));
            $_SESSION['vitrine'] = array('biobank' => $biobank, 'biobankLogo' => $logo);

            return $id;
        } else {
            Yii::app()->user->setFlash('error', yii::t('common', 'noBiobankFound'));
            Yii::app()->controller->redirect(Yii::app()->createUrl('site/biobanks'));
        }
    }

}
?>
