<?php

/*
 * find :  \$attributes\[\'(\w*)\'\] = (.*);
 * replace : \$this\-\>addToEntry\(\$biobankEntry, '$1',$2\);
 *
 */


require_once(Yii::app()->basePath . '/../../vendor/pear/net_ldap2/Net/LDAP2/LDIF.php');

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
    public function addToEntry(Net_LDAP2_Entry $entry, $name, $value) {
        if (isset($value) && $value != null && $value != '' && isset($name) && $name != null && $name != '')
            $entry->add([$name => $value]);
    }

    /**
     * get biobank infos and convert into an LDIF format
     * @return string
     */
    private function getBiobanksLDIF() {
        $result = "dn: c=fr,ou=biobanks,dc=directory,dc=bbmri-eric,dc=eu
objectClass: country
objectClass: top
c: fr

";
        //FIXME Mandatory empty line here ( TODO use ldif exporter to check syntax)

        $biobanks = Biobank::model()->findAll();

        $entries = [];
        $first = new Net_LDAP2_Entry([], "c=fr,ou=biobanks,dc=directory,dc=bbmri-eric,dc=eu");
        $first->add(['objectClass' => 'country']);
        $first->add(['objectClass' => 'top']);
        $first->add(['c' => 'fr']);
        $entries[] = $first;
        foreach ($biobanks as $biobank) {
            $biobankId = "FR_" . $biobank->identifier;
            $collectionId = $biobank->collection_id;

            /*
             * Declare Entries for biobank, contact and Collection, and set reference to contact in biobank and collection entries
             */
            $biobankEntry = new Net_LDAP2_Entry([], "biobankID=bbmri-eric:ID:" . trim($biobankId) . ",c=fr,ou=biobanks,dc=directory,dc=bbmri-eric,dc=eu\n");
            $collectionEntry = new Net_LDAP2_Entry([], "collectionID=bbmri-eric:ID:" . trim($biobankId) . ":collection:" . str_replace(' ', '', $collectionId) . ",biobankID=bbmri-eric:ID:" . trim($biobankId) . ",c=fr,ou=biobanks,dc=directory,dc=bbmri-eric,dc=eu\n");
            $contactEntry = new Net_LDAP2_Entry([], "contactID=bbmri-eric:contact:" . trim($biobankId) . ",c=fr,ou=contacts,dc=directory,dc=bbmri-eric,dc=eu\n");



            $this->addToEntry($biobankEntry, 'objectClass', "biobank");
            $this->addToEntry($biobankEntry, 'objectClass', "biobankClinical");
            $this->addToEntry($biobankEntry, 'contactIDRef', "bbmri-eric:contact:" . trim($biobankId));
            $this->addToEntry($biobankEntry, 'contactPriority', 2);
            $this->addToEntry($collectionEntry, 'objectClass', "collection");
            $this->addToEntry($collectionEntry, 'contactIDRef', "bbmri-eric:contact:" . trim($biobankId));
            $this->addToEntry($collectionEntry, 'contactPriority', 2);

            $this->addToEntry($contactEntry, 'objectClass', 'contactInformation');
            $this->addToEntry($biobankEntry, 'biobankCountry', 'FR');
            $this->addToEntry($biobankEntry, 'bioResourceReference', $biobank->identifier);
            $this->addToEntry($biobankEntry, 'biobankID', "FR_" . $biobank->identifier);
            $this->addToEntry($biobankEntry, 'biobankName', $biobank->name);
            $this->addToEntry($biobankEntry, 'biobankAcronym', isset($biobank->acronym) ? $biobank->acronym : 'FALSE');
            $this->addToEntry($biobankEntry, 'biobankJuridicalPerson', $biobank->getShortContact());
            if (isset($biobank->presentation_en))
                $this->addToEntry($biobankEntry, 'biobankDescription', $biobank->presentation_en);
            else if (isset($biobank->presentation))
                $this->addToEntry($biobankEntry, 'biobankDescription', $biobank->presentation);
            if (isset($biobank->website))
                $this->addToEntry($biobankEntry, 'biobankURL', $biobank->getWebsiteWithHttp());

            $this->addToEntry($biobankEntry, 'biobankIDRef', "FALSE");
            if (isset($biobank->latitude) && preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $biobank->latitude))
                $this->addToEntry($biobankEntry, 'geoLatitude', str_replace(',', '.', $biobank->latitude));
            if (isset($biobank->longitude) && preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $biobank->longitude))
                $this->addToEntry($biobankEntry, 'geoLongitude', str_replace(',', '.', $biobank->longitude));

            //collaborationsStatus
            $this->addToEntry($biobankEntry, 'collaborationPartnersCommercial', isset($biobank->collaborationPartnersCommercial) ? $biobank->collaborationPartnersCommercial : "FALSE");
            $this->addToEntry($biobankEntry, 'collaborationPartnersNonforprofit', isset($biobank->collaborationPartnersNonforprofit) ? $biobank->collaborationPartnersNonforprofit : "FALSE");


            $this->addToEntry($biobankEntry, 'collectionIDRef', "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkIDRef', "FALSE");
            $this->addToEntry($biobankEntry, 'biobankITSupportAvailable', "FALSE");
            $this->addToEntry($biobankEntry, 'biobankITStaffSize', "FALSE");
            $this->addToEntry($biobankEntry, 'biobankISAvailable', "FALSE");
            $this->addToEntry($biobankEntry, 'biobankHISAvailable', "FALSE");

            //TODO each biobank need to sign a chart between bbmri and the biobank (TODO to discuss)
            $this->addToEntry($biobankEntry, 'biobankPartnerCharterSigned', isset($biobank->PartnerCharterSigned) ? $biobank->PartnerCharterSigned : "FALSE");


            //Biobank material
            //TODO flase in cappital
            $this->addToEntry($collectionEntry, 'materialStoredDNA', isset($biobank->materialStoredDNA) ? $biobank->materialStoredDNA : "FALSE");
            $this->addToEntry($collectionEntry, 'materialStoredPlasma', isset($biobank->materialStoredPlasma) ? $biobank->materialStoredPlasma : "FALSE");
            $this->addToEntry($collectionEntry, 'materialStoredSerum', isset($biobank->materialStoredSerum) ? $biobank->materialStoredSerum : "FALSE");
            $this->addToEntry($collectionEntry, 'materialStoredUrine', "FALSE");
            $this->addToEntry($collectionEntry, 'materialStoredSaliva', "FALSE");
            $this->addToEntry($collectionEntry, 'materialStoredFaeces', "FALSE");
            $this->addToEntry($collectionEntry, 'materialStoredOther', "FALSE");
            $this->addToEntry($collectionEntry, 'materialStoredRNA', "FALSE");
            $this->addToEntry($collectionEntry, 'materialStoredBlood', "FALSE");
            $this->addToEntry($collectionEntry, 'materialStoredTissueFrozen', isset($biobank->materialStoredTissueFrozen) ? $biobank->materialStoredTissueFrozen : "FALSE");
            $this->addToEntry($collectionEntry, 'materialStoredTissueFFPE', isset($biobank->materialStoredTissueFFPE) ? $biobank->materialStoredTissueFFPE : "FALSE");
            $this->addToEntry($collectionEntry, 'materialStoredCellLines', "FALSE");
            $this->addToEntry($collectionEntry, 'materialStoredPathogen', "FALSE");


            $this->addToEntry($biobankEntry, 'temperatureRoom', "FALSE");
            $this->addToEntry($biobankEntry, 'temperature2to10', "FALSE");
            $this->addToEntry($biobankEntry, 'temperature18to35', "FALSE");
            $this->addToEntry($biobankEntry, 'temperature60to85', "FALSE");
            $this->addToEntry($biobankEntry, 'temperatureLN', "FALSE");
            $this->addToEntry($biobankEntry, 'temperatureOther', "FALSE");


            // $this->addToEntry($biobankEntry, 'biobankMaterialStoredcDNAmRNA',"FALSE");
            // $this->addToEntry($biobankEntry, 'biobankMaterialStoredmicroRNA',"FALSE");
            // $this->addToEntry($biobankEntry, 'biobankMaterialStoredWholeBlood',"FALSE");
            // $this->addToEntry($biobankEntry, 'biobankMaterialStoredPBC',"FALSE");
            // $this->addToEntry($biobankEntry, 'biobankMaterialStoredTissueCryo',"FALSE");
            // $this->addToEntry($biobankEntry, 'biobankMaterialStoredTissueParaffin',"FALSE");
            // $this->addToEntry($biobankEntry, 'biobankMaterialStoredImmortalizedCellLines',"FALSE");
            //  $this->addToEntry($biobankEntry, 'biobankMaterialStoredIsolatedPathogen',"FALSE");
            //Biobank Network

            $this->addToEntry($biobankEntry, 'biobankNetworkID', "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkName', isset($biobank->NetworkName) ? $biobank->NetworkName : "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkAcronym', isset($biobank->networkAcronym) ? $biobank->networkAcronym : "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkDescription', isset($biobank->NetworkDescription) ? $biobank->NetworkDescription : "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkCommonCollectionFocus', isset($biobank->NetworkCommonCollectionFocus) ? $biobank->NetworkCommonCollectionFocus : "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkCommonCharter', isset($biobank->NetworkCommonCharter) ? $biobank->NetworkCommonCharter : "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkCommonSOPs', isset($biobank->NetworkCommonSOPs) ? $biobank->NetworkCommonSOPs : "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkCommonDataAccessPolicy', isset($biobank->NetworkCommonDataAccessPolicy) ? $biobank->NetworkCommonDataAccessPolicy : "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkCommonSampleAccessPolicy', isset($biobank->NetworkCommonSampleAccessPolicy) ? $biobank->NetworkCommonSampleAccessPolicy : "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkCommonMTA', isset($biobank->NetworkCommonMTA) ? $biobank->NetworkCommonMTA : "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkCommonRepresentation', isset($biobank->NetworkCommonRepresentation) ? $biobank->NetworkCommonRepresentation : "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkCommonURL', isset($biobank->NetworkCommonURL) ? $biobank->NetworkCommonURL : "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkURL', isset($biobank->NetworkURL) ? $biobank->NetworkURL : "FALSE");
            $this->addToEntry($biobankEntry, 'biobankNetworkJuridicalPerson', isset($biobank->NetworkJuridicalPerson) ? $biobank->NetworkJuridicalPerson : "FALSE");


            //Collection

            $this->addToEntry($collectionEntry, 'collectionID', "FR_" . $biobank->identifier . ':collection:' . $biobank->collection_id);
            $this->addToEntry($collectionEntry, 'collectionAcronym', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionName', $biobank->collection_name);
            $this->addToEntry($collectionEntry, 'collectionDescription', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionSexMale', "TRUE");
            $this->addToEntry($collectionEntry, 'collectionSexFemale', "TRUE");
            $this->addToEntry($collectionEntry, 'collectionSexUnknown', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionAgeLow', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionAgeHigh', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionAgeUnit', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionAvailableBiologicalSamples', "TRUE");
            $this->addToEntry($collectionEntry, 'collectionAvailableSurveyData', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionAvailableImagingData', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionAvailableMedicalRecords', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionAvailableNationalRegistries', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionAvailableGenealogicalRecords', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionAvailablePhysioBiochemMeasurements', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionAvailableOther', "FALSE");

            //CollectionType

            $this->addToEntry($collectionEntry, 'collectionTypeCaseControl', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionTypeCohort', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionTypeCrossSectional', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionTypeLongitudinal', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionTypeTwinStudy', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionTypeQualityControl', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionTypePopulationBased', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionTypeDiseaseSpecific', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionTypeBirthCohort', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionTypeOther', "FALSE");


            $this->addToEntry($collectionEntry, 'collectionSampleAccessFee', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionSampleAccessJointProjects', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionSampleAccessDescription', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionDataAccessFee', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionDataAccessJointProjects', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionDataAccessDescription', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionSampleAccessURI', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionDataAccessURI', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionOrderOfMagnitude', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionSize', "FALSE");
            $this->addToEntry($collectionEntry, 'collectionSizeTimestamp', "FALSE");


            //nmber of samples 10^n n=number
            //$this->addToEntry($biobankEntry, 'biobankSize',"1");
            //$this->addToEntry($biobankEntry, 'objectClass',"biobankClinical"); //TODO implementer la valeur de ce champ Si biobankClinical Diagnosis obligatoire

            $this->addToEntry($collectionEntry, 'diagnosisAvailable', "urn:miriam:icd:D*");


            $contact = $biobank->getContact();

            //TODO info de contact obligatoire lever un warning si pas affectée pour l export
            if ($contact != null) {

                $this->addToEntry($biobankEntry, 'collectionHeadFirstName', $contact->first_name);
                $this->addToEntry($biobankEntry, 'collectionHeadLastName', $contact->last_name);
                $this->addToEntry($biobankEntry, 'collectionHeadRole', "FALSE");

                $this->addToEntry($biobankEntry, 'biobankHeadFirstName', $contact->first_name);
                $this->addToEntry($biobankEntry, 'biobankHeadLastName', $contact->last_name);
                $this->addToEntry($biobankEntry, 'biobankHeadRole', "Director");

                // contactInfomation
                $this->addToEntry($contactEntry, 'contactID', $contact->id);
                $this->addToEntry($contactEntry, 'contactFirstName', $contact->first_name);
                $this->addToEntry($contactEntry, 'contactLastName', $contact->last_name);
                $this->addToEntry($contactEntry, 'contactPhone', CommonTools::getIntPhone($contact->phone));

                $this->addToEntry($contactEntry, 'contactAddress', $contact->adresse);
                $this->addToEntry($contactEntry, 'contactZIP', $contact->code_postal);
                $this->addToEntry($contactEntry, 'contactCity', $contact->ville);
                //$this->addToEntry($contactEntry, 'contactCountry',$contact->pays );
                $this->addToEntry($contactEntry, 'contactCountry', "FR"); //TODO get pays avec FR pas integer $contact->pays);
                //TODO contact email need to be filled
                if (isset($contact->email))
                    $this->addToEntry($contactEntry, 'contactEmail', $contact->email);
                else
                    $this->addToEntry($contactEntry, 'contactEmail', 'N/A');
            } else {
                $this->addToEntry($contactEntry, 'contactEmail', "N/A");
                Yii::log("contact must be filled for export LDIF. Biobank without contact:" . $biobank->name, CLogger::LEVEL_WARNING, "application");
            }

            $result.="objectClass: biobank\n\n";
            $entries[] = $biobankEntry;
            $entries[] = $collectionEntry;
            $entries[] = $contactEntry;
        }
        $ldif = new Net_LDAP2_LDIF('protected/runtime/tmp.ldif', 'w');

        $ldif->write_entry($entries);

        $fh = fopen('protected/runtime/tmp.ldif', 'r');
        $result = fread($fh, 10000000);
//        fwrite($fh, $result);
        fclose($fh);
        $this->checkResult();
        return $result;
    }

    public function checkResult($ldif = null) {
        if ($ldif == null)
            $ldif = new Net_LDAP2_LDIF('protected/runtime/tmp2.ldif', 'r');
        if ($ldif->error()) {
            $error_o = $ldif->error(); // get Net_LDAP2_Error object on error
            die('ERROR: ' . $error_o->getMessage());
        }

// parse the entries of the LDIF file into objects
        do {
            $entry = $ldif->read_entry();
            if ($ldif->error()) {
                // in case of error, print error.
                // here we use the shorthand parameter, so error()
                // returns a string instead of a Net_LDAP2_Object
                die('ERROR AT INPUT LINE ' . $ldif->error_lines() . ': ' . $ldif->error(true) . "\n");
            } else {

                $attributes = $entry->getValues();
                //$this->checkAttributesComplianceWithBBMRI($attributes);
                // Here we just print the entries DN
                //  echo 'sucessfully parsed ' . $entry->dn() . "\n";
            }
        } while (!$ldif->eof());

// We should call done() once we are finished
        $ldif->done();
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
