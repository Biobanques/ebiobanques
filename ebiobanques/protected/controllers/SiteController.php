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
class SiteController extends Controller
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

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('accueil');
    }

    /**
     * affichage du tableau de bord
     */
    public function actionDashboard() {
        $this->render('dashboard');
    }

    /**
     * affichage de la page d accueil
     */
    public function actionAccueil() {
        $this->render('accueil');
    }

    /**
     * affichage de la page de questions
     */
    public function actionQuestions() {
        $this->render('questions');
    }

    /**
     * affichage de la page de recherche des echantillons
     */
    public function actionSearch() {
        $model = new Sample('search');
        $model->unsetAttributes();
        $biobankId = null;
        if (isset($_GET['id']) && isset($_GET['layout']) && $_GET['layout'] == 'vitrine_layout')
            $biobankId = $_GET['id'];
        $model->biobank_id = $biobankId;
        $prefs = Preferences::model()->findByAttributes(array('id_user' => Yii::app()->user->id));
        if ($prefs == null) {
            $prefs = new Preferences;
            $prefs->id_user = Yii::app()->user->id;
            $prefs->save();
        }
        if (isset($_GET ['Preferences'])) {
            $prefs->attributes = $_GET ['Preferences'];
            $prefs->save();
        }
        if (isset($_GET ['Sample'])) {
            $model->attributes = $_GET ['Sample'];



//Used to search terms in model->biobank->collection_id and model->biobank->collection_name
            $arrayOfBiobanks = array();
            if (!empty($_GET['collection_id'])) {
                $criteria = new EMongoCriteria;
                $listWords = explode(",", $_GET['collection_id']);
                $regexId = "";
                foreach ($listWords as $word) {
                    $regexId.="$word|";
                }
                $regexId = substr($regexId, 0, -1);
                $criteria->addCond('collection_id', '==', new MongoRegex("/($regexId)/i"));
                $criteria->select(array('_id'));
                $biobanks = Biobank::model()->findAll($criteria);
                foreach ($biobanks as $biobank) {
                    $arrayOfBiobanks[(string) $biobank->_id] = (string) $biobank->_id;
                }
            }

            if (!empty($_GET['collection_name'])) {
                $criteria = new EMongoCriteria;
                $listWords = explode(",", $_GET['collection_name']);
                $regexId = "";
                foreach ($listWords as $word) {
                    $regexId.="$word|";
                }
                $regexId = substr($regexId, 0, -1);
                $criteria->addCond('collection_name', '==', new MongoRegex("/($regexId)/i"));
                $criteria->select(array('_id'));
                $biobanks = Biobank::model()->findAll($criteria);
                foreach ($biobanks as $biobank) {
                    $arrayOfBiobanks[(string) $biobank->_id] = (string) $biobank->_id;
                }
            }

            if (!empty($arrayOfBiobanks)) {
                $model->arrayOfBiobanks;
                $model->arrayOfBiobanks = $arrayOfBiobanks;
            }


            $content = '';
            foreach ($_GET ['Sample'] as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $vkey => $vval) {
                        $content = $content . (string) $vkey . '=' . str_replace(';', ',', (string) $vval) . ';';
                    }
                } else
                if ($value != null && !empty($value) && (string) $value != '0') {
                    $content = $content . (string) $key . '=' . str_replace(';', ',', (string) $value) . ';';
                }
            }
            if (Yii::app()->session ['SampleForm'] != $_GET ['Sample']) {
                $_GET ['Echantillon_page'] = null;
                $this->logAdvancedSearch($content);
            }
            Yii::app()->session ['SampleForm'] = $_GET ['Sample'];
        }
        //form de la recherche intelligente
        $smartForm = new SampleSmartForm ();
        if (isset($_POST ['SampleSmartForm'])) {
            $model->unsetAttributes();

            $smartForm->attributes = $_POST ['SampleSmartForm'];
            if (Yii::app()->session ['keywords'] != $smartForm->keywords) {
                $_GET ['Echantillon_page'] = null;
                $this->logSmartSearch($smartForm->keywords);
            }
            Yii::app()->session ['keywords'] = $smartForm->keywords;
            $model = SmartResearcherTool::search($smartForm->keywords, $biobankId);
        }
        $this->render('search_samples', array(
            'model' => $model,
            'smartForm' => $smartForm
        ));
    }

    /**
     * Displays a echantillon model.
     *
     * @param integer $id
     *        	the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->layout = 'detailview';
        $this->render('view', array(
            'model' => $this->loadModel($id)
        ));
    }

    /**
     * affichage des infos de biobanques
     */
    public function actionBiobanks() {
        $model = new Biobank('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET ['Biobank']))
            $model->attributes = $_GET ['Biobank'];

        $this->render('biobanks', array(
            'model' => $model
        ));
    }

    /**
     * affichage des infos des contacts
     * On affiche que les contacts actifs.
     */
    public function actionContacts() {
        $model = new Contact('search');
        $model->unsetAttributes();
        if (isset($_GET ['Contact'])) {
            $model->attributes = $_GET ['Contact'];
        }
        //$model->inactive = "0";
        $this->render('contacts', array(
            'model' => $model
        ));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error ['message'];
            else {
                $this->render('error', $error);
            }
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContactus() {
        $model = new ContactForm ();
        if (isset($_POST ['ContactForm'])) {
            $model->attributes = $_POST ['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" . "Reply-To: {$model->email}\r\n" . "MIME-Version: 1.0\r\n" . "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params ['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array(
            'model' => $model
        ));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {

        $model = new LoginForm ();

        // if it is ajax validation request
        if (isset($_POST ['ajax']) && $_POST ['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST ['LoginForm'])) {
            $model->attributes = $_POST ['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $lastDemandRequest = Demande::model()->findByAttributes(array(
                    'id_user' => (string) Yii::app()->user->id,
                    'envoi' => 0
                        ), array(
                    'order' => 'date_demande desc'
                ));
                if ($lastDemandRequest != null) {
                    $lastDemand = $lastDemandRequest;
                    $newDemand = false;

                    Yii::app()->session ['activeDemand'] = array(
                        $lastDemand,
                        $newDemand
                    );
                } else {
                    $lastDemandRequest = new Demande ();
                    $lastDemandRequest->id_user = (string) Yii::app()->user->id;
                    $lastDemandRequest->date_demande = date("Y-m-d H:i:s");
                    $lastDemandRequest->envoi = 0;
                    $lastDemandRequest->sampleList = array();
                    $lastDemandRequest->save();
                    $newDemand = true;
                    Yii::app()->session ['activeDemand'] = array(
                        $lastDemandRequest,
                        $newDemand
                    );
                }
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        // display the login form

        $this->render('login', array(
            'model' => $model
        ));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * load sample model by mongo id.
     *
     * @param unknown $id
     * @throws CHttpException
     * @return unknown$smartSearch = new LogSmartSearch();
     */
    public function loadModel($id) {
        $model = Sample::model()->findByPk(new MongoID($id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function logSmartSearch($post) {
        $smartSearch = new SmartSearchLog ();
        $smartSearch->id_user = Yii::app()->user->id;
        $smartSearch->search_date = date("Y-m-j H:i:s");
        $smartSearch->content = $post;
        $smartSearch->save();
    }

    public function logAdvancedSearch($post) {
        $advancedSearch = new AdvancedSearchLog ();
        $advancedSearch->id_user = Yii::app()->user->id;
        $advancedSearch->search_date = date("Y-m-j H:i:s");
        $advancedSearch->content = $post;
        $advancedSearch->save();
    }

    /**
     * ajoute ou supprime un echantillon de la demande en cours
     */
    public function actionChangerDemandeEchantillon() {
        $id = $_POST ['id'];
        $demande = Yii::app()->session ['activeDemand'] [0];
        $samplesList = array();
        if ($demande->sampleList == null)
            $demande->sampleList = array();
        foreach ($demande->sampleList as $sample)
            $samplesList[] = $sample->id_sample;
        if (!in_array($id, $samplesList)) {
            $echDemande = new EchDemande ();
            $echDemande->id_sample = $id;
            $demande->sampleList[] = $echDemande;
            $demande->saveWithCurrentDate();
        } else {
            foreach ($demande->sampleList as $sampleKey => $sample) {
                if ($sample->id_sample == $id) {
                    unset($demande->sampleList[$sampleKey]);
                    $demande->saveWithCurrentDate();
                }
            }
        }
        return;
    }

    /**
     * Ajoute tous les echantillons à une page de la demande en cours
     */
    public function actionAddDemandeAllEchantillon() {
        $id = $_POST ['id'];
        $demande = Yii::app()->session ['activeDemand'] [0];
        $samplesList = array();
        foreach ($demande->sampleList as $sample)
            $samplesList[] = $sample->id_sample;

        if (!in_array($id, $samplesList)) {
            $echDemande = new EchDemande ();
            $echDemande->id_sample = $id;
            $demande->sampleList[] = $echDemande;
            $demande->saveWithCurrentDate();
        }
    }

    /**
     * Retire tous les echantillons d'une page de la demande en cours
     */
    public function actionRemoveDemandeAllEchantillon() {
        $id = $_POST ['id'];
        $demande = Yii::app()->session ['activeDemand'] [0];
        $samplesList = array();
        foreach ($demande->sampleList as $sample)
            $samplesList[] = $sample->id_sample;

        if (in_array($id, $samplesList)) {
            foreach ($demande->sampleList as $sampleKey => $sample) {
                if ($sample->id_sample == $id) {
                    unset($demande->sampleList[$sampleKey]);
                    $demande->saveWithCurrentDate();
                }
            }
        }
    }

// username and password are required
    // rememberMe needs to be a boolean

    /**
     * display the recover password page
     */
    public function actionRecoverPwd() {
        $model = new RecoverPwdForm();
        $result = '';
        if (isset($_POST['RecoverPwdForm'])) {
            $model->attributes = $_POST['RecoverPwdForm'];
            if ($model->validate()) {
                $mixedResult = $model->validateFields();

                if ($mixedResult['result'] == true) {
                    $result = 'success';
                    CommonMailer::sendMailRecoverPassword($mixedResult['user']);
                } else {
                    $result = 'error';
                }
                $message = $mixedResult['message'];
                Yii::app()->user->setFlash($result, $message);
            }
        }$this->render('recoverPwd', array('model' => $model,));
    }

    /**
     * action to subscribe a new user account.
     */
    public function actionSubscribe() {

        $model = new User ();
        $model->setScenario('subscribe');
        if (isset($_POST ['User'])) {
            $model->attributes = $_POST ['User'];
            $model->profil = 0;
            $model->inactif = 1;

            if ($model->save()) {
                CommonMailer::sendSubscribeAdminMail($model);
                CommonMailer::sendSubscribeUserMail($model);
                Yii::app()->user->setFlash('success', Yii::t('common', 'success_register'));
                if (isset($_GET['layout'])) {
                    if ($_GET['layout'] == 'vitrine_layout') {
                        $this->redirect(array(
                            'vitrine/view', 'id' => $_SESSION['biobank_id']
                        ));
                    }
                } else
                    $this->redirect(array(
                        'site/index'
                    ));
            } else {
                Yii::app()->user->setFlash('error', Yii::t('common', 'error_register'));
            }
        }
        $this->render('subscribe', array(
            'model' => $model
                )
        );
    }

}