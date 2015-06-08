<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UploadFormController extends Controller
{
    public $layout = '//layouts/main';

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
                    'uploadAll',
                ),
                'users' => array(
                    '$user->isAdmin()'
                )
            ),
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions() {

    }

    public function actionUploadAll() {
        $model = new Biobank();
        $model->initSoftAttribute('presentation');
        $model->initSoftAttribute('thematiques');
        $model->initSoftAttribute('publications');
        $model->initSoftAttribute('reseaux');
        $model->initSoftAttribute('qualite');
        $model->initSoftAttribute('projetRecherche');
        $model->initSoftAttribute('activeLogo');
        $listFile = array();
        $fichier = null;
        if (is_dir(Yii::app()->basePath . '/../images/extractedLogos/'))
            $listFile = scandir(Yii::app()->basePath . '/../images/extractedLogos/');
        if (isset($listFile[2]) && !is_dir($listFile[2]))
            $fichier = $listFile[2];
        if (isset($_POST['Biobank'])) {

            $biobank = Biobank::model()->findByAttributes(array('identifier' => $_POST['Biobank']['identifier']));
            if ($biobank != null) {
                $biobank->initSoftAttribute('presentation');
                $biobank->initSoftAttribute('thematiques');
                $biobank->initSoftAttribute('publications');
                $biobank->initSoftAttribute('reseaux');
                $biobank->initSoftAttribute('qualite');
                $biobank->initSoftAttribute('projetRecherche');
                $biobank->attributes = $_POST['Biobank'];
                //$folder = Yii::app()->basePath . '/../images/extractedLogos/';
                // $biobank->validate();
//                if (isset($_POST['importLogo']) && $_POST['importLogo'] == 1) {
//                    $file = $folder . $fichier;
//                    $biobank->initSoftAttribute('activeLogo');
//
//                    $biobank->activeLogo = (string) $this->logoUpload($file, $biobank);
//                    if (rename($file, $folder . 'done/' . $fichier)) {
//                        $listFile = scandir(Yii::app()->basePath . '/../images/extractedLogos/');
//                        $fichier = $listFile[2];
//                        Yii::app()->user->setFlash('success', 'renamed');
//                    } else {
//                        Yii::app()->user->setFlash('error', 'error on rename');
//                    }
//                    Yii::app()->user->setFlash('success', 'imported');
//                } else {
//                    Yii::app()->user->setFlash('success', 'logo not imported');
//                }

                if (isset($_FILES['Logo'])) {

                    $biobank->initSoftAttribute('activeLogo');
                    $biobank->activeLogo = (string) $this->storeLogo($_FILES['Logo'], $biobank);
                }
                if ($biobank->update()) {
                    Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success') . 'Biobank infos saved');

                    unset($_POST['Biobank']);
                } else {
                    $list = '';
                    foreach ($biobank->errors as $errorName => $errorName)
                        $list .= "<li>$errorName</li>";
                    Yii::app()->user->setFlash('error', 'error on save : <ul>' . $list . '</ul>');
                }
            } else {
                Yii::app()->user->setFlash('error', 'biobank not found');
            }
        }
        if ($fichier != '.' && $fichier != '..') {

            $this->render('upload', array(
                'logo' => $fichier,
                'model' => $model,
                'listLogos' => $listFile
            ));
        }
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
                    Yii::app()->user->setFlash('success', 'logo saved - ');
                    return $model->_id;
                } else
                    echo 'not save second';
            } else
                echo'not saved first';
        }else {
            Yii::app()->user->setFlash('error', 'Not a valid picture file');
        }
    }

}