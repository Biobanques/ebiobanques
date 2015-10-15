<?php

/**
 * Calcul des statistiques par biobanques pour le benchmarking.
 * Insertion des resultats dans la base de données
 *
 */
class ExtractAdressFromBiobanksCommand extends CConsoleCommand
{

    public function run($args) {
        include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'CommonTools.php';
        $biobankList = Biobank::model()->findAll();
        foreach ($biobankList as $biobank) {
            if (isset($biobank->ville)) {
                $biobank->address->city = $biobank->ville;
                unset($biobank->ville);
            }
            if (isset($biobank->adresse)) {
                $biobank->address->street = $biobank->adresse;
                $biobank->address->zip = str_ireplace(' ', '', extract_zipcode($biobank->address->street));
                $biobank->address->street = str_ireplace($biobank->address->zip, '', $biobank->address->street);
                $biobank->address->street = str_ireplace($biobank->address->city, '', $biobank->address->street);
                unset($biobank->adresse);
            }

            if (isset($biobank->region)) {
                $biobank->address->initSoftAttribute('region');
                $biobank->address->region = $biobank->region;
                unset($biobank->region);
            }
            $biobank->address->country = 'fr';


            $biobank->save(false);
        }
    }

}

function extract_zipcode($address) {
    $zipcode = preg_match("/([0-9]{5})|([0-9]{2} [0-9]{3})/", $address, $matches);
    return isset($matches[0]) ? $matches[0] : null;
}

?>