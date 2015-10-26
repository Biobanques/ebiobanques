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
        $listFile = array();
//      $fichier = null;
        
        if (is_dir(Yii::app()->basePath . '/../images/extractedLogos/'))
            $listFile = scandir(Yii::app()->basePath . '/../images/extractedLogos/');
//        if (isset($listFile[2]) && !is_dir($listFile[2]))
//            $fichier = $listFile[2];
//        if (isset($_POST['Biobank'])) {
            
            
            
            
//          if (Biobank::model()->findByAttributes(array('identifier' => $_POST['Biobank']['identifier']))) {
//               $model = Biobank::model()->findByAttributes(array('identifier' => $_POST['Biobank']['identifier']));
          
              
                    
              
//            }
               
//               $model->attributes = $_POST['Biobank'];
//                if (isset($_POST['importLogo']) && $_POST['importLogo'] == 1) {
//                    $file = $folder . $fichier;
//                    $model->initSoftAttribute('activeLogo');
//
//                    $model->activeLogo = (string) $this->logoUpload($file, $model);
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
//
//                if (isset($_FILES['Logo'])) {
//
//
//                    $model->activeLogo = (string) $this->storeLogo($_FILES['Logo'], $model);
//                }
//              if ($model->save()) {
//                  
//                    Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success') . 'Biobank infos saved');
//               }
//                    if (isset($_FILES['Logo'])) {
//
//                        $model->initSoftAttribute('activeLogo');
//                        $model->activeLogo = (string) $this->storeLogo($_FILES['Logo'], $model);
//                    }
                   /* if ($model->update()) {
                       Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success') . 'Biobank infos saved');

                    unset($_POST['Biobank']);
                    } else {
//                        $list = '';
//                        foreach ($model->errors as $errorName => $errorName)
//                            $list .= "<li>$errorName</li>";
//                        Yii::app()->user->setFlash('error', 'error on save : <ul>' . $list . '</ul>');
                    }*/
//                }*/
//          } else {
//                Yii::app()->user->setFlash('error', 'biobank not found');
//            }
            
            if (isset($_POST['BiobankIdentifierForm']) && isset($_POST['BiobankIdentifierForm']['identifier']) && $_POST['BiobankIdentifierForm']['identifier'] != "") {
            $model = Biobank::model()->findByAttributes(array('identifier' => $_POST['BiobankIdentifierForm']['identifier']));
        
            }
            if (isset($_POST['BiobankIdentifierForm'])) {
                  
                  $model->attributes = $_POST['BiobankIdentifierForm'];
             //$model = Biobank::model()->findByAttributes(array('identifier' => $_POST['BiobankIdentifierForm']['identifier']));
            if($model->save()){
                Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success') . 'Biobank infos saved');
            }
              else
                  Yii::app()->user->setFlash('error', 'error on save : <ul>' . $list . '</ul>');
            
             }  
            
            
           
            
      
        
//        if ($fichier != '.' && $fichier != '..') {
       if (!isset($model->presentation))
            $model->initSoftAttribute('presentation');
        if (!isset($model->thematiques))
            $model->initSoftAttribute('thematiques');
        if (!isset($model->publications))
            $model->initSoftAttribute('publications');
        if (!isset($model->reseaux))
            $model->initSoftAttribute('reseaux');
        if (!isset($model->qualite))
            $model->initSoftAttribute('qualite');
        if (!isset($model->projetRecherche))
            $model->initSoftAttribute('projetRecherche');
        if (!isset($model->activeLogo))
            $model->initSoftAttribute('activeLogo');
        
        
       
        $biobankIdentifier = new BiobankIdentifierForm();
       
        
        $this->render('upload', array(
//          'logo' => $fichier,
            'model' => $model,
            'listLogos' => $listFile,
            'biobankIdentifier' =>$biobankIdentifier,
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