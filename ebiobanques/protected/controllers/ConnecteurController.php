<?php

/**
 * controller de la partie administration.<br>
 * Administration du site avec users, biobanks etc.
 *
 * @author nicolas
 *
 */
class ConnecteurController extends Controller
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
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'download'),
                'expression' => '$user->isBiobankAdmin()',
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'download', 'upload'),
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

        if (Yii::app()->user->isAdmin())
            $id = $_SESSION['biobank_id'];
        else
            $id = Yii::app()->user->biobank_id;
        $model = Connecteur::model()->findAllByAttributes(array('metadata.biobank_id' => $id));
        $sort = new CSort();
        $sort->attributes = array('uploadDate');
        $sort->defaultOrder = 'uploadDate DESC';
        $dataProvider = new CArrayDataProvider($model, array('keyField' => '_id', 'sort' => $sort));
        $this->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

    public function actionDownload() {

        $id = $_GET['id'];
        $file = Connecteur::model()->findByPk(new MongoId($id));
        $splitStringArray = split("/", $file->filename);
        $fileName = end($splitStringArray);
        header('Content-Type: application/java-archive');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        echo $file->getBytes();
    }

    public function actionUpload() {
        if (isset($_GET['biobank_id']))
            $biobank_id = $_GET['biobank_id'];
        else
            $biobank_id = $_SESSION['biobank_id'];
        $model = new Connecteur();
        $_SESSION['biobank_id'] = $biobank_id;
        if (isset($_FILES['Connecteur'])) {
            $tempFilename = $_FILES["Connecteur"]["tmp_name"]['filename'];
            $filename = $_FILES["Connecteur"]["name"]['filename'];
            if (substr($filename, -4) == '.jar') {
                $model->filename = $tempFilename;
                $model->metadata['biobank_id'] = $biobank_id;

                $model->uploadDate = new MongoDate();

                if ($model->save()) {
                    $model->filename = $filename;
                    if ($model->save()) {
                        Yii::app()->user->setFlash('success', "The connector $filename has been successfully uploaded.");

                        $this->redirect(yii::app()->user->returnUrl);
                    }
                }
            } else {
                Yii::app()->user->setFlash('error', "$filename is not a valid .jar file.");
            }
        }
        Yii::app()->user->setReturnUrl(Yii::app()->request->urlReferrer);
        $this->render('create', array(
            'model' => $model,
        ));
    }

}