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
class CatalogController extends Controller
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
                'allow', // allow authenticated user to perform 'search' actions
                'actions' => array(
                    'search',
                    'view',
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
     * display catalog of biobanks with contacts and agregated infos
     */
    public function actionSearch() {
         Yii::log('controller catalog search- ',Clogger::LEVEL_INFO);
        $model = new Biobank('search');
        $form = new CatalogForm ();
        if (isset($_GET ['CatalogForm'])) {
            $model->unsetAttributes();
            $form->attributes = $_GET ['CatalogForm'];
            Yii::log('form attributes setted ',Clogger::LEVEL_INFO);
           /* if (Yii::app()->session ['keywords'] != $catalogForm->keywords) {
                $this->logSmartSearch($smartForm->keywords);
            }*/
            //Yii::app()->session ['keywords'] = $smartForm->keywords;
        }
        $this->render('catalog', array(
            'model' => $model,
            'smartForm' => $form
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->layout = '//layouts/detailview';
        Yii::log('valeur de lid : '.$id,Clogger::LEVEL_ERROR);
        $criteria = new EMongoCriteria;
        $criteria->_id = $id;
        $aggsamples = Biobanksamples::model()->find($criteria);

        // biobanque avec base aggregée 552fe5ef0175447b308b4642
        //Yii::log('valeur de laggsamples : '.$aggsamples->_id,Clogger::LEVEL_ERROR);
        //echo "<h1>" . $aggsamples->count . "</h1>";
        $this->render('view', array(
            'model' => $this->loadModel($id), 'aggsamples' => $aggsamples
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

}