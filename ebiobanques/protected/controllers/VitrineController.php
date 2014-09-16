<?php

/**
 * user controller.
 * Used for admin tasks.
 * Access rights only for admin
 */
class VitrineController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/vitrine_layout';
    public $biobank;
    public $logo;

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'logoUpload', 'test'),
                'expression' => '$user->isAdmin()||$user->isBiobankAdmin()'
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('searchSample', 'logout'),
                'users' => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('view', 'login'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actions() {

        return array(
// page action renders "static" pages stored under 'protected/views/site/pages'
// They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView() {
        $id = $this->getBiobankId();

        $this->render('view');
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm ();
        $id = $this->getBiobankId();
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
                    'id_user' => Yii::app()->user->id,
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
                    $lastDemandRequest->id_user = Yii::app()->user->id;
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

        $this->render('/site/login', array(
            'model' => $model
        ));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('vitrine/view');
    }

    public function actionTest() {
        $id = $this->getBiobankId();

        $this->render('view');
    }

    public function getBiobankId() {
        if (isset($_GET['id']))
            $id = $_GET['id'];
        elseif (Yii::app()->user->isAdmin())
            $id = $_SESSION['biobank_id'];
        else
            $id = Yii::app()->user->biobank_id;
        $this->biobank = Biobank::getBiobank($id);
        $pk = $this->biobank->vitrine['logo'];
        $this->logo = Logo::model()->findByPk(new MongoId($pk));
        return $id;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new User;
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->update())
                $this->redirect(array('view', 'id' => $model->_id));
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionSearchSample() {
        $id = $this->getBiobankId();
        if (Yii::app()->user->isGuest)
            $this->redirect(array('login', 'id' => $this->biobank->id));

        $model = new Sample('search');
        $model->unsetAttributes();
        $model->biobank_id = $id;
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
            $content = '';
            foreach ($_GET ['Sample'] as $key => $value) {

                if ($value != null && !empty($value) && (string) $value != '0') {
                    $content = $content . (string) $key . '=' . str_replace(';', ',', (string) $value) . ';';
                }
            }
            if (Yii::app()->session ['SampleForm'] != $_GET ['Sample']) {
                $_GET ['Echantillon_page'] = null;
//$this->logAdvancedSearch($content);
            }
            Yii::app()->session ['SampleForm'] = $_GET ['Sample'];
        }
//form de la recherche intelligente
        $smartForm = new SampleSmartForm ();
        if (isset($_POST ['SampleSmartForm'])) {
            $model->unsetAttributes();
            $model->biobank_id = $id;
            $smartForm->attributes = $_POST ['SampleSmartForm'];
            if (Yii::app()->session ['keywords'] != $smartForm->keywords) {
                $_GET ['Echantillon_page'] = null;
//$this->logSmartSearch($smartForm->keywords);
            }
            Yii::app()->session ['keywords'] = $smartForm->keywords;
            $model = SmartResearcherTool::search($smartForm->keywords, $this->biobank->id);
        }
        $this->render('search_samples', array(
            'model' => $model,
            'smartForm' => $smartForm
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/menu_mybiobank';
        if (Yii::app()->user->isAdmin())
            $id = $_SESSION['biobank_id'];
        else
            $id = Yii::app()->user->biobank_id;
        $model = Biobank::model()->findByAttributes(array("id" => $id));
        if (!isset($model->vitrine))
            $model->vitrine = array();
        $model->vitrine['fr'] = null;
// $model->vitrine['en'] = null;
        $vitrine = $model->vitrine;
        if (isset($_POST['Biobank'])) {
            $model->attributes = $_POST['Biobank'];
            $model->vitrine['fr'] = $_POST['Biobank']['vitrine']['fr'];
            if (isset($_FILES['Biobank']))
                $model->vitrine['logo'] = $this->logoUpload($_FILES['Biobank']);

            if (!$model->save())
                Yii::app()->user->setFlash('error', 'Probleme de sauvegarde');
        }
        $this->render('admin', array("model" => $model));
    }

    private function logoUpload() {
        if (Yii::app()->user->isAdmin())
            $biobank_id = $_SESSION['biobank_id'];
        else
            $biobank_id = Yii::app()->user->biobank_id;
        $model = new Logo();
        $_SESSION['biobank_id'] = $biobank_id;
        if (isset($_FILES['Biobank'])) {
            $tempFilename = $_FILES["Biobank"]["tmp_name"]['vitrine']['logo'];
            $filename = $_FILES["Biobank"]["name"]['vitrine']['logo'];
            if ($_FILES['Biobank']['size']['vitrine']['logo'] < 1000000) {
// print_r($_FILES['Biobank']['size']['vitrine']['logo']);

                if (in_array(substr($filename, -4), array('.jpg', '.png')) || in_array(substr($filename, -5), array('.jpeg'))) {
                    $model->filename = $tempFilename;
                    $model->metadata['biobank_id'] = $biobank_id;

                    $model->uploadDate = new MongoDate();

                    if ($model->save()) {
                        $model->filename = $filename;
                        if ($model->save()) {
//                        Yii::app()->user->setFlash('success', "The picture $filename has been successfully uploaded.");
                            return $model->_id;
                        }
                    }
                } else {
                    Yii::app()->user->setFlash('error', "$filename is not a valid picture file.");
                }
            } else {
                Yii::app()->user->setFlash('error', "$filename is too big");
            }
        }
    }

//    public function affich($id) {
//        $file = logo::model()->findByPk(new MongoId($id));
//
//        return $file;
//    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Biobank::model()->findByPk(new MongoID($id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}