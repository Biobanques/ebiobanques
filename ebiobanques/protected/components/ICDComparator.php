<?php

/**
 * ICDComparator is a tool class to n help icd10 comparisons.
 *
 * @author nicolas
 */
class ICDComparator {

    /**
     * we associate a score for each icdCode to facilitate comparaison
     * each letter is replaced with is position into the alphabet example :
     * a=1, e=5
     * the array of each code contains the bounds
     * @var type 
     * @return ICD GROUP format A00-B99
     */
    public static function getICDGroups() {
        return ["A00-B99" => [100, 299],
            "C00-D48" => [300, 448],
            "D50-D89" => [450, 489],
            "E00-E90" => [500, 590],
            "F00-G99" => [600, 799],
            "H00-H59" => [800, 859],
            "H60-H95" => [860, 895],
            "I00-I99" => [900, 999],
            "J00-J99" => [1000, 1099],
            "K00-K93" => [1100, 1193],
            "L00-L99" => [1200, 1299],
            "M00-M99" => [1300, 1399],
            "N00-N99" => [1400, 1499],
            "O00-O99" => [1500, 1599],
            "P00-P96" => [1600, 1696],
            "Q00-Q99" => [1700, 1799],
            "R00-Z99" => [1800, 2699],];
    }

    /**
     * search on the array of ICD groups which group contains the ICD Code
     * @param an ICD10 code example A45
     * @return the group of the icd10 code given, null if no group 
     */
    public static function getGroup($ICD10code) {
        $group = null;
        //verify if the code is correct
        if (strlen($ICD10code) == 3) {
            //get the first character
            $letter = substr($ICD10code, 0,1);
            $number = substr($ICD10code, 1, 2);
            if (ctype_alpha($letter)) {
                //recompose the score, with the value of the letter and the suffixe the number part
                $score = (ord(strtolower($letter)) - 96) . $number;
                //compare if the current in the the bounds of a group is in the string
                foreach (ICDComparator::getICDGroups() as $ICDgroup => $bounds) {
                    if ($score >= $bounds[0] && $score <= $bounds[1]) {
                        $group = $ICDgroup;
                    }
                }
            } else {
                throw new Exception('ICD10 Code incorrect, first digit must be a letter');
            }
        } else {
            throw new Exception('ICD10 Code length error');
        }
        return $group;
    }

    /**
     * check if a string is an ICD Code.
     * ICD code is always 1 letter + 2 digits
     */
    public static function isICDCode($string) {
        $result = false;
        if (strlen($string) == 3) {
            $letter = substr($string, 0,1);
            $number = substr($string, 1, 2);
            if (ctype_alpha($letter)) {
                if (ctype_digit($number)) {
                    $result = true;
                }
            }
        }
        return $result;
    }

}
