<?php

/**
 * controller de la partie administration.<br>
 * Administration du site avec users, biobanks etc.
 *
 * @author nicolas
 *
 */
class UploadedFileController extends Controller
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
                'actions' => array('admin'),
                'expression' => '$user->isBiobankAdmin()||$user->isAdmin()',
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

    public function actionAdmin() {
        $model = new UploadedFile();
        if (isset($_POST['UploadedFile']['fileUploaded'])) {
            $add = false;
            if (isset($_POST['addOrRemove']) && $_POST['addOrRemove'] == 'add')
                $add = true;
            $fileId = $this->uploadEchFile($_FILES['UploadedFile']);
            if ($fileId != null) {
                $file = CommonTools::importFile($this->loadModel($fileId), $add);
            } else {

            }
        }
        $this->render('admin', array('model' => $model));
    }

    public function loadModel($id) {
        $model = UploadedFile::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    private function uploadEchFile($file) {
        if (Yii::app()->user->isAdmin())
            $biobank_id = $_SESSION['biobank_id'];
        else
            $biobank_id = Yii::app()->user->biobank_id;
        $model = new UploadedFile();
        $_SESSION['biobank_id'] = $biobank_id;
        if (isset($file)) {
            $tempFilename = $file["tmp_name"]['fileUploaded'];
            $filename = $file["name"]['fileUploaded'];
            if ($file['size']['fileUploaded'] < 15000000) {

                $splitted = explode(".", $filename);
                $extension = end($splitted);
                if (in_array($extension, array('csv', 'xls', 'xlsx'))) {
                    $model->filename = $tempFilename;
                    $model->metadata['biobank_id'] = $biobank_id;

                    $model->uploadDate = new MongoDate();

                    if ($model->save()) {
                        $model->filename = $filename;
                        if ($model->save()) {
                            Yii::app()->user->setFlash('success', "$filename successfully saved with id $model->_id.");
                            return $model->_id;
                        } else {
                            Yii::app()->user->setFlash('error', "Saving error");
                            return null;
                        }
                    } else {
                        Yii::app()->user->setFlash('error', "Saving error");
                        return null;
                    }
                } else {
                    Yii::app()->user->setFlash('error', "$filename is not a valid  file.");
                    return null;
                }
            } else {
                Yii::app()->user->setFlash('error', "$filename is too big");

                return null;
            }
        } else
            return null;
    }

}