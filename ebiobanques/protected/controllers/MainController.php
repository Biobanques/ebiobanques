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
                    'search',
                    'details'
                ),
                'users' => array(
                    '*'
                )
            ),
            array(
                'allow', // allow authenticated user to perform 'search' actions
                'actions' => array(
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

        $model = new BiocapForm;
        // $dataProvider = array();
        //  $dataProvider = SampleCollected::model()->findAll();
        $dataProvider = new EMongoDocumentDataProvider('SampleCollected');
        $criteria = new EMongoCriteria;
        if (isset($_GET['BiocapForm'])) {
//        if (isset($_POST['BiocapForm'])) {
            $model->unsetAttributes();
            $model->attributes = $_GET['BiocapForm'];
//            $model->attributes = $_POST['BiocapForm'];
            $criteria = $this->createCriteria($model);
        }
        $dataProvider = $this->createDataProvider($criteria);
        Yii::app()->session['criteria'] = $criteria;
        $this->render('searchForm', array('model' => $model, 'dataProvider' => $dataProvider));
    }

    public function createCriteria($form) {
        $criteria = new EMongoCriteria;

        /*
         * DIAGNOSTIC criteria
         */

        /*
         * Regex for iccc_group fields
         */
        $form->iccc_group = "";
        if (isset($form->iccc_group1) && $form->iccc_group1 != null && $form->iccc_group1 != "") {
            $form->iccc_group .= "$form->iccc_group1|";
            if (isset($form->iccc_group2) && $form->iccc_group2 != null && $form->iccc_group2 != "") {
                $form->iccc_group .= "$form->iccc_group2|";
                if (isset($form->iccc_group3) && $form->iccc_group3 != null && $form->iccc_group3 != "") {
                    $form->iccc_group .= "$form->iccc_group3|";
                }
            }
        }
        if ($form->iccc_group != "") {
            $form->iccc_group = substr($form->iccc_group, 0, -1);
            //   $criteria->addCond('<attribute_name>', '==', new MongoRegex("/($form->iccc_group)/i"));
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

            if ($form->topoOrganeType == 'adicap')
                $attribute = 'Code_organe1_ADICAP';
            else
                $attribute = 'Code_organe1_CIMO3';
            $criteria->addCond($attribute, '==', new MongoRegex("/($form->topoOrganeField)/i"));
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

            if ($form->morphoHistoType == 'adicap')
                $attribute = 'Type_lesionnel1_ADICAP';
            else
                $attribute = 'Type_lesionnel1_CIMO3';
            $criteria->addCond($attribute, '==', new MongoRegex("/($form->morphoHistoField)/i"));
        }

        switch ($form->metastasique) {
            case 'oui':

                break;
            case 'non';

                break;
            case 'inconnu':
            default:
                break;
        }
        switch ($form->cr_anapath_dispo) {
            case 'oui':

                break;
            case 'non';

                break;
            case 'inconnu':
            default:
                break;
        }
        switch ($form->donCliInBase) {
            case 'oui':

                break;
            case 'non';

                break;
            case 'inconnu':
            default:
                break;
        }


        /*
         * PATIENT criteria
         */

        if ($form->sexe == 'f') {
            $criteria->Sexe = 'Féminin';
        }
        if ($form->sexe == 'm') {
            $criteria->Sexe = 'Masculin';
        }
        if ($form->stat_vital == 'vivant') {
            $criteria->Statut_vital = 'Vivant';
        }
        if ($form->stat_vital == 'decede') {
            $criteria->Statut_vital = 'Décédé';
        }
        //$criteria->addCond('age', '==', 14);
//        $criteria->addCond('age', 'or', 0);
//        $criteria->addCond('age', 'or', 5);
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
            $criteria->addCond('age', 'in', $age);
        //$criteria->addCond('age', 'in', array(0, 1, 2));
        /*
         * PRELEVEMENT-ECHANTILLON criteria
         */

        return $criteria;
    }

    public function createDataProvider(EMongoCriteria $criteria) {
        $searchedField = "Type_lesionnel1_litteral";
//        $critArray = '';
//        foreach ($criteria->getConditions() as $condition) {
//            $critArray.="res.criteria.push($condition);";
//        }

        $reduce = new MongoCode("function(doc,res){res.total+=1;"
                . "if(doc.Statut_juridique=='Obtenu'){"
                . "res.CR+=1;"
                . "}"
                . "if(doc.Inclusion_protoc_rech=='oui'){"
                . "res.IE+=1;"
                . "}"

                //. "var obj={};"
                //  . "obj['$searchedField']=doc.$searchedField;"
                //. "res.criteria.push(obj);"
                . "}"
        );
        //$cond = $criteria->getConditions();
//        $criteria->addCond($searchedField, '==', 'test');
        $result = SampleCollected::model()->getCollection()->group(
                array($searchedField => true), array('total' => 0, 'CR' => 0, 'IE' => 0), $reduce
                , $criteria->getConditions()
        );


        return new CArrayDataProvider($result['retval'], array('keyField' => $searchedField));
    }

    public function actionDetails() {
        $this->layout = '//layouts/detailview';
        $criteria = Yii::app()->session['criteria'];
        if (isset($_GET['iccc']))
            $criteria->addCond('Type_lesionnel1_litteral', '==', $_GET['iccc']);
        $dataProvider = new EMongoDocumentDataProvider('SampleCollected');


        $dataProvider->setCriteria($criteria);
        $this->render('details', array('dataProvider' => $dataProvider));
    }

}