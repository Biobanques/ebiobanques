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
                    'index',
                    'accueil',
                    'questions',
                    'dashboard',
                    'biobanks',
                    'login',
                    'logout',
                    'error',
                    'contactus',
                    'captcha', 'recoverPwd',
                    'subscribe',
                ),
                'users' => array(
                    '*'
                )
            ),
            array(
                'allow', // allow authenticated user to perform 'search' actions
                'actions' => array(
                    'search',
                    'contacts',
                    'view',
                    'changerDemandeEchantillon',
                    'addDemandeAllEchantillon',
                    'removeDemandeAllEchantillon'
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
        $data = new EMongoDocumentDataProvider('SampleCollected');

        if (isset($_GET['BiocapForm'])) {
            $model->attributes = $_GET['BiocapForm'];
            $criteria = $this->createCriteria($model);
            $criteria->limit(8);
            $criteria->offset(20);
            $data->setCriteria($criteria);

            print_r($criteria);
        }

        $this->render('searchForm', array('model' => $model, 'data' => $data));
    }

    public function createCriteria($form) {
        $criteria = new EMongoCriteria;
        /*
         * DIAGNOSTIC criteria
         */


        if ($form->metastasique == 'oui') {

        }

        if ($form->metastasique == 'non') {

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

        /*
         * PRELEVEMENT-ECHANTILLON criteria
         */

        return $criteria;
    }

}