<?php

/*
 * Extraire les informations necessaire du model "Contact", recuperer à partir 
 * de "contact_id" du model biobank et les stocker dans le nouvel champs "contact_resp" du biobank.
 */

class ExtractContactCommand extends CConsoleCommand {

    public function run($args) {
        include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'CommonTools.php';
        $biobankList = Biobank::model()->findAll();
        foreach ($biobankList as $biobank) {
            $biobank = $this->extractContact($biobank);
            
            $biobank->save();
        }
    }

    /*
     * Function qui recoit comme paramètre un num de téléphone et le met au format "+33...."
     * @param $phone: numero de téléphone
     * @return : le num de telephone  au format "+33"
     */

    function getIntPhoneFormat($phone) {

        $phone = str_replace(" ", "", $phone);
        $phone = str_replace(".", "", $phone);
        $phone = str_replace("-", "", $phone);
        $phone = str_replace("/", "", $phone);
        // si le phone commence par "0" on le remplace par "+33"
        if (substr($phone, 0, 1) == '0') {
            $phone = substr_replace($phone, "+33", 0, 1);
        }
        $phone = mb_strcut($phone, 0, 12);
        return $phone;
    }
    
    
    /**
     * functin qui recoit como pqrqmetre un biobank, recupère le contact_id de la biobank, et partir de ce id recupéreles donnés
     *  de contact de la collection contact et l'enregistre dans le nouveau attribut contact crèer 
     * @param type $biobank une biobanque
     * @return la boibanque mis a jour avec les données du contact recuypere
     */
    function extractContact($biobank){
        if (isset($biobank->contact_id)) {
                $contact = Contact::model()->findByPk(new MongoId($biobank->contact_id));
                if (isset($contact)) {
                    $biobank->contact_resp->firstName = str_ireplace(' ', '', $contact->first_name);
                    $biobank->contact_resp->lastName = str_ireplace(' ', '', $contact->last_name);
                    $biobank->contact_resp->email = str_ireplace(' ', '', $contact->email);
                    $biobank->contact_resp->direct_phone = $this->getIntPhoneFormat($contact->phone);
                }
            }
            
        return ($biobank);
    }

}
