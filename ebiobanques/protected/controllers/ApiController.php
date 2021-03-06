<?php

/*
  'find :  \$attributes\[\'(\w*)\'\] =',;
 * replace : \$this\-\>addToEntry\(\$biobankEntry, '$1',$2\);
 *
 */

class ApiController extends Controller
{
    /**
     * no layout
     * @var type
     */
    public $layout = '';
    /*
     * Temporary file path for ldif file
     *
     *
     */
    Const TEMPFILE = 'protected/runtime/tmp.ldif';
    // Members
    /**
     * Key which has to be in HTTP USERNAME and PASSWORD headers
     */

    
    /**
     * List of attributes needing
     * @return array
     */
    public function getBooleanAttributes() {
        return [
            'collectionSexFemale',
            'collectionSexMale',
            'collectionSexUndiferrentiated',
            'collectionSexUnknown',
            'biobankHISAvailable',
            'biobankISAvailable',
            'biobankITSupportAvailable',
            'biobankNetworkCommonCharter',
            'biobankNetworkCommonCollectionFocus',
            'biobankNetworkCommonDataAccessPolicy',
            'biobankNetworkCommonMTA',
            'biobankNetworkCommonRepresentation',
            'biobankNetworkCommonSampleAccessPolicy',
            'biobankNetworkCommonSOPs',
            'biobankNetworkCommonURL',
            'biobankNetworkCommonImageAccesPolicy',
            'biobankNetworkCommonImageMTA',
            'biobankPartnerCharterSigned',
            'collaborationPartnersCommercial',
            'collaborationPartnersNonforprofit',
            'collectionAvailableBiologicalSamples',
            'collectionAvailableGenealogicalRecords',
            'collectionAvailableImagingData',
            'collectionAvailableMedicalRecords',
            'collectionAvailableNationalRegistries',
            'collectionAvailableOther',
            'collectionAvailablePhysioBiochemMeasurements',
            'collectionAvailableSurveyData',
            'collectionDataAccessFee',
            'collectionDataAccessJointProjects',
            'collectionSampleAccessFee',
            'collectionSampleAccessJointProjects',
            'collectionTypeBirthCohort',
            'collectionTypeCaseControl',
            'collectionTypeCohort',
            'collectionTypeCrossSectional',
            'collectionTypeDiseaseSpecific',
            'collectionTypeLongitudinal',
            'collectionTypePopulationBased',
            'collectionTypeQualityControl',
            'collectionTypeTwinStudy',
            'materialStoredBlood',
            'materialStoredDNA',
            'materialStoredFaeces',
            'materialStoredImmortalizedCellLines',
            'materialStoredIsolatedPathogen',
            'materialStoredPlasma',
            'materialStoredRNA',
            'materialStoredSaliva',
            'materialStoredSerum',
            'materialStoredTissueFFPE',
            'materialStoredTissueFrozen',
            'materialStoredUrine',
            'temperature18to35',
            'temperature60to85',
            'temperature2to10',
            'temperatureLN',
            'temperatureRoom'
        ];
    }

    public function getStringAttributes() {
        return [
            'biobankAcronym',
            'biobankDescription',
            'biobankHeadFirstName',
            'biobankHeadLastName',
            'biobankHeadRole',
            'biobankJuridicalPerson',
            'biobankNetworkIDRef',
            'biobankNetworkJuridicalPerson',
            'biobankURL',
            'biobankCapabilities',
            'biobankOperationalStandards',
            'biobankOthersStandards',
            'bioresourceReference',
            'collectionDataAccessDescription',
            'collectionDataAccessURI',
            'collectionHeadFirstName',
            'collectionHeadLastName',
            'collectionHeadRole',
            'collectionSampleAccessDescription',
            'collectionSampleAccessURI',
            'collectionTypeOther',
            'contactAddress',
            'contactEmail',
            'contactIDRef',
            'diagnosisAvailable',
            'materialStoredOther',
            'temperatureOther',
            'biobankID',
            'biobankName',
            'biobankNetworkID',
            'biobankNetworkAcronym',
            'biobankNetworkDescription',
            'biobankNetworkName',
            'biobankNetworkURL',
            'collectionAcronym',
            'collectionAgeUnit',
            'collectionDescription',
            'collectionID',
            'collectionName',
            'contactCity',
            'contactFirstName',
            'contactID',//
            'contactLastName',
            'contactZIP',
            'latitude',
            'longitude',
            'biobankCountry',//
            'collectionSize',
            //'biobankITStaffSize',
            'collectionSex',
        ];
    }

    public function getIntAttributes() {
        return
                [
                    'biobankITStaffSize',
                    'collectionAgeHigh',
                    'collectionAgeLow',
                    'collectionOrderOfMagnitude',
                    'collectionSizeTimestamp',
                    'contactPriority',
        ];
    }

    public function getMandatoryAttributes() {
        return [
            
            // biobank
            //contactInformation:
            'contactID',
            'biobankCountry',
            'biobankID',
            'biobankName',
            'biobankPartnerCharterSigned',//
            'contactPriority',
           // 'biobankITStaffSize',
//            'contactEmail',
//            'contactCountry',
//             biobank:
//            'contactIDRef',      
//            'biobankJuridicalPerson',
            
           // collection:
            'collectionID',//
            'collectionName',//
            'collectionType',//
            'collectionDataTypes',//
            'collectionOrderOfMagnitude',//
            'collectionSize',//
            'collectionAgeUnit',//
//            'materialStoredDNA',
//            'materialStoredPlasma',
//            'materialStoredSerum',
//            'materialStoredUrine',
//            'materialStoredSaliva',
//            'materialStoredFaeces',
//            'materialStoredOther',
//            'materialStoredRNA',
//            'materialStoredBlood',
//            'materialStoredTissueFrozen',
//            'materialStoredTissueFFPE',
//            'materialStoredImmortalizedCellLines',
//            'materialStoredIsolatedPathogen',
            
            /*il faut changer cette partie et creer une seuel variable : "collectionType  qui regroupe tous les types suivant"*/
            
            
          /* 'collectionTypeCaseControl',
            'collectionTypeCohort',
            'collectionTypeCrossSectional',
            'collectionTypeLongitudinal',
            'collectionTypeTwinStudy',
            'collectionTypeQualityControl',
            'collectionTypePopulationBased',
            'collectionTypeDiseaseSpecific',
            'collectionTypeBirthCohort',
            'collectionTypeOther',
            */
            
            
//           biobankNetwork:
           // 'contactIDRef',
            //'contactPriority',
            
            'biobankNetworkID',//
            'biobankNetworkName',//
            'biobankNetworkCommonCollectionFocus',//
            'biobankNetworkCommonCharter',//
            'biobankNetworkCommonSOPs',//
            'biobankNetworkCommonDataAccessPolicy',//
            'biobankNetworkCommonSampleAccessPolicy',//
            'biobankNetworkCommonMTA',//
            'biobankNetworkCommonImageAccesPolicy',//
            'biobankNetworkCommonImageMTA',//
            'biobankNetworkCommonRepresentation',//
            'biobankNetworkCommonURL',//
            

            
           
        ];
    }

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
        if (isset($value) && $value !== null && $value !== '' && isset($name) && $name != null && $name != '')
            if ($this->checktype($name, $value)) {
                if ($value != 'FALSE' || $value == 0 || in_array($name, $this->getMandatoryAttributes())) {
                    $entry->add([$name => $value]);
                }
            } else {
                Yii::log("Bad type : $name / $value", CLogger::LEVEL_WARNING);
            }

        return $entry;
    }

    public function checkType($name, $value) {
        if (in_array($name, $this->getBooleanAttributes()) && !in_array($value, ['FALSE', 'TRUE']))
            return false;
        if (in_array($name, $this->getStringAttributes()) && $value != 'FALSE' && !is_string($value))
            return false;
        if (in_array($name, $this->getIntAttributes()) && $value != 'FALSE' && !is_int($value))
            return false;
        return true;
    }

    /**
     * get biobank infos and convert into an LDIF format
     * @return string
     */
    private function getBiobanksLDIF() {

        //FIXME Mandatory empty line here ( TODO use ldif exporter to check syntax)

        $biobanks = Biobank::model()->findAll();

        $entries = [];
        $first = new Net_LDAP2_Entry([], "c=fr,ou=biobanks,dc=directory,dc=bbmri-eric,dc=eu");
        $first->add(['objectClass' => ['country', 'top']]);
        $first->add(['c' => 'fr']);
        $entries[] = $first;
//
        $second = new Net_LDAP2_Entry([], "c=fr,ou=contacts,dc=directory,dc=bbmri-eric,dc=eu");
        $second->add(['objectClass' => ['country', 'top']]);
        $second->add(['c' => 'fr']);
        $entries[] = $second;
//
        $third = new Net_LDAP2_Entry([], "c=fr,ou=networks,dc=directory,dc=bbmri-eric,dc=eu");
        $third->add(['objectClass' => ['country', 'top']]);
        $third->add(['c' => 'fr']);
        $entries[] = $third;
        
        $fourth = new Net_LDAP2_Entry([], "c=fr,ou=collections,dc=directory,dc=bbmri-eric,dc=eu");
        $fourth->add(['objectClass' => ['country', 'top']]);
        $fourth->add(['c' => 'fr']);
        $entries[] = $fourth;
        


        foreach ($biobanks as $biobank) {
            $biobankId = trim("FR_" . $biobank->identifier);
            $collectionId = "bbmri-eric:ID:" . $biobankId . ":collection:mainCollection";
            $contactId = "bbmri-eric:contactID:" . $biobank->identifier;
            $networkId = "bbmri-eric_bbnetID:" ;

            /*
             * Declare Entries for biobank, contact, network and Collection, and set reference to contact in biobank and collection entries
             */
            $biobankEntry = new Net_LDAP2_Entry([], "biobankID=bbmri-eric:ID:" . $biobankId . ",c=fr,ou=biobanks,dc=directory,dc=bbmri-eric,dc=eu");
            $collectionEntry = new Net_LDAP2_Entry([], "collectionID=" . $collectionId . ",biobankID=bbmri-eric:ID:" . $biobankId . ",c=fr,ou=collections,dc=directory,dc=bbmri-eric,dc=eu");
            $contactEntry = new Net_LDAP2_Entry([], "contactID=" . $contactId . ",c=fr,ou=contacts,dc=directory,dc=bbmri-eric,dc=eu");
            $networkEntry = new Net_LDAP2_Entry([], "networkID=" . $networkId . ",c=fr,ou=network,dc=directory,dc=bbmri-eric,dc=eu");
            
            

                /**************OBJECT CLASS : BIOBANK**************/
            $biobankEntry = $this->addToEntry($biobankEntry, 'objectClass', ["biobank", "biobankClinical"]);
            // $biobankEntry=$this->addToEntry($biobankEntry, 'objectClass', "biobankClinical");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankID', "bbmri-eric:ID:" . $biobankId);
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankName', $biobank->name);
            $biobankEntry = $this->addToEntry($biobankEntry, 'contactID', "bbmri-eric:contactID:" . $biobank->identifier);
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankAcronym', isset($biobank->acronym) && ($biobank->acronym != "") ? $biobank->acronym : " ");
            
           if (isset($biobank->presentation_en)) {
                
               $biobankEntry = $this->addToEntry($biobankEntry, 'biobankDescription', $biobank->presentation_en);
            } else {
                if (isset($biobank->presentation)) {
                    $biobankEntry = $this->addToEntry($biobankEntry, 'biobankDescription', $biobank->presentation);
                }
            }
            $biobankEntry = $this->addToEntry($biobankEntry, 'bioResourceReference', $biobank->identifier);
            
            if (isset($biobank->website))
                $biobankEntry = $this->addToEntry($biobankEntry, 'biobankURL', $biobank->getWebsiteWithHttp());
               //            [16:56:49] Petr Holub: and biobankJuridicalPerson is formal name for the responsible entity => not a person, while what comes here seems much like a person
//[16:57:46] Petr Holub: i.e., biobankJuridicalPerson should be name of the institution hosting the biobank

            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankJuridicalPerson', $biobank->getShortContact());
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankCountry', 'FR');  
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankITSupportAvailable', "FALSE");
            //Must be an integer, usse 0 if no information
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankITStaffSize',0);
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankISAvailable', "FALSE");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankHISAvailable', "FALSE");
            
             // each biobank need to sign a chart between bbmri and the biobank 
            //Meeting Biobanques 03/08/2016 : decision : Yes always.
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankPartnerCharterSigned',  "TRUE");
            $biobankEntry = $this->addToEntry($biobankEntry, 'contactPriority', 2);
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankCapabilities', "FALSE");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankOperationalStandards', "FALSE");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankOthersStandards', "FALSE");
            
            
            if (isset($biobank->latitude) && preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $biobank->latitude))
                $biobankEntry = $this->addToEntry($biobankEntry, 'latitude', str_replace(',', '.', $biobank->latitude));
            if (isset($biobank->longitude) && preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $biobank->longitude))
                $biobankEntry = $this->addToEntry($biobankEntry, 'longitude', str_replace(',', '.', $biobank->longitude));
            
            /**************OBJECT CLASS : COLLECTION**************/
            
            $collectionEntry = $this->addToEntry($collectionEntry, 'objectClass', "collection");
            $collectionEntry = $this->addToEntry($collectionEntry, 'contactID', "bbmri-eric:contactID:" . $biobank->identifier);
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionCountry', 'FR');  
            $collectionEntry = $this->addToEntry($collectionEntry, 'contactPriority', 2);
              
            /**************OBJECT CLASS : Contact/Persosns**************/

            $contactEntry = $this->addToEntry($contactEntry, 'objectClass', 'contactInformation');
            
            
            
 //collaborationsStatus
            // Meeting Biobanques 03/08/2016 : decision : Yes by default for biobanks partner collaboration
            $biobankEntry = $this->addToEntry($biobankEntry, 'collaborationPartnersCommercial', isset($biobank->collaborationPartnersCommercial) && $biobank->collaborationPartnersCommercial != "" ? $biobank->collaborationPartnersCommercial : 'TRUE');
            $biobankEntry = $this->addToEntry($biobankEntry, 'collaborationPartnersNonforprofit', isset($biobank->collaborationPartnersNonforprofit) && $biobank->collaborationPartnersNonforprofit != '' ? $biobank->collaborationPartnersNonforprofit : 'TRUE');


            

           

               // network information
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkID',"bbmri-eric_bbnetID:");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkName',NULL);
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonCollectionFocus', isset($biobank->NetworkCommonCollectionFocus) ? $biobank->NetworkCommonCollectionFocus : "FALSE");
            $biovalbankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonCharter', isset($biobank->NetworkCommonCharter) ? $biobank->NetworkCommonCharter : "FALSE");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonSOPs', isset($biobank->NetworkCommonSOPs) ? $biobank->NetworkCommonSOPs : "FALSE");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonDataAccessPolicy', isset($biobank->NetworkCommonDataAccessPolicy) ? $biobank->NetworkCommonDataAccessPolicy : "FALSE");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonSampleAccessPolicy', isset($biobank->NetworkCommonSampleAccessPolicy) ? $biobank->NetworkCommonSampleAccessPolicy : "FALSE");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonMTA', isset($biobank->NetworkCommonMTA) ? $biobank->NetworkCommonMTA : "FALSE");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonRepresentation', isset($biobank->NetworkCommonRepresentation) ? $biobank->NetworkCommonRepresentation : "FALSE");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonURL', isset($biobank->NetworkCommonURL) ? $biobank->NetworkCommonURL : "FALSE");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonImageAccesPolicy', isset($biobank->NetworkCommonImageAccesPolicy) ? $biobank->NetworkCommonImageAccesPolicy : "FALSE");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonImageMTA', isset($biobank->common_image_mta) ? $biobank->common_image_mta : "FALSE");

          
              
          /*    
              
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankITSupportAvailable', "FALSE");
            //Must be an integer, usse 0 if no information
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankITStaffSize', 0);
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankISAvailable', "FALSE");
            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankHISAvailable', "FALSE");

           */


//            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankSize', isset($biobank->nb_total_samples) && $biobank->nb_total_samples != '' ? $biobank->nb_total_samples : "1x10³");
            //x  $biobankEntry = $this->addToEntry($biobankEntry, 'biobankSize', "1x10³");
            //TODO flase in cappital
            $collectionEntry = $this->addToEntry($collectionEntry, 'materialStoredDNA', isset($biobank->materialStoredDNA) && $biobank->materialStoredDNA != '' ? $biobank->materialStoredDNA : "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'materialStoredPlasma', isset($biobank->materialStoredPlasma) && $biobank->materialStoredPlasma != '' ? $biobank->materialStoredPlasma : "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'materialStoredSerum', isset($biobank->materialStoredSerum) && $biobank->materialStoredSerum != '' ? $biobank->materialStoredSerum : "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'materialStoredUrine', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'materialStoredSaliva', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'materialStoredFaeces', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'materialStoredOther', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'materialStoredRNA', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'materialStoredBlood', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'materialStoredTissueFrozen', isset($biobank->materialStoredTissueFrozen) && $biobank->materialStoredTissueFrozen != '' ? $biobank->materialStoredTissueFrozen : "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'materialStoredTissueFFPE', isset($biobank->materialStoredTissueFFPE) && $biobank->materialStoredTissueFrozen != '' ? $biobank->materialStoredTissueFFPE : "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'materialStoredImmortalizedCellLines', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'materialStoredIsolatedPathogen', "FALSE");


            $collectionEntry = $this->addToEntry($collectionEntry, 'temperatureRoom', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'temperature2to10', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'temperature18to35', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'temperature60to85', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'temperatureLN', "TRUE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'temperatureOther', "FALSE");


            // $biobankEntry=$this->addToEntry($biobankEntry, 'biobankMaterialStoredcDNAmRNA',"FALSE");
            // $biobankEntry=$this->addToEntry($biobankEntry, 'biobankMaterialStoredmicroRNA',"FALSE");
            // $biobankEntry=$this->addToEntry($biobankEntry, 'biobankMaterialStoredWholeBlood',"FALSE");
            // $biobankEntry=$this->addToEntry($biobankEntry, 'biobankMaterialStoredPBC',"FALSE");
            // $biobankEntry=$this->addToEntry($biobankEntry, 'biobankMaterialStoredTissueCryo',"FALSE");
            // $biobankEntry=$this->addToEntry($biobankEntry, 'biobankMaterialStoredTissueParaffin',"FALSE");
            // $biobankEntry=$this->addToEntry($biobankEntry, 'biobankMaterialStoredImmortalizedCellLines',"FALSE");
            //  $biobankEntry=$this->addToEntry($biobankEntry, 'biobankMaterialStoredIsolatedPathogen',"FALSE");
            //Biobank Network
           
//           $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkName', isset($biobank->NetworkName) ? $biobank->NetworkName : "FALSE");

////            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkAcronym', isset($biobank->networkAcronym) ? $biobank->networkAcronym : "FALSE");
//            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkDescription', isset($biobank->NetworkDescription) ? $biobank->NetworkDescription : "FALSE");
//            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonCollectionFocus', isset($biobank->NetworkCommonCollectionFocus) ? $biobank->NetworkCommonCollectionFocus : "FALSE");
//            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonCharter', isset($biobank->NetworkCommonCharter) ? $biobank->NetworkCommonCharter : "FALSE");
//            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonSOPs', isset($biobank->NetworkCommonSOPs) ? $biobank->NetworkCommonSOPs : "FALSE");
//            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonDataAccessPolicy', isset($biobank->NetworkCommonDataAccessPolicy) ? $biobank->NetworkCommonDataAccessPolicy : "FALSE");
//            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonSampleAccessPolicy', isset($biobank->NetworkCommonSampleAccessPolicy) ? $biobank->NetworkCommonSampleAccessPolicy : "FALSE");
//            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonMTA', isset($biobank->NetworkCommonMTA) ? $biobank->NetworkCommonMTA : "FALSE");
//            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonRepresentation', isset($biobank->NetworkCommonRepresentation) ? $biobank->NetworkCommonRepresentation : "FALSE");
//            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkCommonURL', isset($biobank->NetworkCommonURL) ? $biobank->NetworkCommonURL : "FALSE");
//            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkURL', isset($biobank->NetworkURL) ? $biobank->NetworkURL : "FALSE");
//            $biobankEntry = $this->addToEntry($biobankEntry, 'biobankNetworkJuridicalPerson', isset($biobank->NetworkJuridicalPerson) ? $biobank->NetworkJuridicalPerson : "FALSE");
//
            //Collection

            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionID', $collectionId);
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionAcronym', "FALSE");

            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionName', isset($biobank->collection_name) && ($biobank->collection_name != "") ? $biobank->collection_name : 'FALSE');
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionDataTypes', 'BIOLOGICAL_SAMPLES' );
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionType', 'SAMPLE');
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionDescription', isset($biobank->collection_name) ? $biobank->collection_name : 'FALSE');
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionSex', "FEMALE,MALE");
        //    $collectionEntry = $this->addToEntry($collectionEntry, 'collectionSexMale', "TRUE");
        //    $collectionEntry = $this->addToEntry($collectionEntry, 'collectionSexFemale', "TRUE");
        //    $collectionEntry = $this->addToEntry($collectionEntry, 'collectionSexUnknown', "FALSE");
//            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionAgeLow', "FALSE");
//            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionAgeHigh', "FALSE");
//            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionAgeUnit', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionAvailableBiologicalSamples', "TRUE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionAvailableSurveyData', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionAvailableImagingData', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionAvailableMedicalRecords', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionAvailableNationalRegistries', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionAvailableGenealogicalRecords', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionAvailablePhysioBiochemMeasurements', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionAvailableOther', "FALSE");

            //CollectionType

            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionTypeCaseControl', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionTypeCohort', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionTypeCrossSectional', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionTypeLongitudinal', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionTypeTwinStudy', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionTypeQualityControl', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionTypePopulationBased', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionTypeDiseaseSpecific', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionTypeBirthCohort', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionTypeOther', "FALSE");


            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionSampleAccessFee', $biobank->collectionSampleAccessFee);
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionSampleAccessJointProjects', $biobank->collectionSampleAccessJointProjects);
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionSampleAccessDescription', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionDataAccessFee', $biobank->collectionDataAccessFee);
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionDataAccessJointProjects', $biobank->collectionDataAccessJointProjects);
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionDataAccessDescription', "FALSE");
            // $collectionEntry = $this->addToEntry($collectionEntry, 'collectionSampleAccessURI', "FALSE");
            // $collectionEntry = $this->addToEntry($collectionEntry, 'collectionDataAccessURI', "FALSE");
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionOrderOfMagnitude', 3);
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionSize', $biobank->nb_total_samples);
            $collectionEntry = $this->addToEntry($collectionEntry, 'collectionAgeUnit', "FALSE");
            //   $collectionEntry = $this->addToEntry($collectionEntry, 'collectionSizeTimestamp', "FALSE");
            //nmber of samples 10^n n=number
            //$biobankEntry=$this->addToEntry($biobankEntry, 'biobankSize',"1");
            //$biobankEntry=$this->addToEntry($biobankEntry, 'objectClass',"biobankClinical"); //TODO implementer la valeur de ce champ Si biobankClinical Diagnosis obligatoire
            $icdString = '';
            $listOfIcd = $biobank->getListOfIcd();
            if (($listOfIcd) != []) {
                foreach ($listOfIcd as $icd) {
                    $icdString .= "icd:$icd, ";
                }
                $icdString = trim($icdString, " ");
                $icdString = trim($icdString, ",");
            } else {
                $icdString = "icd:D*";
            }


            $collectionEntry = $this->addToEntry($collectionEntry, 'diagnosisAvailable', "urn:miriam:$icdString");

            $contact = $biobank->getContact();

            //TODO info de contact obligatoire lever un warning si pas affectée pour l export
            if ($contact != null) {

                $collectionEntry = $this->addToEntry($collectionEntry, 'collectionHeadFirstName', ucfirst(strtolower($contact->first_name)));
                $collectionEntry = $this->addToEntry($collectionEntry, 'collectionHeadLastName', ucfirst(strtolower($contact->last_name)));
                $collectionEntry = $this->addToEntry($collectionEntry, 'collectionHeadRole', "FALSE");

                $biobankEntry = $this->addToEntry($biobankEntry, 'biobankHeadFirstName', ucfirst(strtolower($contact->first_name)));
                $biobankEntry = $this->addToEntry($biobankEntry, 'biobankHeadLastName', ucfirst(strtolower($contact->last_name)));
                $biobankEntry = $this->addToEntry($biobankEntry, 'biobankHeadRole', "Director");

                // contactInfomation
                $contactEntry = $this->addToEntry($contactEntry, 'contactID', $contactId);

                $contactEntry = $this->addToEntry($contactEntry, 'contactFirstName', ucfirst(strtolower($contact->first_name)));
                $contactEntry = $this->addToEntry($contactEntry, 'contactLastName', ucfirst(strtolower($contact->last_name)));
                $contactEntry = $this->addToEntry($contactEntry, 'contactPhone', CommonTools::getIntPhone($contact->phone));

                $contactEntry = $this->addToEntry($contactEntry, 'contactAddress', $contact->adresse);
                $contactEntry = $this->addToEntry($contactEntry, 'contactZIP', $contact->code_postal);
                $contactEntry = $this->addToEntry($contactEntry, 'contactCity', $contact->ville);
                //$contactEntry=$this->addToEntry($contactEntry, 'contactCountry',$contact->pays );
                $contactEntry = $this->addToEntry($contactEntry, 'contactCountry', "FR"); //TODO get pays avec FR pas integer $contact->pays);
                //TODO contact email need to be filled
                if (isset($contact->email))
                    $contactEntry = $this->addToEntry($contactEntry, 'contactEmail', $contact->email);
                else
                    $contactEntry = $this->addToEntry($contactEntry, 'contactEmail', 'N/A');
            } else {

                Yii::log("contact must be filled for export LDIF. Biobank without contact:" . $biobank->identifier . ' - ' . $biobank->name, CLogger::LEVEL_WARNING, "application");
            }
            if ($contact != null) {
                $entries[] = $biobankEntry;

                $entries[] = $collectionEntry;

                $entries[] = $contactEntry;
            }
        }


        $ldif = new Net_LDAP2_LDIF(ApiController::TEMPFILE, 'w+');
        $ldif->write_entry($entries);
        $ldif->done();
        $fh = fopen(ApiController::TEMPFILE, 'r');
        $result = fread($fh, 10000000);
        fclose($fh);
        //Used to check LDIF syntax
        $this->checkResult();
        return $result;
    }

    public function checkResult() {

        $ldif = new Net_LDAP2_LDIF(ApiController::TEMPFILE, 'r');
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
                $this->checkAttributesComplianceWithBBMRI($attributes);
                // Here we just print the entries DN
//                echo 'sucessfully parsed ' . $entry->dn() . "\n";
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
        
        $biobankattributesnotempty = array();
        $collectionattributesnotempty = array();
        $contactattributesnotempty = array();
        $networkattributesnotempty = array();
        //biobank
        $biobankattributesnotempty[] = 'biobankID';
        $biobankattributesnotempty[] = 'biobankName';
        $biobankattributesnotempty[] = 'biobankCountry';
        $biobankattributesnotempty[] = 'biobankJuridicalPerson';
       // $biobankattributesnotempty[] = 'biobankAcronym';
       // $biobankattributesnotempty[] = 'biobankITStaffSize';
     //   $biobankattributesnotempty[] = 'contactIDRef';
        $biobankattributesnotempty[] = 'contactPriority';
        $biobankattributesnotempty[] = 'biobankPartnerCharterSigned';
        
        // network
        $biobankattributesnotempty[] =    'biobankNetworkID';
        $biobankattributesnotempty[] =    'biobankNetworkName';
        $biobankattributesnotempty[] =    'biobankNetworkCommonCollectionFocus';
        $biobankattributesnotempty[] =   'biobankNetworkCommonCharter';
        $biobankattributesnotempty[] =    'biobankNetworkCommonSOPs';
        $biobankattributesnotempty[] =    'biobankNetworkCommonDataAccessPolicy';
        $biobankattributesnotempty[] =    'biobankNetworkCommonSampleAccessPolicy';
        $biobankattributesnotempty[] =    'biobankNetworkCommonMTA';
        $biobankattributesnotempty[] =    'biobankNetworkCommonRepresentation';
        $biobankattributesnotempty[] =    'biobankNetworkCommonURL';
        $biobankattributesnotempty[] =    'biobankNetworkCommonImageAccesPolicy';
        $biobankattributesnotempty[] =    'biobankNetworkCommonImageMTA';
        // collection
        $collectionattributesnotempty[] = 'collectionID';
        $collectionattributesnotempty[] = 'collectionName';
        $collectionattributesnotempty[] = 'collectionType';
        $collectionattributesnotempty[] = 'collectionDataTypes';
        $collectionattributesnotempty[] = 'collectionOrderOfMagnitude';
        $collectionattributesnotempty[] = 'collectionSize';
        $collectionattributesnotempty[] = 'collectionAgeUnit';
        //contactInformation
        $contactattributesnotempty[] = 'contactID';
       // $contactattributesnotempty[] = 'contactEmail';
      //  $contactattributesnotempty[] = 'contactCountry';
       // $biobankattributesnotempty[] = 'biobankNetworkName';

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
        if (isset($attributes['objectClass'])) {
            if (is_array($attributes['objectClass'])) {
                if (in_array('biobank', $attributes['objectClass'])) {
                    $flag = 'biobank';
                    $attributesnotempty = $biobankattributesnotempty;
                } else if (in_array('collection', $attributes['objectClass'])) {
                    $attributesnotempty = $collectionattributesnotempty;
                    $flag = 'collection';
                } else if (in_array('contactInformation', $attributes['objectClass'])) {
                    $attributesnotempty = $contactattributesnotempty;
                    $flag = 'contact';
                }
            }
        } else {
            if ('biobank' == $attributes['objectClass']) {
                $attributesnotempty = $biobankattributesnotempty;
                $flag = 'biobank';
            } else if ('collection' == $attributes['objectClass']) {
                $attributesnotempty = $collectionattributesnotempty;
                $flag = 'collection';
            } else if ('contactInformation' == $attributes['objectClass']) {
                $attributesnotempty = $contactattributesnotempty;
                $flag = 'contact';
            }
        }

        if (isset($attributesnotempty))
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
            $message = "<b>Entry of type " . $flag . " with error :" . $attributes[$flag . "ID"] . "</b><br>";
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
