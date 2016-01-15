<?php

/**
 * lib d export csv
 */
Yii::import('ext.ECSVExport');

/**
 * controller principal par defaut.
 *
 * @author nicolas
 *
 */
class MainController extends Controller
{
    /**
     * @var string the default layout for the views. basic_column_layout is used to set an empty left column
     * to maximize the view and set style to the content of each page.
     */
    public $layout = '//layouts/basic_column_layout';

    /**
     *
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete'  // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     *
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array(
                'allow', // allow all users to perform 'index' and 'dashboard' actions
                'actions' => array(
                    'getSummarySearch',
                    'getSousGroupList',
                // 'ourTeam',
                ),
                'users' => array(
                    '*'
                )
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('details'),
                'expression' => '$user->isAdmin()',
            ),
            array(
                'allow', // allow authenticated user to perform 'search' actions
                'actions' => array(
                    'search',
                )
                ,
                'users' => array(
                    '@'
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
     * Declares class-based actions.
     */
    public function actions() {


        $captcha = array(
            'class' => 'CaptchaExtendedAction',
            'mode' => CaptchaExtendedAction::MODE_WORDS,
        );
//ajout de fixed value si mode de dev
        if (CommonTools::isInDevMode()) {
            $captchaplus = array('fixedVerifyCode' => "nicolas");
            $captcha = array_merge($captcha, $captchaplus);
        }
        return array(
// captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => $captcha,
            // page action renders "static" pages stored under 'protected/views/site/pages'
// They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction'
            )
        );
    }

    public function actionSearch() {
        $searchedField = CommonTools::AGGREGATEDFIELD1;
        $model = new BiocapForm;
        $lightModel = new LightBiocapForm();
        $flag = 1;
        $criteria = new EMongoCriteria;
        $mode_request = '1';
        if (isset($_GET['type']) && $_GET['type'] == 'advanced') {
            $flag = 0;
            $model->unsetAttributes();
            $model->attributes = $_GET['BiocapForm'];

            $mode_request = $model->mode_request;
            $criteria = $this->createCriteria($model);
        }
        if (isset($_GET['type']) && $_GET['type'] == 'light') {
            $flag = 1;
            $lightModel->unsetAttributes();
            $lightModel->attributes = $_GET['LightBiocapForm'];

            $mode_request = $lightModel->mode_request;
            $criteria = $this->createCriteria($lightModel);
        }
        $result = $this->createDataProvider($criteria, $mode_request);
        if (!isset($result['results']))
            $result['results'] = array();
        $dataProvider = new CArrayDataProvider($result['results'], array('keyField' => false/* '_id' */, 'sort' => array('defaultOrder' => 'sous_group_iccc ' . CSort::SORT_DESC, 'attributes' => array('group_iccc', 'sous_group_iccc', 'patientPartialTotal', 'total', 'CR', 'IE'))));
        $samplesList = array();
        foreach ($result["results"] as $res) {
            $value = $res['value'];
            foreach ($value['patients'] as $patient)
                foreach ($patient['samples'] as $sample)
                    $samplesList[] = $sample;
        }
        $storedCriteria = new EMongoCriteria;

        $storedCriteria->addCond('_id', 'in', $samplesList);
        Yii::app()->session['criteria'] = $storedCriteria;
        $this->render('searchForm', array('flag' => $flag, 'model' => $model, 'lightModel' => $lightModel, 'dataProvider' => $dataProvider, 'totalPatient' => count(SampleCollected::model()->getCollection()->distinct('ident_pat_biocap')), 'totalPatientSelected' => $result['total']));
    }

    public function createCriteria($form) {
        $mode_request = $form->mode_request;


        $diagCriteria = new EMongoCriteria;
        $patCriteria = new EMongoCriteria;
        $prelCriteria = new EMongoCriteria;
        $echTCriteria = new EMongoCriteria;
        $echNTCriteria = new EMongoCriteria;
        $consCriteria = new EMongoCriteria;

        /*
         * DIAGNOSTIC criteria
         */

        /*
         * Regex for iccc_group fields
         */
//        $form->iccc_sousgroup = "";
//        if (isset($form->iccc_sousgroup1) && $form->iccc_sousgroup1 != null && $form->iccc_sousgroup1 != "") {
//            $form->iccc_sousgroup .= "$form->iccc_sousgroup1|";
//            if (isset($form->iccc_sousgroup2) && $form->iccc_sousgroup2 != null && $form->iccc_sousgroup2 != "") {
//                $form->iccc_sousgroup .= "$form->iccc_sousgroup2|";
//                if (isset($form->iccc_sousgroup3) && $form->iccc_sousgroup3 != null && $form->iccc_sousgroup3 != "") {
//                    $form->iccc_sousgroup .= "$form->iccc_sousgroup3|";
//                }
//            }
//        }
//        if ($form->iccc_sousgroup != "") {
//            $form->iccc_sousgroup = substr($form->iccc_sousgroup, 0, -1);
//            $diagCriteria->addCond(CommonTools::AGGREGATEDFIELD2, '==', new MongoRegex("/" . StringUtils::accentToRegex($form->iccc_sousgroup) . "/i"));
//        }
//        $form->iccc_group = "";
//        if (isset($form->iccc_group1) && $form->iccc_group1 != null && $form->iccc_group1 != "" && in_array($form->iccc_sousgroup1, array("", null))) {
//            $form->iccc_group .= "$form->iccc_group1|";
//            if (isset($form->iccc_group2) && $form->iccc_group2 != null && $form->iccc_group2 != "" && in_array($form->iccc_sousgroup2, array("", null))) {
//                $form->iccc_group .= "$form->iccc_group2|";
//                if (isset($form->iccc_group3) && $form->iccc_group3 != null && $form->iccc_group3 != "" && in_array($form->iccc_sousgroup3, array("", null))) {
//                    $form->iccc_group .= "$form->iccc_group3|";
//                }
//            }
//        }
//        if ($form->iccc_group != "") {
//            $form->iccc_group = substr($form->iccc_group, 0, -1);
//            $diagCriteria->addCond(CommonTools::AGGREGATEDFIELD1, '==', new MongoRegex("/" . StringUtils::accentToRegex($form->iccc_group) . "/i"));
//        }


        $groupCond = array();

        $groupCond['$or'] = array();
        if (isset($form->iccc_group1) && $form->iccc_group1 != null && $form->iccc_group1 != "") {
            if (in_array($form->iccc_sousgroup1, array("", null))) {
                $groupCond['$or'][] = array(CommonTools::AGGREGATEDFIELD1 => $form->iccc_group1);
            } else {
                $groupCond['$or'][] = array(CommonTools::AGGREGATEDFIELD2 => $form->iccc_sousgroup1);
            }
            if (isset($form->iccc_group2) && $form->iccc_group2 != null && $form->iccc_group2 != "") {
                if (in_array($form->iccc_sousgroup2, array("", null))) {
                    $groupCond['$or'][] = array(CommonTools::AGGREGATEDFIELD1 => $form->iccc_group2);
                } else {
                    $groupCond['$or'][] = array(CommonTools::AGGREGATEDFIELD2 => $form->iccc_sousgroup2);
                }
                if (isset($form->iccc_group3) && $form->iccc_group3 != null && $form->iccc_group3 != "") {
                    if (in_array($form->iccc_sousgroup3, array("", null))) {
                        $groupCond['$or'][] = array(CommonTools::AGGREGATEDFIELD1 => $form->iccc_group3);
                    } else {
                        $groupCond['$or'][] = array(CommonTools::AGGREGATEDFIELD2 => $form->iccc_sousgroup3);
                    }
                }
            }
            $diagCriteria->setConditions($groupCond);
        }



        /*
         * Regex for topo / organe fields
         */
        $form->topoOrganeField = "";
        if (isset($form->topoOrganeField1) && $form->topoOrganeField1 != null && $form->topoOrganeField1 != "") {
            $form->topoOrganeField .= "$form->topoOrganeField1|";
            if (isset($form->topoOrganeField2) && $form->topoOrganeField2 != null && $form->topoOrganeField2 != "") {
                $form->topoOrganeField .= "$form->topoOrganeField2|";
                if (isset($form->topoOrganeField3) && $form->topoOrganeField3 != null && $form->topoOrganeField3 != "") {
                    $form->topoOrganeField .= "$form->topoOrganeField3|";
                }
            }
        }
        if ($form->topoOrganeField != "") {
            $form->topoOrganeField = substr($form->topoOrganeField, 0, -1);

//            if ($form->topoOrganeType == 'adicap')
//                $attribute = 'Code_organe1_ADICAP';
//            else
            $attribute = 'RNCE_LibelleTopo';
            $diagCriteria->addCond($attribute, '==', new MongoRegex("/($form->topoOrganeField)/i"));
        }
        /*
         * Regex for morpho / histo fields
         */
        $form->morphoHistoField = "";
        if (isset($form->morphoHistoField1) && $form->morphoHistoField1 != null && $form->morphoHistoField1 != "") {
            $form->morphoHistoField .= "$form->morphoHistoField1|";
            if (isset($form->morphoHistoField2) && $form->morphoHistoField2 != null && $form->morphoHistoField2 != "") {
                $form->morphoHistoField .= "$form->morphoHistoField2|";
                if (isset($form->morphoHistoField3) && $form->morphoHistoField3 != null && $form->morphoHistoField3 != "") {
                    $form->morphoHistoField .= "$form->morphoHistoField3|";
                }
            }
        }
        if ($form->morphoHistoField != "") {
            $form->morphoHistoField = substr($form->morphoHistoField, 0, -1);
//
//            if ($form->morphoHistoType == 'adicap')
//                $attribute = 'Type_lesionnel1_ADICAP';
//            else
            $attribute = 'RNCE_Intitule_CIMO';
            $diagCriteria->addCond($attribute, '==', new MongoRegex("/($form->morphoHistoField)/i"));
        }
        if (isset($form->metastasique))
            switch ($form->metastasique) {
                case 'oui':
                    $diagCriteria->addCond('RNCE_Meta', '==', 1);
                    break;
                case 'non';
                    $diagCriteria->addCond('RNCE_Meta', '==', 0);
                    break;
                case 'inconnu':
                default:
                    break;
            }
        if (isset($form->cr_anapath_dispo))
            switch ($form->cr_anapath_dispo) {
                case 'oui':
                    $diagCriteria->addCond('RNCE_CR_ana_disp', '==', 1);
                    break;
                case 'non';
                    $diagCriteria->addCond('RNCE_CR_ana_disp', '==', 0);
                    break;
                case 'inconnu':
                default:
                    break;
            }
        if (isset($form->donCliInBase))
            switch ($form->donCliInBase) {
                case 'oui':
                    $diagCriteria->addCond('RNCE_DonneesCliniques', '==', 1);
                    break;
                case 'non';
                    $diagCriteria->addCond('RNCE_DonneesCliniques', '==', 0);
                    break;
                case 'inconnu':
                default:
                    break;
            }


        /*
         * PATIENT criteria
         */
        if (isset($form->sexe))
            switch ($form->sexe) {
                case 'Féminin':
                    $patCriteria->Sexe = new MongoRegex("/" . StringUtils::accentToRegex('feminin') . "/i");
                    break;
                case 'Masculin';
                    $patCriteria->Sexe = new MongoRegex("/" . StringUtils::accentToRegex('masculin') . "/i");
                    break;
                case 'inconnu':
                default:
                    break;
            }
        if (isset($form->stat_vital))
            switch ($form->stat_vital) {
                case 'vivant':
                    $patCriteria->addCond('RNCE_StatutVital', '==', new MongoRegex("/" . StringUtils::accentToRegex('vv') . "/i"));
                    break;
                case 'decede';
                    $patCriteria->addCond('RNCE_StatutVital', '==', new MongoRegex("/" . StringUtils::accentToRegex('dcd') . "/i"));
                    break;
                case 'inconnu':
                default:
                    break;
            }

        if (isset($form->ano_chrom_constit))
            switch ($form->ano_chrom_constit) {
                case 'oui':
                    $patCriteria->addCond('RNCE_AnoChrConst', '==', 1);
                    break;
                case 'non';
                    $patCriteria->addCond('RNCE_AnoChrConst', '==', 0);
                    break;
                case 'inconnu':
                default:
                    break;
            }



        /*
         * create 'age' crteria
         */

        $age = array();
        if (isset($form->age['0-1']) && $form->age['0-1'] == "1") {
            $age[] = 0;
            $age[] = 1;
        }
        if (isset($form->age['2-4']) && $form->age['2-4'] == "1") {
            $age[] = 2;
            $age[] = 3;
            $age[] = 4;
        }
        if (isset($form->age['5-9']) && $form->age['5-9'] == "1") {
            $age[] = 5;
            $age[] = 6;
            $age[] = 7;
            $age[] = 8;
            $age[] = 9;
        }
        if (isset($form->age['10-14']) && $form->age['10-14'] == "1") {
            $age[] = 10;
            $age[] = 11;
            $age[] = 12;
            $age[] = 13;
            $age[] = 14;
        }
        if (isset($form->age['15+']) && $form->age['15+'] == "1") {
            $crit = new EMongoCriteria;
            $crit->sort('age', -1);
            $crit->limit(1);
            $datas = SampleCollected::model()->findAll($crit);
            $maxAge = $datas[0]->age;

            while ($maxAge >= 15) {
                $age[] = $maxAge;
                $maxAge--;
            }
        }

        if (!empty($age))
            $patCriteria->addCond('age', 'in', $age);
        /*
         * PRELEVEMENT-ECHANTILLON criteria
         */

        /*
         * Diag initial
         */
        $evenement = array();
        if (isset($form->evenement['diag_init']) && $form->evenement['diag_init'] == 'diagnotic initial')
            $evenement[] = 'diagnostic';
        if (isset($form->evenement['rechute']) && $form->evenement['rechute'] == 'rechute')
            $evenement[] = 'rechute';
        if (isset($form->evenement['sec_cancer']) && $form->evenement['sec_cancer'] == 'second cancer')
            $evenement[] = 'Second cancer';

        $regex = implode("|", $evenement);
        if ($regex != "") {
            $prelCriteria->addCond('RNCE_Type_Evnmt2', "==", new MongoRegex("/" . StringUtils::accentToRegex($regex) . "/i"));
        }
        /**
         * Mécanisme pour prendre en charge les choix 'autres' des cases à cocher
         */
        if (isset($form->type_prelev)) {
            $typePrel = array();
            $typesAvailable = array(
                'tissu' => new MongoRegex("/" . StringUtils::accentToRegex('tissu') . "/i"),
                'moelle' => new MongoRegex("/" . StringUtils::accentToRegex('moelle') . "/i"),
                'sang' => new MongoRegex("/" . StringUtils::accentToRegex('sang') . "/i"));
            if (isset($form->type_prelev['tissu']) && $form->type_prelev['tissu'] == 'tissu') {
                unset($typesAvailable['tissu']);
                $typePrel[] = new MongoRegex("/" . StringUtils::accentToRegex('tissu') . "/i");
            }
            if (isset($form->type_prelev['moelle']) && $form->type_prelev['moelle'] == 'moelle') {
                unset($typesAvailable['moelle']);
                $typePrel[] = new MongoRegex("/" . StringUtils::accentToRegex('moelle') . "/i");
            }
            if (isset($form->type_prelev['sang']) && $form->type_prelev['sang'] == 'sang') {
                unset($typesAvailable['sang']);
                $typePrel[] = new MongoRegex("/" . StringUtils::accentToRegex('sang') . "/i");
            }
            if (isset($form->type_prelev['liquide']) && $form->type_prelev['liquide'] == 'liquide') {
                unset($typesAvailable['liquide']);
                $typePrel[] = new MongoRegex("/" . StringUtils::accentToRegex('liquide') . "/i");
            }
            if (isset($form->type_prelev['autre']) && $form->type_prelev['autre'] == 'autre') {
                $prelCriteria->addCond('Type_prlvt', 'notin', array_values($typesAvailable)); //type_echant NOT a typo, error in data source
            } else if (!empty($typePrel))
                $prelCriteria->addCond('Type_prlvt', 'in', $typePrel); //type_echant NOT a typo, error in data source
        }

        /**
         * Mécanisme pour prendre en charge les choix 'autres' des cases à cocher
         */
        if (isset($form->mode_prelev)) {
            $modePrel = array();
            $modesAvailable = array(
                'biopsie' => new MongoRegex("/" . StringUtils::accentToRegex('biopsie') . "/i"),
                'pieceOp' => new MongoRegex("/" . StringUtils::accentToRegex('pièce opératoire') . "/i"),
                'ponction' => new MongoRegex("/" . StringUtils::accentToRegex('ponction') . "/i"));
            if (isset($form->mode_prelev['biopsie']) && $form->mode_prelev['biopsie'] == 'biopsie') {
                unset($modesAvailable['biopsie']);
                $modePrel[] = new MongoRegex("/" . StringUtils::accentToRegex('biopsie') . "/i");
            }
            if (isset($form->mode_prelev['pieceOp']) && $form->mode_prelev['pieceOp'] == 'pièce opératoire') {
                unset($modesAvailable['pieceOp']);
                $modePrel[] = new MongoRegex("/" . StringUtils::accentToRegex('pièce opératoire') . "/i");
            }
            if (isset($form->mode_prelev['ponction']) && $form->mode_prelev['ponction'] == 'ponction') {
                unset($modesAvailable['sang']);
                $modePrel[] = new MongoRegex("/" . StringUtils::accentToRegex('ponction') . "/i");
            }
            if (isset($form->mode_prelev['autre']) && $form->mode_prelev['autre'] == 'autre') {
                $prelCriteria->addCond('Mode_prlvt', 'notin', array_values($modesAvailable)); //type_echant NOT a typo, error in data source
            } else if (!empty($modePrel))
                $prelCriteria->addCond('Mode_prlvt', 'in', $modePrel); //type_echant NOT a typo, error in data source
        }
        /* ECHANTILLON TUMORAL CRITERIA
         *
         */

        $nat_ech = array();

//            if (isset($form->ETL['tum_prim']) && $form->ETL['tum_prim'] == 'Tumeur primaire')
//                $nat_ech[] = 'diagnostic';
//            if (isset($form->ETL['tum_prim']) && $form->ETL['tum_prim'] == 'Tumeur primaire')
//                $nat_ech[] = 'diagnostic';
//            $regex = implode("|", $nat_ech);
//$echTCriteria->addCond('RNCE_Type_Evnmt2', "==", new MongoRegex("/" . StringUtils::accentToRegex($regex) . "/i"));
        if (isset($form->ETLTyp)) {
            $echTumType = array();
            if (isset($form->ETLTyp['tissu_cong']) && $form->ETLTyp['tissu_cong'] == 'Tissu tumoral congelé') {
                $echTumType[] = $form->ETLTyp['tissu_cong'] . '$';
            }
            if (isset($form->ETLTyp['bloc_para']) && $form->ETLTyp['bloc_para'] == 'Tissu tumoral') {
                $echTumType[] = $form->ETLTyp['bloc_para'] . '$';
            }
            if (isset($form->ETLTyp['cell_DMSO']) && $form->ETLTyp['cell_DMSO'] == 'Cellules DMSO') {
                $echTumType[] = $form->ETLTyp['cell_DMSO'] . '$';
            }
            if (isset($form->ETLTyp['cell_CS']) && $form->ETLTyp['cell_CS'] == 'Cellules culot sec') {
                $echTumType[] = $form->ETLTyp['cell_CS'] . '$';
            }
            $ETTRegex = implode("|", $echTumType);
            $echTCriteria->addCond('BB_type_echant_tum', "==", new MongoRegex("/" . StringUtils::accentToRegex($ETTRegex) . "/i"));
        }
        if (isset($form->ETLDer)) {
            $echTumDer = array();

            if (isset($form->ETLDer['adn_der']) && $form->ETLDer['adn_der'] == 'ADN dérivé') {

                $echTumDer[] = $form->ETLDer['adn_der'] . '$';
            }

            if (isset($form->ETLDer['arn_der']) && $form->ETLDer['arn_der'] == 'ARN dérivé') {

                $echTumDer[] = $form->ETLDer['arn_der'] . '$';
            }
            $ETDRegex = implode("|", $echTumDer);

            $echTCriteria->addCond('BB_derives_tum', "==", new MongoRegex("/" . StringUtils::accentToRegex($ETDRegex) . "/i"));
        }
        /*
         * ECHNATILLON NON TUMORAL
         */

        /*
         * Type
         */
        if (isset($form->ENTTyp)) {
            $echNTType = array();

            if (isset($form->ENTTyp['tiss_sain']) && $form->ENTTyp['tiss_sain'] == 'Tissu sain') {

                $echNTType[] = $form->ENTTyp['tiss_sain'] . '$';
            }
            if (isset($form->ENTTyp['cellNT']) && $form->ENTTyp['cellNT'] == 'Cellules non tumoral') {

                $echNTType[] = $form->ENTTyp['cellNT'] . '$';
            }
            if (isset($form->ENTTyp['sang_tot_cong']) && $form->ENTTyp['sang_tot_cong'] == 'Sang total congelé') {

                $echNTType[] = $form->ENTTyp['sang_tot_cong'] . '$';
            }
            if (isset($form->ENTTyp['salive']) && $form->ENTTyp['salive'] == 'salive') {

                $echNTType[] = $form->ENTTyp['salive'] . '$';
            }

            $ENTTRegex = implode("|", $echNTType);
            $echNTCriteria->addCond('BB_type_echant_non_tum', "==", new MongoRegex("/" . StringUtils::accentToRegex($ENTTRegex) . "/i"));
        }
        /*
         * Dérivés
         */

        if (isset($form->ENTDer)) {
            $echNTder = array();

            if (isset($form->ENTDer['adn_const']) && $form->ENTDer['adn_const'] == 'ADN constitutionnel') {

                $echNTder[] = $form->ENTDer['adn_const'] . '$';
            }
            if (isset($form->ENTDer['arn_const']) && $form->ENTDer['arn_const'] == 'ARN constitutionnel') {

                $echNTder[] = $form->ENTDer['arn_const'] . '$';
            }



            $ENTDRegex = implode("|", $echNTder);
            $echNTCriteria->addCond('BB_derives_non_tum', "==", new MongoRegex("/" . StringUtils::accentToRegex($ENTDRegex) . "/i"));
        }
        /*
         * RBA
         */
        if (isset($form->ENTRBA)) {
            if (isset($form->ENTRBA['serum']) && $form->ENTRBA['serum'] == 1) {

                $echNTCriteria->Serum = new MongoRegex("/" . StringUtils::accentToRegex('oui') . "/i");
            }
            if (isset($form->ENTRBA['plasma']) && $form->ENTRBA['plasma'] == 1) {

                $echNTCriteria->Plasma = new MongoRegex("/" . StringUtils::accentToRegex('oui') . "/i");
            }

            /*
             * CONSENTEMENT Criteria
             */
            if (isset($form->consent_rech))
                switch ($form->consent_rech) {
                    case 'oui':
                        $consCriteria->Statut_juridique = new MongoRegex("/" . StringUtils::accentToRegex('obtenu') . "/i");
                        break;
                    case 'non';
                        $consCriteria->Statut_juridique = new MongoRegex("/" . StringUtils::accentToRegex('refus') . "/i");
                        break;
                    case 'inconnu':
                    default:
                        break;
                }
        }
        return RequestTools::getRequestCriteria($mode_request, $diagCriteria, $patCriteria, $prelCriteria, $echTCriteria, $echNTCriteria, $consCriteria);
    }

    public function createDataProvider(EMongoCriteria $criteria, $mode_request) {
        $searchedField1 = CommonTools::AGGREGATEDFIELD1;
        $searchedField2 = CommonTools::AGGREGATEDFIELD2;
        $query = count($criteria->getConditions()) != 0 ? $criteria->getConditions() : null;
        $db = SampleCollected::model()->getDb();

        $requestElements = RequestTools::getRequest($mode_request);

        $map = $requestElements['map'];
        $reduce = $requestElements['reduce'];
        $finalize = $requestElements['finalize'];

        $db->command(array(
            'mapreduce' => "sampleCollected",
            'query' => $query,
            'map' => $map,
            'reduce' => $reduce,
            'finalize' => $finalize,
            //place le resultat en memoire
            'out' => Array("replace" => 'testReplace')
        ));

        $queryResult = array();
        $results = $db->selectCollection('testReplace')->find(array(), array('value.CR' => true, 'value.IE' => true, 'value.patientPartialTotal' => true, 'value.patients.id' => true, 'value.patients.samples' => true,));
        //$results = $db->selectCollection('testReplace')->find();

        $queryResult['results'] = $results;
        $result = RequestTools::filterResult($mode_request, $queryResult);
        return $result;
    }

    public function actionDetails() {

        $this->layout = '//layouts/detailview';
        $criteria = Yii::app()->session['criteria'];

        if (isset($_GET['sous_group_iccc']))
            $criteria->addCond(CommonTools::AGGREGATEDFIELD2, '==', $_GET['sous_group_iccc']);
        $criteria->sort('ident_pat_biocap', EMongoCriteria::SORT_ASC);
        $dataProvider = new EMongoDocumentDataProvider('SampleCollected');


        $dataProvider->setCriteria($criteria);

        $this->render('details', array('dataProvider' => $dataProvider,
            'group' => $_GET['group_iccc'],
            'sous_group' => $_GET['sous_group_iccc']));
    }

    public function actionGetSousGroupList() {
        $prefixe = "";
        if (isset($_GET['BiocapForm'])) {
            $prefixe = "BiocapForm";
            $form = $_GET['BiocapForm'];
        }
        if (isset($_GET['LightBiocapForm'])) {
            $prefixe = "LightBiocapForm";
            $form = $_GET['LightBiocapForm'];
        }

        if (isset($form['iccc_group1'])) {
            $values = SampleCollected::model()->getCollection()->distinct(CommonTools::AGGREGATEDFIELD2, array(CommonTools::AGGREGATEDFIELD1 => $form['iccc_group1']));
            natcasesort($values);
            echo '<select display="inline-block" separator=" " name="' . $prefixe . '[iccc_sousgroup1]" id="' . $prefixe . '_iccc_sousgroup1" style="width:150px">';
            echo '<option value="">Indifférent</option>';
            foreach ($values as $value) {
                echo '<option value="' . $value . '">' . $value . '</option>';
            }
            echo '</select>';
        } else if (isset($form['iccc_group2'])) {
            $values = SampleCollected::model()->getCollection()->distinct(CommonTools::AGGREGATEDFIELD2, array(CommonTools::AGGREGATEDFIELD1 => $form['iccc_group2']));
            natcasesort($values);
            echo '<select display="inline-block" separator=" " name="' . $prefixe . '[iccc_sousgroup2]" id="' . $prefixe . '_iccc_sousgroup2" style="width:150px">';
            echo '<option value="">Indifférent</option>';
            foreach ($values as $value) {
                echo '<option value="' . $value . '">' . $value . '</option>';
            }
            echo '</select>';
        } else if (isset($form['iccc_group3'])) {
            $values = SampleCollected::model()->getCollection()->distinct(CommonTools::AGGREGATEDFIELD2, array(CommonTools::AGGREGATEDFIELD1 => $form['iccc_group3']));
            natcasesort($values);
            echo '<select display="inline-block" separator=" " name="' . $prefixe . '[iccc_sousgroup3]" id="' . $prefixe . '_iccc_sousgroup3" style="width:150px">';
            echo '<option value="">Indifférent</option>';
            foreach ($values as $value) {
                echo '<option value="' . $value . '">' . $value . '</option>';
            }
            echo '</select>';
        }
    }

}