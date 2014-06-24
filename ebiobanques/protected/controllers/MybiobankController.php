<?php

/**
 * controller de la partie administration.<br>
 * Administration du site avec users, biobanks etc.
 *
 * @author nicolas
 *
 */
class MybiobankController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/menu_mybiobank';

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
            array('allow', // allow authenticated user to perform 'search' actions
                'actions' => array('index', 'dashboard', 'update', 'echManage', 'bbManage', 'view', 'update', 'delete', 'benchmark', 'detailGraph'),
                'expression' => '$user->isBiobankAdmin()',
            ),
            array('allow', // allow authenticated user to perform 'search' actions
                'actions' => array('indexAdmin', 'dashboard', 'update', 'echManage', 'bbManage', 'view', 'update', 'delete', 'benchmark', 'detailGraph'),
                'expression' => '$user->isAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array();
    }

    public function actionIndexAdmin() {
        $id = $_GET['id'];
        $this->indexForBiobank($id);
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        $id = Yii::app()->user->biobank_id;



//        $lastImportDate = FileImported::model()->getDateLastImportByBiobank($id);
//        $today = date('Y-m-d H:i:s');
//        $diffSec = strtotime($today) - strtotime($lastImportDate);
//        $diffJours = round($diffSec / 60 / 60 / 24, 0);
//        /*  if ($diffJours < 10)
//          Yii::app()->user->setFlash('success', 'Votre dernier import date du ' . date('d/m/y', strtotime($lastImportDate)) . ', soit ' . $diffJours . ' jours.');
//          elseif ($diffJours < 30)
//          Yii::app()->user->setFlash('notice', 'Votre dernier import date du ' . date('d/m/y', strtotime($lastImportDate)) . ', soit ' . $diffJours . ' jours.');
//          else
//          Yii::app()->user->setFlash('error', 'Votre dernier import date du ' . date('d/m/y', strtotime($lastImportDate)) . ', soit ' . $diffJours . ' jours. Merci de réactualiser les données.');
//
//         */
//        $args = array();
//        $args['diffJours'] = $diffJours;
//        if (Yii::app()->getLocale()->id == "fr")
//            $args['lastImportDate'] = CommonTools::toShortDateFR(date('d/m/y', strtotime($lastImportDate)));
//        else if (Yii::app()->getLocale()->id == "en")
//            $args['lastImportDate'] = CommonTools::toShortDateEN(date('d/m/y', strtotime($lastImportDate)));
//        $args['status'] = 'success';
//        if ($diffJours < 10)
//            $args['status'] = 'success';
//
//
//
////            Yii::app()->user->setFlash('success', Yii::t('common', 'lastImportMessage',array('lastImportDate'=>date('d/m/y', strtotime($lastImportDate)))));
//        elseif ($diffJours < 30)
//            $args['status'] = 'notice';
//
////            Yii::app()->user->setFlash('notice', 'Votre dernier import date du ' . date('d/m/y', strtotime($lastImportDate)) . ', soit ' . $diffJours . ' jours.');
//        else
////            Yii::app()->user->setFlash('error', 'Votre dernier import date du ' . date('d/m/y', strtotime($lastImportDate)) . ', soit ' . $diffJours . ' jours. Merci de réactualiser les données.');
//            $args['status'] = 'error';
//        Yii::app()->user->setFlash($args['status'], Yii::t('myBiobank', 'lastImportMessage' . '_' . $args['status'], $args));
//        $model = $this->loadModel($id);
//        $this->render('index', array(
//            'model' => $model,
//        ));
    }

    /**
     * affichage de la page d'update de la biobanque
     */
    public function actionbbManage() {
        $id = Yii::app()->user->biobank_id;
        $model = $this->loadModel($id);

        if (isset($_POST['Biobank'])) {
            $model->attributes = $_POST['Biobank'];
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * affichage du module de gestion des echantillons de la biobanque
     */
    public function actionEchManage() {
        $model = new Sample('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Sample']))
            $model->attributes = $_GET['Sample'];

        $this->render('echManage', array(
            'model' => $model,
        ));
    }

    public function actionView($id) {
        $this->render('echView', array(
            'model' => $this->loadEchModel($id),
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadEchModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Sample'])) {
            $model->attributes = $_POST['Sample'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('echUpdate', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadEchModel($id)->delete();

// 		if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('echManage'));
    }

    /**
     * affichage du tableau de bord
     */
    public function actionDashboard() {
        $this->render('dashboard');
    }

    public function actionBenchmark() {

        if (isset($_GET['limit']))
            $limit = $_GET['limit'];
        else
            $limit = 60;

        $biobankId = Yii::app()->user->biobank_id;


        $biobankStats = BiobankStats::model()->getByBiobank($biobankId, $limit);
        $globalStats = BiobankStats::model()->getByBiobank("0", $limit);
        if ($biobankStats != null && !empty($biobankStats) && $globalStats != null && !empty($globalStats)) {
            $this->render('benchmarking', array(
                'globalStats' => $globalStats,
                'biobankStats' => $biobankStats,
            ));
        } else {
            $model = $this->loadModel($biobankId);
            Yii::app()->user->setFlash('error', Yii::t('myBiobank', 'noRequiredStats'));

            $this->render('index', array(
                'model' => $model,
            ));
        }
    }

    public function actionDetailGraph() {
        $datas = $_POST['datas'];
        $attributeName = $_POST['attributeName'];
        $theme = $_POST['theme'];
        // echo $attributeName . $datas[2] . $theme;
        $this->renderPartial('_renderWidget', array('datas' => $datas, 'attributeName' => $attributeName, 'theme' => $theme));
//        $this->renderPartial('_renderWidget', array( 'attributeName' => $attributeName ));
//        $this->renderPartial('_renderWidget', array( 'theme' => $theme));
    }

    public function loadModel($id) {
        $model = Biobank::model()->findByAttributes(array('id' => $id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadEchModel($id) {
        $model = Sample::model()->findByPk(new MongoID($id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function indexForBiobank($id) {
        $lastImportDate = FileImported::model()->getDateLastImportByBiobank($id);
        $today = date('Y-m-d H:i:s');
        $diffSec = strtotime($today) - strtotime($lastImportDate);
        $diffJours = round($diffSec / 60 / 60 / 24, 0);
        /*  if ($diffJours < 10)
          Yii::app()->user->setFlash('success', 'Votre dernier import date du ' . date('d/m/y', strtotime($lastImportDate)) . ', soit ' . $diffJours . ' jours.');
          elseif ($diffJours < 30)
          Yii::app()->user->setFlash('notice', 'Votre dernier import date du ' . date('d/m/y', strtotime($lastImportDate)) . ', soit ' . $diffJours . ' jours.');
          else
          Yii::app()->user->setFlash('error', 'Votre dernier import date du ' . date('d/m/y', strtotime($lastImportDate)) . ', soit ' . $diffJours . ' jours. Merci de réactualiser les données.');

         */
        $args = array();
        $args['diffJours'] = $diffJours;
        if (Yii::app()->getLocale()->id == "fr")
            $args['lastImportDate'] = CommonTools::toShortDateFR(date('d/m/y', strtotime($lastImportDate)));
        else if (Yii::app()->getLocale()->id == "en")
            $args['lastImportDate'] = CommonTools::toShortDateEN(date('d/m/y', strtotime($lastImportDate)));
        $args['status'] = 'success';
        if ($diffJours < 10)
            $args['status'] = 'success';



//            Yii::app()->user->setFlash('success', Yii::t('common', 'lastImportMessage',array('lastImportDate'=>date('d/m/y', strtotime($lastImportDate)))));
        elseif ($diffJours < 30)
            $args['status'] = 'notice';

//            Yii::app()->user->setFlash('notice', 'Votre dernier import date du ' . date('d/m/y', strtotime($lastImportDate)) . ', soit ' . $diffJours . ' jours.');
        else
//            Yii::app()->user->setFlash('error', 'Votre dernier import date du ' . date('d/m/y', strtotime($lastImportDate)) . ', soit ' . $diffJours . ' jours. Merci de réactualiser les données.');
            $args['status'] = 'error';
        Yii::app()->user->setFlash($args['status'], Yii::t('myBiobank', 'lastImportMessage' . '_' . $args['status'], $args));
        $model = $this->loadModel($id);
        $this->render('index', array(
            'model' => $model,
        ));
    }

}