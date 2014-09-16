<?php

/**
 * class to store methods around smart research.
 * @author Nicolas Malservet
 * @since 1.1
 */
class SmartResearcherTool
{

    /**
     * search samples with the keywords given<br>
     * keywords are separated by space.
     * @param unknown $keywords
     * @return $model sample model with search parameters setted
     */
    public function search($keywords, $biobank_id = null) {
        //pour chaque mot clé, on cherche une correspondance avec des valeurs possibels d echamps
        $model = new Sample('search');
        if ($biobank_id != null)
            $model->biobank_id = $biobank_id;
        //split des mots cles
        $tabKeywords = explode(" ", $keywords);
        //la correspondance de valeur n est utile que pour un champ, sinon ç ava pas souvent marcher
        foreach ($tabKeywords as $keyword) {
            $gender = SmartResearcherTool::isGenderKeyword($keyword);
            if ($gender != null) {
                $model->gender = $gender;
            } else {
                $ageCriteria = SmartResearcherTool::isAgeKeyword($keyword);
                if ($ageCriteria != null) {
                    if ($ageCriteria[0] == ">=")
                        $model->field_age_min = $ageCriteria[1];
                    if ($ageCriteria[0] == ">")
                        $model->field_age_min = $ageCriteria[1] + 1;
                    if ($ageCriteria[0] == "<=")
                        $model->field_age_max = $ageCriteria[1];
                    if ($ageCriteria[0] == "<")
                        $model->field_age_max = $ageCriteria[1] - 1;
                    if ($ageCriteria[0] == "==") {
                        $model->field_age_min = $ageCriteria[1];
                        $model->field_age_max = $ageCriteria[1];
                    }
                } else {
                    //par defaut si le champ ne correspond a rien on l ajoute comme note
                    $model->field_notes = $keyword;
                }
            }
        }
        return $model;
    }

    /**
     * si le mot clé est une valeur possible de genre, alros conversion
     * @param string $keyword
     * @return null if no possibility, string with the value to set
     */
    public static function isGenderKeyword($keyword) {
        $result = null;
        $possibilities = array("male" => "M", "female" => "F", "homme" => "M", "femme" => "F", "H" => "M", "F" => "F", "M" => "M");
        foreach (array_keys($possibilities) as $possibility) {
            if (strcasecmp($keyword, $possibility) == 0) {
                $result = $possibilities[$possibility];
            }
        }
        return $result;
    }

    /**
     * si le mot clé est une valeur possible d'age, alors conversion
     * @param type $keyword
     * @return array avec en premiere valeur le comparateur, et en seconde la valeur numérique
     *
     */
    public static function isAgeKeyword($keyword) {
        $result = null;
        $possibilities = array("years", "ans", "year", "an");
        $isAgeValue = false;
        $yearpos = 0;
        foreach ($possibilities as $value) {
            if (!$isAgeValue) {
                if (strpos($keyword, $value) !== false) {
                    $isAgeValue = true;
                    $yearpos = strpos($keyword, $value);
                }
            }
        }
        if ($isAgeValue) {
            //recuperation du comparateur
            $comparateurs = array(">=", "<=", "==", ">", "<", "=");
            $comparateurpos = 0;
            $comparateur = null;
            foreach ($comparateurs as $value) {
                if ($comparateur == null) {
                    if (strpos($keyword, $value) !== false) {
                        $comparateur = $value;
                        $comparateurpos = strpos($keyword, $value);
                    }
                }
            }
            //recuperation de la valeur numerique à droite du comparateur
            $agevalue = substr($keyword, $comparateurpos + 1, $yearpos - 1);
            if ($comparateur == null) {
                $comparateur = "==";
            }
            $result = array($comparateur, $agevalue);
        }
        return $result;
    }

}
?>