<?php

/**
 * class to format field. 
 * Needed to enhance the different users view and export ( xls, pdf, views)
 * For example tel number +33123456789 =>+33 1 23 45 67
 */
class CommonFormatter {

    /**
     * return a tel number formatted
     * @param type $number must be a string 11 characters with format : +33647920113
     */
    public static function telNumberToFrench($number) {
        if (strlen($number) == 12) {
            return substr($number, 0, 3) ." " . substr($number, 3, 1). " " . substr($number, 4, 2) . " " . substr($number, 6, 2) . " " . substr($number, 8,2) . " " . substr($number, 10,2);
        } else {
            return $number;
        }
    }

}
