<?php

class ApiController extends Controller
{
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
        //FIXME Mandatory empty line here ( TODO use ldif exporter to check syntax)

        $biobanks = Biobank::model()->findAll();
        foreach ($biobanks as $biobank) {
            $attributes = array();

            $attributes['biobankCountry'] = "FR";
            $attributes['biobankID'] = "FR_" . $biobank->identifier;
            $attributes['biobankName'] = $biobank->name;
            $attributes['biobankAcronym'] = isset($biobank->acronym) ? $biobank->acronym : 'FALSE';
            $attributes['biobankJuridicalPerson'] = $biobank->getShortContact();
            if (isset($biobank->presentation_en))
                $attributes['biobankDescription'] = $biobank->presentation_en;
            else if (isset($biobank->presentation))
                $attributes['biobankDescription'] = $biobank->presentation;
            if (isset($biobank->website))
                $attributes['biobankURL'] = $biobank->getWebsiteWithHttp();

            $attributes['biobankIDRef'] = "FALSE";
            if (isset($biobank->latitude))
                $attributes['geoLatitude'] = $biobank->latitude;
            if (isset($biobank->longitude))
                $attributes['geoLongitude'] = $biobank->longitude;

            //collaborationsStatus
            $attributes['collaborationPartnersCommercial'] = isset($biobank->collaborationPartnersCommercial) ? $biobank->collaborationPartnersCommercial : "FALSE";
            $attributes['collaborationPartnersNonforprofit'] = isset($biobank->collaborationPartnersNonforprofit) ? $biobank->collaborationPartnersNonforprofit : "FALSE";


            $attributes['collectionIDRef'] = "FALSE";
            $attributes['biobankNetworkIDRef'] = "FALSE";
            $attributes['biobankITSupportAvailable'] = "FALSE";
            $attributes['biobankITStaffSize'] = "FALSE";
            $attributes['biobankISAvailable'] = "FALSE";
            $attributes['biobankHISAvailable'] = "FALSE";

            //TODO each biobank need to sign a chart between bbmri and the biobank (TODO to discuss)
            $attributes['biobankPartnerCharterSigned'] = isset($biobank->PartnerCharterSigned) ? $biobank->PartnerCharterSigned : "FALSE";


            //Biobank material
            //TODO flase in cappital
            $attributes['materialStoredDNA'] = isset($biobank->materialStoredDNA) ? $biobank->materialStoredDNA : "FALSE";
            $attributes['materialStoredPlasma'] = isset($biobank->materialStoredPlasma) ? $biobank->materialStoredPlasma : "FALSE";
            $attributes['materialStoredSerum'] = isset($biobank->materialStoredSerum) ? $biobank->materialStoredSerum : "FALSE";
            $attributes['materialStoredUrine'] = "FALSE";
            $attributes['materialStoredSaliva'] = "FALSE";
            $attributes['materialStoredFaeces'] = "FALSE";
            $attributes['materialStoredOther'] = "FALSE";
            $attributes['materialStoredRNA'] = "FALSE";
            $attributes['materialStoredBlood'] = "FALSE";
            $attributes['materialStoredTissueFrozen'] = isset($biobank->materialStoredTissueFrozen) ? $biobank->materialStoredTissueFrozen : "FALSE";
            $attributes['materialStoredTissueFFPE'] = isset($biobank->materialStoredTissueFFPE) ? $biobank->materialStoredTissueFFPE : "FALSE";
            $attributes['materialStoredCellLines'] = "FALSE";
            $attributes['materialStoredPathogen'] = "FALSE";


            $attributes['temperatureRoom'] = "FALSE";
            $attributes['temperature2to10'] = "FALSE";
            $attributes['temperature-18to-35'] = "FALSE";
            $attributes['temperature-60to-85'] = "FALSE";
            $attributes['temperatureLN'] = "FALSE";
            $attributes['temperatureOther'] = "FALSE";


            // $attributes['biobankMaterialStoredcDNAmRNA'] = "FALSE";
            // $attributes['biobankMaterialStoredmicroRNA'] = "FALSE";
            // $attributes['biobankMaterialStoredWholeBlood'] = "FALSE";
            // $attributes['biobankMaterialStoredPBC'] = "FALSE";
            // $attributes['biobankMaterialStoredTissueCryo'] = "FALSE";
            // $attributes['biobankMaterialStoredTissueParaffin'] = "FALSE";
            // $attributes['biobankMaterialStoredImmortalizedCellLines'] = "FALSE";
            //  $attributes['biobankMaterialStoredIsolatedPathogen'] = "FALSE";
            //Biobank Network

            $attributes['biobankNetworkID'] = "FALSE";
            $attributes['biobankNetworkName'] = isset($biobank->NetworkName) ? $biobank->NetworkName : "FALSE";
            $attributes['biobankNetworkAcronym'] = isset($biobank->networkAcronym) ? $biobank->networkAcronym : "FALSE";
            $attributes['biobankNetworkDescription'] = isset($biobank->NetworkDescription) ? $biobank->NetworkDescription : "FALSE";
            $attributes['biobankNetworkCommonCollectionFocus'] = isset($biobank->NetworkCommonCollectionFocus) ? $biobank->NetworkCommonCollectionFocus : "FALSE";
            $attributes['biobankNetworkCommonCharter'] = isset($biobank->NetworkCommonCharter) ? $biobank->NetworkCommonCharter : "FALSE";
            $attributes['biobankNetworkCommonSOPs'] = isset($biobank->NetworkCommonSOPs) ? $biobank->NetworkCommonSOPs : "FALSE";
            $attributes['biobankNetworkCommonDataAccessPolicy'] = isset($biobank->NetworkCommonDataAccessPolicy) ? $biobank->NetworkCommonDataAccessPolicy : "FALSE";
            $attributes['biobankNetworkCommonSampleAccessPolicy'] = isset($biobank->NetworkCommonSampleAccessPolicy) ? $biobank->NetworkCommonSampleAccessPolicy : "FALSE";
            $attributes['biobankNetworkCommonMTA'] = isset($biobank->NetworkCommonMTA) ? $biobank->NetworkCommonMTA : "FALSE";
            $attributes['biobankNetworkCommonRepresentation'] = isset($biobank->NetworkCommonRepresentation) ? $biobank->NetworkCommonRepresentation : "FALSE";
            $attributes['biobankNetworkCommonURL'] = isset($biobank->NetworkCommonURL) ? $biobank->NetworkCommonURL : "FALSE";
            $attributes['biobankNetworkURL'] = isset($biobank->NetworkURL) ? $biobank->NetworkURL : "FALSE";
            $attributes['biobankNetworkJuridicalPerson'] = isset($biobank->NetworkJuridicalPerson) ? $biobank->NetworkJuridicalPerson : "FALSE";


            //Collection

            $attributes['collectionID'] = "FR_" . $biobank->identifier . ':collection:' . $biobank->collection_id;
            $attributes['collectionAcronym'] = "FALSE";
            $attributes['collectionName'] = $biobank->collection_name;
            $attributes['collectionDescription'] = "FALSE";
            $attributes['collectionSexMale'] = "TRUE";
            $attributes['collectionSexFemale'] = "TRUE";
            $attributes['collectionSexUnknown'] = "FALSE";
            $attributes['collectionAgeLow'] = "FALSE";
            $attributes['collectionAgeHigh'] = "FALSE";
            $attributes['collectionAgeUnit'] = "FALSE";
            $attributes['collectionAvailableBiologicalSamples'] = "TRUE";
            $attributes['collectionAvailableSurveyData'] = "FALSE";
            $attributes['collectionAvailableImagingData'] = "FALSE";
            $attributes['collectionAvailableMedicalRecords'] = "FALSE";
            $attributes['collectionAvailableNationalRegistries'] = "FALSE";
            $attributes['collectionAvailableGenealogicalRecords'] = "FALSE";
            $attributes['collectionAvailablePhysioBiochemMeasurements'] = "FALSE";
            $attributes['collectionAvailableOther'] = "FALSE";

            //CollectionType

            $attributes['collectionTypeCaseControl'] = "FALSE";
            $attributes['collectionTypeCohort'] = "FALSE";
            $attributes['collectionTypeCrossSectional'] = "FALSE";
            $attributes['collectionTypeLongitudinal'] = "FALSE";
            $attributes['collectionTypeTwinStudy'] = "FALSE";
            $attributes['collectionTypeQualityControl'] = "FALSE";
            $attributes['collectionTypePopulationBased'] = "FALSE";
            $attributes['collectionTypeDiseaseSpecific'] = "FALSE";
            $attributes['collectionTypeBirthCohort'] = "FALSE";
            $attributes['collectionTypeOther'] = "FALSE";


            $attributes['collectionSampleAccessFee'] = "FALSE";
            $attributes['collectionSampleAccessJointProjects'] = "FALSE";
            $attributes['collectionSampleAccessDescription'] = "FALSE";
            $attributes['collectionDataAccessFee'] = "FALSE";
            $attributes['collectionDataAccessJointProjects'] = "FALSE";
            $attributes['collectionDataAccessDescription'] = "FALSE";
            $attributes['collectionSampleAccessURI'] = "FALSE";
            $attributes['collectionDataAccessURI'] = "FALSE";
            $attributes['collectionOrderOfMagnitude'] = "FALSE";
            $attributes['collectionSize'] = "FALSE";
            $attributes['collectionSizeTimestamp'] = "FALSE";


            //nmber of samples 10^n n=number
            //$attributes['biobankSize'] = "1";
            //$attributes['objectClass'] = "biobankClinical"; //TODO implementer la valeur de ce champ Si biobankClinical Diagnosis obligatoire

            $attributes['diagnosisAvailable'] = "urn:miriam:icd:D*";


            $contact = $biobank->getContact();

            //TODO info de contact obligatoire lever un warning si pas affectée pour l export
            if ($contact != null) {

                $attributes['collectionHeadFirstName'] = $contact->first_name;
                $attributes['collectionHeadLastName'] = $contact->last_name;
                $attributes['collectionHeadRole'] = "FALSE";

                $attributes['biobankHeadFirstName'] = $contact->first_name;
                $attributes['biobankHeadLastName'] = $contact->last_name;
                $attributes['biobankHeadRole'] = "Director";

                // contactInfomation
                $attributes['contactID'] = $contact->id;
                $attributes['contactFirstName'] = $contact->first_name;
                $attributes['contactLastName'] = $contact->last_name;
                $attributes['contactPhone'] = CommonTools::getIntPhone($contact->phone);
                $attributes['contactAddress'] = $contact->adresse;
                $attributes['contactZIP'] = $contact->code_postal;
                $attributes['contactCity'] = $contact->ville;
                //$attributes['contactCountry'] = $contact->pays ;
                $attributes['contactCountry'] = "FR"; //TODO get pays avec FR pas integer $contact->pays;
                $attributes['contactIDRef'] = "FALSE";
                $attributes['contactPriority'] = "FALSE";



                //TODO contact email need to be filled
                if (isset($contact->email))
                    $attributes['contactEmail'] = $contact->email;
                else
                    $attributes['contactEmail'] = $contact->email;
            } else {
                $attributes['contactEmail'] = "N/A";
                Yii::log("contact must be filled for export LDIF. Biobank without contact:" . $biobank->name, CLogger::LEVEL_WARNING, "application");
            }
            $this->checkAttributesComplianceWithBBMRI($attributes);
            $result.="dn: biobankID=" . trim($attributes['biobankID']) . ",c=fr,ou=biobanks,dc=directory,dc=bbmri-eric,dc=eu\n"; //TODO recuperer le diagnistique agréger
            foreach ($attributes as $key => $value) {
                if (isset($value))
                //      $result.=$key . ":: " . base64_encode(trim($value)) . "\n";
                    $result.=$key . ":: " . trim($value) . "\n";
            }
            //FIXME mandatory empty line
            $result.="objectClass: biobank\n\n";
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
        //biobank
        $attributesnotempty = array();
        $attributesnotempty[] = 'biobankID';
        $attributesnotempty[] = 'biobankName';
        $attributesnotempty[] = 'biobankCountry';
        $attributesnotempty[] = 'biobankJuridicalPerson';
        $attributesnotempty[] = 'contactIDRef';
        $attributesnotempty[] = 'contactPriority';
        //contactInformation
        $attributesnotempty[] = 'contactID';
        $attributesnotempty[] = 'contactEmail';
        $attributesnotempty[] = 'contactCountry';

        //$attributesnotempty[] = 'contactAddress';
        //$attributesnotempty[] = 'contactCity';
        //$attributesnotempty[] = 'contactZIP';
        //$attributesnotempty[] = 'objectClass';
        //$attributesnotempty[] = 'contactPhone';
        // $attributesnotempty[] = 'biobankMaterialStoredDNA';
//        $attributesnotempty[] = 'biobankMaterialStoredcDNAmRNA';
//        $attributesnotempty[] = 'biobankMaterialStoredmicroRNA';
//        $attributesnotempty[] = 'biobankMaterialStoredWholeBlood';
//        $attributesnotempty[] = 'biobankMaterialStoredPBC';
        /* $attributesnotempty[] = 'biobankMaterialStoredBlood';
          $attributesnotempty[] = 'biobankMaterialStoredPlasma';
          $attributesnotempty[] = 'biobankMaterialStoredSerum';
          $attributesnotempty[] = 'biobankMaterialStoredTissueFrozen';
          $attributesnotempty[] = 'biobankMaterialStoredTissueFFPE';
          $attributesnotempty[] = 'biobankMaterialStoredImmortalizedCellLines';
          $attributesnotempty[] = 'biobankMaterialStoredUrine';
          $attributesnotempty[] = 'biobankMaterialStoredSaliva';
          $attributesnotempty[] = 'biobankMaterialStoredFaeces';
          $attributesnotempty[] = 'biobankMaterialStoredIsolatedPathogen';
          $attributesnotempty[] = 'biobankMaterialStoredOther';
          $attributesnotempty[] = 'biobankPartnerCharterSigned';
          $attributesnotempty[] = 'biobankSize'; */

        foreach ($attributesnotempty as $attributenotempty) {
            if (empty($attributes[$attributenotempty])) {
                $anomalies[$attributenotempty] = $attributenotempty . " is empty";
            }
        }
        ////check syntax compliance
        //check biobankID only alphabetical without accent, and minimum 3 characters
        if (isset($attributes['biobankID']))
            if (!preg_match('/^[a-zA-Z0-9:_ -]{3,}$/', $attributes['biobankID']))
                $anomalies['biobankID'] = "biobankIDis in a bad syntax, only without accent:" . $attributes['biobankID'];
        //The phone number needs to be in the +99999999 international format without spaces.
        if (isset($attributes['contactPhone']))
            if (!preg_match("/^\+[0-9]{11}$/", $attributes['contactPhone']))
                $anomalies['contactPhone'] = "contactPhone is in a bad syntax, needed +999999999";

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
