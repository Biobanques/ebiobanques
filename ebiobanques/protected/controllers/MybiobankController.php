<?php

/**
 * controller de la partie administration.<br>
 * Administration du site avec users, biobanks etc.
 *
 * @author nicolas
 *
 */
class MybiobankController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/basic_column_layout';
   // public $layout = '//layouts/menu_mybiobank';

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
                'actions' => array('index', 'dashboard', 'update', 'echManage', 'bbManage', 'view', 'update', 'delete', 'benchmark', 'detailGraph', 'uploadEchFile', 'logImports'),
                'expression' => '$user->isBiobankAdmin()',
            ),
            array('allow', // allow authenticated user to perform 'search' actions
                'actions' => array('indexAdmin', 'index', 'dashboard', 'update', 'echManage', 'bbManage', 'view', 'update', 'delete', 'benchmark', 'detailGraph', 'uploadEchFile', 'logImports'),
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

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
       if (!isset($_SESSION['biobank_id'])) {
            if (Yii::app()->user->isAdmin() && isset($_GET['id'])) {
                $id = $_GET['id'];
            } elseif (Yii::app()->user->isBiobankAdmin()) {
               $id = Yii::app()->user->biobank_id;
            }
            $_SESSION['biobank_id'] = $id;
        }
            $model = $this->loadModel($_SESSION['biobank_id']);


        if (isset($_POST['Biobank'])) {
            $model->scenario = 'update';          // custom scenario

            $attributesPost = $_POST['Biobank'];
            Yii::log('setting biobank attributes from POST variable', CLogger::LEVEL_WARNING);
            $model->attributes = $attributesPost;
            if (isset($_POST['Address'])) {
                $model->address = $_POST['Address'];
            }
            if (isset($_POST['Op_resp']) && $_POST['Op_resp']['lastName'] != null && $_POST['Op_resp']['lastName'] != "") {
                $model->responsable_op = $_POST['Op_resp'];
            }
            if (isset($_POST['Qual_resp']) && $_POST['Qual_resp']['lastName'] != null && $_POST['Qual_resp']['lastName'] != "") {
                $model->responsable_qual = $_POST['Qual_resp'];
            }
            if (isset($_POST['Adj_resp']) && $_POST['Adj_resp']['lastName'] != null && $_POST['Adj_resp']['lastName'] != "") {
                $model->responsable_adj = $_POST['Adj_resp'];
            }$contact = $model->contact;
            if (isset($_POST['Contact'])) {
                foreach ($_POST['Contact'] as $contactAttrName => $contactAttrValue) {
                    $contact->$contactAttrName = $contactAttrValue;
                }
            }
            Yii::log('saving biobank', CLogger::LEVEL_WARNING);
            if ($model->save()) {
                if ($contact->save())
                    Yii::app()->user->setFlash('success', 'La biobanque a bien été mise à jour.');
                else
                    Yii::app()->user->setFlash('notice', 'La biobanque a bien été mise à jour. Les informations liées au coordinateur n\'ont pas pu être sauvegardées');
                $model->contact = $contact;
            } else
                Yii::app()->user->setFlash('error', 'La biobanque n\'a pas pu être mise à jour');
        }
        $this->render('simplifiedUpdate', array(
            'biobank' => $model,
        ));
    }

    
    
    
    
    
    public function actionUpdate($id) {
        $model = $this->loadModel($id);


        if (isset($_POST['Biobank'])) {
            $model->scenario = 'update';          // custom scenario

            $attributesPost = $_POST['Biobank'];
            Yii::log('creating softattributes if not exists ', CLogger::LEVEL_WARNING);

            foreach ($attributesPost as $attName => $attValue) {
                if (!in_array($attName, $model->attributeNames())) {
                    $model->initSoftAttribute($attName);
                }
            }
            Yii::log('setting biobank attributes from POST variable', CLogger::LEVEL_WARNING);
            $model->attributes = $attributesPost;
            if (isset($_FILES['Logo']) && $_FILES['Logo']['name']['filename'] != "") {

                $model->initSoftAttribute('activeLogo');
                $model->activeLogo = (string) $this->storeLogo($_FILES['Logo'], $model);
            }
            if (isset($_POST['Address'])) {

                $model->address = $_POST['Address'];
            }
            //update contacts embedded documents
            if (isset($_POST['Contact_resp']) && $_POST['Contact_resp']['lastName'] != null && $_POST['Contact_resp']['lastName'] != "") {
                $model->contact_resp = $_POST['Contact_resp'];
            }
            if (isset($_POST['Op_resp']) && $_POST['Op_resp']['lastName'] != null && $_POST['Op_resp']['lastName'] != "") {
                $model->responsable_op = $_POST['Op_resp'];
            }
            if (isset($_POST['Qual_resp']) && $_POST['Qual_resp']['lastName'] != null && $_POST['Qual_resp']['lastName'] != "") {
                // if (isset($_POST['Qual_resp'])) {
                $model->responsable_qual = $_POST['Qual_resp'];
            }
            if (isset($_POST['Adj_resp']) && $_POST['Adj_resp']['lastName'] != null && $_POST['Adj_resp']['lastName'] != "") {
                //if (isset($_POST['Adj_resp'])) {
                $model->responsable_adj = $_POST['Adj_resp'];
            }
           // $contact = $model->contact;
            //if (isset($_POST['Contact'])) {
            
            //    foreach ($_POST['Contact'] as $contactAttrName => $contactAttrValue) {
           //       $contact->$contactAttrName = $contactAttrValue;
           //     }
           // }
            Yii::log('saving biobank', CLogger::LEVEL_WARNING);
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'La biobanque a bien été mise à jour.');
                
      
                // $this->redirect(array('view', 'id' => $model->_id));
            } else
                Yii::app()->user->setFlash('error', 'La biobanque n\'a pas pu être mise à jour');
        }

//        $this->render('update', array(
//            'model' => $model,
//        ));
        $this->render('simplifiedUpdate', array(
            'biobank' => $model,
        ));
    }
    
    
    
    
    
    
    /**
     * affichage de la page d'update de la biobanque
     */
    public function actionbbManage() {
        if (Yii::app()->user->isAdmin()) {
            $id = $_SESSION['biobank_id'];
        } else {
            $id = Yii::app()->user->biobank_id;
        }
        $model = $this->loadModel($id);
        if (isset($_POST['Biobank'])) {
            $model->attributes = $_POST['Biobank'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Les informations de votre biobanque ont été enregistrées avec succès.');
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * affichage du module de gestion des echantillons de la biobanque
     */
    public function actionEchManage() {
        if (Yii::app()->user->isAdmin())
            $id = $_SESSION['biobank_id'];
        else
            $id = Yii::app()->user->biobank_id;
        //  $model = $this->loadModel($id);
        $model = new Sample('search');
        $model->unsetAttributes();  // clear any default values
        $model->biobank_id = $id;
        if (isset($_GET['Sample']))
            $model->attributes = $_GET['Sample'];


        $user = CommonTools::getConnectedUser();
        if (isset($_GET ['Preferences'])) {
            $user->preferences->attributes = $_GET ['Preferences'];
            $user->disableBehavior('LoggableBehavior');
            if ($user->validate(array('preferences')))
                $user->save(false);
            else {
                var_dump($user->preferences->errors);
            }
        }
        if (isset($_POST['Sample'])) {
            $model->attributes = $_POST['Sample'];
        }
        $this->render('search_samples', array(
            'model' => $model,
            'biobank_id' => $id
        ));
//        $this->render('echManage', array(
//            'model' => $model,
//            'biobank_id' => $id
//        ));
    }

    public function actionView($id) {
        $this->render('echView', array(
            'model' => $this->loadEchModel($id),
        ));
    }

    
    
    
    
    /**
     * Updates my biobank
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionEchUpdate($id) {
        $model = $this->loadEchModel($id);
        if (isset($_POST['Sample'])) {
            $model->attributes = $_POST['Sample'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->_id));
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
     * display the log of imported files
     */
    public function actionLogImports() {
        if (Yii::app()->user->isAdmin())
            $id = $_SESSION['biobank_id'];
        else
            $id = Yii::app()->user->biobank_id;
        $model = new FileImported('search');
        $model->unsetAttributes();  // clear any default values
        $model->biobank_id = $id;
        if (isset($_GET['FileImported']))
            $model->attributes = $_GET['FileImported'];

        $this->render('log_files_imported', array(
            'model' => $model,
        ));
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
        if (Yii::app()->user->isAdmin())
            $biobankId = $_SESSION['biobank_id'];
        else
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
        $this->renderPartial('_renderWidget', array('datas' => $datas, 'attributeName' => $attributeName, 'theme' => $theme));
    }

    /**
     * load a biobank by mongo id
     * @param type $id
     * @return type
     * @throws CHttpException
     */
    public function loadModel($mongoId) {
        if ($mongoId == null) {
            return null;
        } else {
            try {
                $objMongoId = new MongoId($mongoId);
                $model = Biobank::model()->findByPK($objMongoId);
                if ($model === null)
                    throw new CHttpException(404, 'The requested page does not exist.');
                return $model;
            } catch (MongoException $ex) {
                //log error
                Yii::log("error mongo exception on id mongo:".$mongoId,'error', 'application');
            }
        }
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
        $args = array();
        $args['diffJours'] = $diffJours;
        if (Yii::app()->getLocale()->id == "fr")
            $args['lastImportDate'] = CommonTools::toShortDateFR($lastImportDate);
        else if (Yii::app()->getLocale()->id == "en")
            $args['lastImportDate'] = CommonTools::toShortDateEN($lastImportDate);
        $args['status'] = 'success';
        if ($diffJours < 10)
            $args['status'] = 'success';

        elseif ($diffJours < 30)
            $args['status'] = 'notice';
        else
            $args['status'] = 'error';
        Yii::app()->user->setFlash($args['status'], Yii::t('myBiobank', 'lastImportMessage' . '_' . $args['status'], $args));
        $model = $this->loadModel($id);
        Yii::app()->params['biobank'] = $model;
        $this->render('index', array(
            'model' => $model,
        ));
    }

}
