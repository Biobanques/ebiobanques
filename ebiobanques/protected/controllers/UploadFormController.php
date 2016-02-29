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
                'expression' => '$user->isAdmin()',
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
        $listFile = array();
//      $fichier = null;

        $biobankIdentifier = new BiobankIdentifierForm();
        if (!isset($model->presentation))
            $model->initSoftAttribute('presentation');
        if (!isset($model->thematiques))
            $model->initSoftAttribute('thematiques');
        if (!isset($model->presentation_en))
            $model->initSoftAttribute('presentation_en');
        if (!isset($model->thematiques_en))
            $model->initSoftAttribute('thematiques_en');
        if (!isset($model->publications))
            $model->initSoftAttribute('publications');
        if (!isset($model->reseaux))
            $model->initSoftAttribute('reseaux');
        if (!isset($model->qualite))
            $model->initSoftAttribute('qualite');
        if (!isset($model->projetRecherche))
            $model->initSoftAttribute('projetRecherche');
        if (!isset($model->qualite_en))
            $model->initSoftAttribute('qualite_en');
        if (!isset($model->projetRecherche_en))
            $model->initSoftAttribute('projetRecherche_en');
        if (!isset($model->activeLogo))
            $model->initSoftAttribute('activeLogo');


//        if (is_dir(Yii::app()->basePath . '/../images/extractedLogos/'))
//            $listFile = scandir(Yii::app()->basePath . '/../images/extractedLogos/');


        if (isset($_POST['BiobankIdentifierForm']) && isset($_POST['BiobankIdentifierForm']['identifier']) && $_POST['BiobankIdentifierForm']['identifier'] != "") {
            $model = Biobank::model()->findByAttributes(array('identifier' => $_POST['BiobankIdentifierForm']['identifier']));
            if (!isset($model->presentation))
                $model->initSoftAttribute('presentation');
            if (!isset($model->thematiques))
                $model->initSoftAttribute('thematiques');
            if (!isset($model->presentation_en))
                $model->initSoftAttribute('presentation_en');
            if (!isset($model->thematiques_en))
                $model->initSoftAttribute('thematiques_en');
            if (!isset($model->publications))
                $model->initSoftAttribute('publications');
            if (!isset($model->reseaux))
                $model->initSoftAttribute('reseaux');
            if (!isset($model->qualite))
                $model->initSoftAttribute('qualite');
            if (!isset($model->projetRecherche))
                $model->initSoftAttribute('projetRecherche');
            if (!isset($model->qualite_en))
                $model->initSoftAttribute('qualite_en');
            if (!isset($model->projetRecherche_en))
                $model->initSoftAttribute('projetRecherche_en');
            if (!isset($model->activeLogo))
                $model->initSoftAttribute('activeLogo');
        }
        if (isset($_POST['Biobank'])) {

            $model = Biobank::model()->findByAttributes(array('identifier' => $_POST['Biobank']['identifier']));



            if (!isset($model->presentation)) {
                $model->initSoftAttribute('presentation');
            }
            $model->presentation = $_POST['Biobank']['presentation'];
            // print_r($model->getErrors());

            if (!isset($model->thematiques)) {
                $model->initSoftAttribute('thematiques');
            }
            $model->thematiques = $_POST['Biobank']['thematiques'];

            if (!isset($model->presentation_en)) {
                $model->initSoftAttribute('presentation_en');
            }
            $model->presentation_en = $_POST['Biobank']['presentation_en'];
            // print_r($model->getErrors());

            if (!isset($model->thematiques_en)) {
                $model->initSoftAttribute('thematiques_en');
            }
            $model->thematiques_en = $_POST['Biobank']['thematiques_en'];

            if (!isset($model->publications)) {
                $model->initSoftAttribute('publications');
            }
            $model->publications = $_POST['Biobank']['publications'];

            if (!isset($model->reseaux)) {
                $model->initSoftAttribute('reseaux');
            }
            $model->reseaux = $_POST['Biobank']['reseaux'];

            if (!isset($model->qualite)) {
                $model->initSoftAttribute('qualite');
            }

            $model->qualite = $_POST['Biobank']['qualite'];

            if (!isset($model->projetRecherche)) {
                $model->initSoftAttribute('projetRecherche');
            }
            $model->projetRecherche = $_POST['Biobank']['projetRecherche'];

            if (!isset($model->qualite_en))
                $model->initSoftAttribute('qualite_en');
            $model->qualite_en = $_POST['Biobank']['qualite_en'];

            if (!isset($model->projetRecherche_en))
                $model->initSoftAttribute('projetRecherche_en');
            $model->projetRecherche_en = $_POST['Biobank']['projetRecherche_en'];

            if ($model->save(false)) {
                Yii::app()->user->setFlash('success', 'La biobanque a bien été mise à jour.');
            } else
                Yii::app()->user->setFlash('error', 'La biobanque n\'a pas pu être mise à jour');
        }


        $this->render('upload', array(
//          'logo' => $fichier,
            'model' => $model,
            'listLogos' => $listFile,
            'biobankIdentifier' => $biobankIdentifier,
        ));



//        }
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