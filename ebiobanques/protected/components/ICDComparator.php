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
     */
    public $ICD10_groups = array(
        "A00_B99"=>array(100, 299),
        "C00_D48"=>array(300, 448),
         "D50_D89"=>array(450, 489),
        "E00_E90"=>array(500, 590),
        "F00_G99"=>array(600, 799),
        "H00_H59"=>array(800, 859),
        "H60_H95"=>array(860, 895),
        "I00_I99"=>array(900, 999),
        "J00_J99"=>array(1000, 1099),
        "K00_K93"=>array(1100, 1193),
        "L00_L99"=>array(1200, 1299),
        "M00_M99"=>array(1300, 1399),
        "N00_N99"=>array(1400, 1499),
        "O00_O99"=>array(1500, 1599),
        "P00_P96"=>array(1600, 1696),
        "Q00_Q99"=>array(1700, 1799),
        "R00_Z99"=>array(1800, 2699),);

    /**
     * search on the array of ICD groups which group contains the ICD Code
     * @param an ICD10 code example A45
     * @return the group of the icd10 code given, null if no group 
     */
    public function getGroup($ICD10code) {
        $group = null;
        //verify if the code is correct
        if (length($ICD10code) == 3) {
            //get the first character
            $letter = substr($ICD10code, 0);
            $number = substr($ICD10code,1,2);
            //recompose the score, with the value of the letter and the suffixe the number part
            $score = (ord(strtolower($letter)) - 96).$number;
            //compare if the current in the the bounds of a group is in the string
            foreach ($this->ICD10_groups  as $ICDgroup =>$bounds) {
                if ($score>=$bounds[0]&&$score<=$bounds[1]) {
                    $group = $ICDgroup;
                }
            }
        } else {
            throw new Exception('ICD10 Code length error');
        }
        return $group;
    }

}
