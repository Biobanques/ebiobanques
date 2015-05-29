<?php

class BiobankController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/menu_administration';

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
                'actions' => array('index', 'create', 'admin', 'view', 'update', 'delete', 'deleteFlashMsg'),
                'expression' => '$user->isAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionDeleteFlashMsg($flashMessages) {

        $messageResult = '';
//        $flashMessages = Yii::app()->user->getFlashes();
        if ($flashMessages) {
            foreach ($flashMessages as $key => $message) {
                $messageResult.= '<br><div class="flash-' . $key . '">' . $message . "</div>";
            }
        }
        echo $messageResult;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $name = $model->name;


        $sampleCount = Sample::model()->countByAttributes(array('biobank_id' => (string) $model->id));
        $adminCount = User::model()->countByAttributes(array('biobank_id' => (string) $model->_id));
        if ($adminCount == 0 && $sampleCount == 0) {

            try {
                $model->delete();
                Yii::app()->user->setFlash('success', 'La biobanque a bien été supprimée.');
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('error', 'La biobanque n\'a pas pu être supprimée : ' . $ex->getMessage());
            }
        } else {
            $message = "Suppression de la biobanque \"$name\" impossible : ";
            if ($adminCount > 0)
                $message.="<br> - Il reste $adminCount administrateur(s) lié(s) à la biobanque.";
            if ($sampleCount > 0)
                $message.="<br> reste $sampleCount échantillon(s) lié(s) à la biobanque.";


            Yii::app()->user->setFlash('error', $message);
        }


// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        else {
            $flashMessages = Yii::app()->user->getFlashes();
            $flashMessagesHtml = '';
            if ($flashMessages) {
                foreach ($flashMessages as $key => $message) {
                    $flashMessagesHtml.= '<br><div class="flash-' . $key . '">' . $message . "</div>";
                }
            }

            echo $flashMessagesHtml;
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Biobank('insert');
        if (isset($_POST['Biobank'])) {
            $attributesPost = $_POST['Biobank'];
            foreach ($attributesPost as $attName => $attValue) {
                if (!in_array($attName, $model->attributeNames())) {
                    $model->initSoftAttribute($attName);
                }
            }
            $model->attributes = $attributesPost;
            if (isset($_FILES['Logo'])) {

                $model->initSoftAttribute('activeLogo');
                $model->activeLogo = (string) $this->storeLogo($_FILES['Logo'], $model);
            }
            if (isset($_POST['Address'])) {
                $model->address = new Address('insert');
                $model->address = $_POST['Address'];
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'La biobanque a bien été créée.');
                $this->redirect(array('view', 'id' => $model->_id));
            } else
                Yii::app()->user->setFlash('error', 'La biobanque n\'a pas pu être enregistrée');
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


        if (isset($_POST['Biobank'])) {
            $model->scenario = 'update';          // custom scenario

            $attributesPost = $_POST['Biobank'];
            foreach ($attributesPost as $attName => $attValue) {
                if (!in_array($attName, $model->attributeNames())) {
                    $model->initSoftAttribute($attName);
                }
            }
            $model->attributes = $attributesPost;
            if (isset($_FILES['Logo'])) {

                $model->initSoftAttribute('activeLogo');
                $model->activeLogo = (string) $this->storeLogo($_FILES['Logo'], $model);
            }
            if (isset($_POST['Address'])) {

                $model->address = $_POST['Address'];
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'La biobanque a bien été mise à jour.');
                // $this->redirect(array('view', 'id' => $model->_id));
            } else
                Yii::app()->user->setFlash('error', 'La biobanque n\'a pas pu être mise à jour');
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    private function storeLogo($logo, $biobank) {
        //  print_r($logo);
        $model = new Logo();
        $tempFilename = $logo["tmp_name"]['filename'];
        //$fileName = $logo["name"]['filename'];
        $ext = pathinfo($logo['name']['filename'], PATHINFO_EXTENSION);

        if (in_array($ext, array('jpg', 'png', 'jpeg'))) {
            $model->filename = $tempFilename;
            $model->metadata['biobank_id'] = (string) $biobank->_id;

            $model->uploadDate = new MongoDate();

            if ($model->save()) {
                $model->filename = 'logo' . $biobank->identifier . ".$ext";
                if ($model->save()) {
                    echo 'saved';
                    return $model->_id;
                } else
                    echo 'not save second';
            } else
                echo'not saved first';
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new EMongoDocumentDataProvider('Biobank');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {


        $model = new Biobank('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Biobank']))
            $model->attributes = $_GET['Biobank'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Biobank the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Biobank::model()->findByPk(new MongoID($id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Biobank $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'biobank-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}