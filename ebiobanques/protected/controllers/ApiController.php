<?php

class ApiController extends Controller {

    /**
     * no layout
     * @var type
     */
    public $layout = '';

    // Members
    /**
     * Key which has to be in HTTP USERNAME and PASSWORD headers
     */
    Const APPLICATION_ID = 'ASCCPE';

    /**
     * Default response format
     * either 'json' or 'xml'
     */
    private $format = 'json';

    /**
     * @return array action filters
     */
    public function filters() {
        return array();
    }

    public function accessRules() {
        return array(
            array(
                'allow', // allow all users to perform 'index' and 'dashboard' actions
                'actions' => array(
                    'getLDIF',
                ),
                'users' => array(
                    '*'
                )
            ),
            array(
                'deny', // deny all users
                'users' => array(
                    '*'
                )
            )
        );
    }

    /**
     * expose the biobank directory into an LDIF format
     */
    public function actionGetBiobanksLDIF() {
        $this->_sendResponse(200, $this->getBiobanksLDIF());
    }

    /**
     * get biobank infos and convert into an LDIF format
     * @return string
     */
    private function getBiobanksLDIF() {
        $result = "
dn: c=fr,ou=biobanks,dc=directory,dc=bbmri-eric,dc=eu
objectClass: country
objectClass: top
c: fr
";
        $biobanks = Biobank::model()->findAll();
        foreach ($biobanks as $biobank) {
            $attributes = array();
            $attributes['biobankCountry'] = "FR";
            $attributes['biobankID'] = "bbmri-eric:ID:FR_" . $biobank->id;
            $attributes['biobankName'] = $biobank->name;
            $attributes['biobankJuridicalPerson'] = $biobank->name;
            $attributes['biobankMaterialStoredDNA'] = "false";
            $attributes['biobankMaterialStoredcDNAmRNA'] = "false";
            $attributes['biobankMaterialStoredmicroRNA'] = "false";
            $attributes['biobankMaterialStoredWholeBlood'] = "false";
            $attributes['biobankMaterialStoredPBC'] = "false";
            $attributes['biobankMaterialStoredPlasma'] = "false";
            $attributes['biobankMaterialStoredSerum'] = "false";
            $attributes['biobankMaterialStoredTissueCryo'] = "false";
            $attributes['biobankMaterialStoredTissueParaffin'] = "false";
            $attributes['biobankMaterialStoredCellLines'] = "false";
            $attributes['biobankMaterialStoredUrine'] = "false";
            $attributes['biobankMaterialStoredSaliva'] = "false";
            $attributes['biobankMaterialStoredFaeces'] = "false";
            $attributes['biobankMaterialStoredPathogen'] = "false";
            $attributes['biobankMaterialStoredOther'] = "false";
            $attributes['biobankPartnerCharterSigned'] = "false";
            $attributes['biobankSize'] = "1";
            $attributes['objectClass'] = "biobankClinical"; //TODO implementer la valeur de ce champ Si biobankClinical Diagnosis obligatoire
            $attributes['diagnosisAvailable'] = "urn:miriam:icd:D*";

            $contact = $biobank->getContact();
            //TODO info de contact obligatoire lever un warning si pas affectée pour l export
            if ($contact != null) {
                $attributes['biobankContactFirstName'] = $contact->first_name;
                $attributes['biobankContactLastName'] = $contact->last_name;
                $attributes['biobankContactPhone'] = CommonTools::getIntPhone($contact->phone);
                $attributes['biobankContactEmail'] = $contact->email;
                $attributes['biobankContactAddress'] = $contact->adresse;
                $attributes['biobankContactZIP'] = $contact->code_postal;
                $attributes['biobankContactCity'] = $contact->ville;
                $attributes['biobankContactCountry'] = "FR"; //TODO get pays avec FR pas integer $contact->pays;
            } else {
                Yii::log("contact must be filled for export LDIF. Biobank without contact:" . $biobank->name, CLogger::LEVEL_WARNING, "application");
            }
            $this->checkAttributesComplianceWithBBMRI($attributes);
            $result.="dn: biobankID=" . $attributes['biobankID'] . ",c=fr,ou=biobanks,dc=directory,dc=bbmri-eric,dc=eu\n"; //TODO recuperer le diagnistique agréger
            foreach ($attributes as $key => $value) {
                $result.=$key . ": " . $value . "\n";
            }
        }

        return $result;
    }

    /**
     * Check the attributes of one biobank according to the BBMRI validation rules
     * Raise an error log if data needs to be enhanced
     * @param array $attributes
     */
    public function checkAttributesComplianceWithBBMRI($attributes) {
        $anomalies = array();
        //Fields mandatory
        $attributesnotempty = array();
        $attributesnotempty[] = 'biobankCountry';
        $attributesnotempty[] = 'biobankContactEmail';
        $attributesnotempty[] = 'biobankContactAddress';
        $attributesnotempty[] = 'biobankContactCity';
        $attributesnotempty[] = 'biobankContactZIP';
        $attributesnotempty[] = 'biobankContactCountry';
        $attributesnotempty[] = 'objectClass';
        $attributesnotempty[] = 'biobankContactPhone';
        $attributesnotempty[] = 'biobankMaterialStoredDNA';
        $attributesnotempty[] = 'biobankMaterialStoredcDNAmRNA';
        $attributesnotempty[] = 'biobankMaterialStoredmicroRNA';
        $attributesnotempty[] = 'biobankMaterialStoredWholeBlood';
        $attributesnotempty[] = 'biobankMaterialStoredPBC';
        $attributesnotempty[] = 'biobankMaterialStoredPlasma';
        $attributesnotempty[] = 'biobankMaterialStoredSerum';
        $attributesnotempty[] = 'biobankMaterialStoredTissueCryo';
        $attributesnotempty[] = 'biobankMaterialStoredTissueParaffin';
        $attributesnotempty[] = 'biobankMaterialStoredCellLines';
        $attributesnotempty[] = 'biobankMaterialStoredUrine';
        $attributesnotempty[] = 'biobankMaterialStoredSaliva';
        $attributesnotempty[] = 'biobankMaterialStoredFaeces';
        $attributesnotempty[] = 'biobankMaterialStoredPathogen';
        $attributesnotempty[] = 'biobankMaterialStoredOther';
        $attributesnotempty[] = 'biobankPartnerCharterSigned';
        $attributesnotempty[] = 'biobankSize';

        foreach ($attributesnotempty as $attributenotempty) {
            if (empty($attributes[$attributenotempty])) {
                $anomalies[$attributenotempty] = $attributenotempty . " is empty";
            }
        }
        ////check syntax compliance
        //check biobankID only alphabetical without accent, and minimum 3 characters
        if (isset($attributes['biobankID']))
            if (!preg_match('/^[a-zA-Z0-9:_ -]{3,}$/', $attributes['biobankID']))
                $anomalies['biobankID'] = "biobankIDis in a bad syntax, only withou accent:" . $attributes['biobankID'];
        //The phone number needs to be in the +99999999 international format without spaces.
        if (isset($attributes['biobankContactPhone']))
            if (!preg_match("/^\+[0-9]{11}$/", $attributes['biobankContactPhone']))
                $anomalies['biobankContactPhone'] = "biobankContactPhone is in a bad syntax, needed +999999999";

        //check semantic compliance
        if (isset($attributes['objectClass']) && $attributes['objectClass'] == "biobankClinical")
            if (empty($attributes['diagnosisAvailable']))
                $anomalies['diagnosisAvailable'] = "diagnosis available mandatory if object class biobankClinical";
        //raise an error log if count >0
        if (count($anomalies) > 0) {
            $message = "<b>Biobank with fields in error :" . $attributes['biobankName'] . "</b><br>";
            foreach ($anomalies as $key => $value) {
                $message.=$key . ": " . $value . "\n";
            }
            Yii::log($message, CLogger::LEVEL_WARNING, "application");
        }
    }

    private function _sendResponse($status = 200, $body = '', $content_type = 'text/html') {
        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        // and the content type
        header('Content-type: ' . $content_type);

        // pages with body are easy
        if ($body != '') {
            // send the body
            echo $body;
        }
        // we need to create the body if none is passed
        else {
            // create some body messages
            $message = '';

            // this is purely optional, but makes the pages a little nicer to read
            // for your users.  Since you won't likely send a lot of different status codes,
            // this also shouldn't be too ponderous to maintain
            switch ($status) {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            // servers don't always have a signature turned on
            // (this is an apache directive "ServerSignature On")
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

            // this should be templated in a real-world solution
            $body = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
</head>
<body>
    <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
    <p>' . $message . '</p>
    <hr />
    <address>' . $signature . '</address>
</body>
</html>';

            echo $body;
        }
        Yii::app()->end();
    }

    private function _getStatusCodeMessage($status) {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    private function _checkAuth() {
        // Check if we have the USERNAME and PASSWORD HTTP headers set?
        if (!(isset($_SERVER['HTTP_X_USERNAME']) and isset($_SERVER['HTTP_X_PASSWORD']))) {
            // Error: Unauthorized
            $this->_sendResponse(401);
        }
        $username = $_SERVER['HTTP_X_USERNAME'];
        $password = $_SERVER['HTTP_X_PASSWORD'];
        // Find the user
        $user = User::model()->find('LOWER(username)=?', array(strtolower($username)));
        if ($user === null) {
            // Error: Unauthorized
            $this->_sendResponse(401, 'Error: User Name is invalid');
        } else if (!$user->validatePassword($password)) {
            // Error: Unauthorized
            $this->_sendResponse(401, 'Error: User Password is invalid');
        }
    }

}

?>
