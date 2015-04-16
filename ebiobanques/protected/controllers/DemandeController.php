<?php

class DemandeController extends Controller
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
                'allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(
                    'index',
                    'view'
                ),
                'users' => array(
                    '*'
                )
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'update',
                    'chose',
                    'SetActiveDemand',
                    'UpdateAndSend',
                    'valider',
                    'createNewDemand',
                    'delete',
                    'envoyer'
                ),
                'users' => array(
                    '@'
                )
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(
                    'admin'),
                'expression' => '$user->isAdmin()'
            ),
            array(
                'deny', // deny all users
                'users' => array(
                    '*'
                )
            )
                )
        ;
    }

    /**
     * Displays a particular model.
     *
     * @param integer $id
     *        	the ID of the model to be displayed
     */
    public function actionView($id, $layout = null) {
        if ($layout != null)
            $this->layout = $layout;
        $this->render('view', array_merge(array(
            'model' => $this->loadModel($id)), isset($_GET['layout']) || $layout != null ? array('layout' => $_GET['layout']) : array()
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *        	the ID of the model to be updated
     */
    public function actionUpdateAndSend($id) {
//        if (isset($_GET['layout']))
        $model = $this->loadModel($id);
        if (isset($_POST ['Demande'])) {
            $model->attributes = $_POST ['Demande'];
            if ($model->saveWithCurrentDate())
                $this->redirect(array_merge(array(
                    'view',
                    'id' => $model->_id), isset($_GET['layout']) ? array('layout' => $_GET['layout']) : array()
                ));
        }
        $this->render('update', array_merge(array(
            'model' => $model, isset($_GET['layout']) || (isset($layout) && $layout != null) ? array('layout' => $_GET['layout']) : array()
        )));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *        	the ID of the model to be updated
     */
    public function actionUpdate($id, $layout = null) {
        $model = $this->loadModel($id);
        if (isset($_POST ['Demande'])) {
            $model->attributes = $_POST ['Demande'];
            $model->saveWithCurrentDate();
        }
        $this->render('update', array_merge(array(
            'model' => $model), isset($_GET['layout']) || $layout != null ? array('layout' => $_GET['layout']) : array()
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     *
     * @param integer $id
     *        	the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        if (!isset($_GET ['ajax']))
            $this->redirect(isset($_POST ['returnUrl']) ? $_POST ['returnUrl'] : array(
                        'admin'
                    ) );
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Demande');
        $this->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Demande('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET ['Demande']))
            $model->attributes = $_GET ['Demande'];

        $this->render('admin', array(
            'model' => $model
        ));
    }

    public function actionChose() {
        $model = new Demande("search");
        $model->unsetAttributes(); // clear any default values
// 		if (isset ( $_GET ['Demande'] ))
// 			$model->attributes = $_GET ['Demande'];

        $this->render('chose', array(
            'model' => $model
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param integer $id
     *        	the ID of the model to be loaded
     * @return Demande the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        try {
            $model = Demande::model()->findByPk(new MongoID($id));
        } catch (Exception $e) {
            $model = Demande::model()->findByPk($id);
        }

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     *
     * @param Demande $model
     *        	the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST ['ajax']) && $_POST ['ajax'] === 'demande-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Défini la demande active
     */
    public function actionSetActiveDemand() {
        if (isset($_POST ['id'])) {
            $id = $this->loadModel($_POST['id']);
            Yii::app()->session ['activeDemand'] = array(
                $id,
                false
            );
            //print Yii::t ( 'common', 'activeDemandMsg' ) . $id->_id;
            return;
        }
    }

    /**
     * Crée une nouvelle demande
     */
    public function actionCreateNewDemand() {
        $demande = new Demande ();
        $demande->id_user = Yii::app()->user->id;
        $demande->date_demande = date("Y-m-d H:i:s");
        $demande->save();

        $newDemand = true;
        Yii::app()->session ['activeDemand'] = array(
            $demande,
            $newDemand
        );

//        print Yii::t('common', 'activeDemandMsg') . $demande->_id;
        return;
    }

    /**
     * Envoie une demande aux contacts des biobanques concernées par une demande
     */
    public function actionEnvoyer() {
        if (isset($_GET ['demande_id'])) {
            $demande = $this->loadModel($_GET ['demande_id']);
            if (!empty($demande->titre) && !empty($demande->detail) && !empty($demande->sampleList)) {
                $samples = $demande->getArraySamples();
                $biobankIdList = $demande->getBiobanksFromSamples($samples);
                $demandeSent = false;
                foreach ($biobankIdList as $biobankId) {

                    $biobank = Biobank::model()->findByAttributes(array('id' => $biobankId));
                    if ($biobank->contact_id != null) {

                        $contact = Contact::model()->findByAttributes(array('id' => $biobank->contact_id));
                        $concernSamplesList = array();
                        foreach ($samples as $sample) {
                            if ($sample->biobank_id == $biobankId)
                                $concernSamplesList [] = $sample;
                        }

                        // PB si pas envoyer a une biuobank alors pas sauvegarder
                        if (CommonMailer::sendDemande($contact, $demande->titre . ' : ' . $biobank->identifier, $demande->detail, $concernSamplesList) == 1)
                            $demandeSent = true;
                    }else {

                    }
                }
                if ($demandeSent) {
                    $demande->envoi = 1;
                    $demande->save();

                    $this->actionCreateNewDemand();
                    Yii::app()->user->setFlash('success', 'Votre demande a bien été envoyée aux différents sites');
                    $this->render('view', array_merge(array(
                        'model' => $this->loadModel($demande->_id), isset($_GET['layout']) || (isset($layout) && $layout != null) ? array('layout' => $_GET['layout']) : array()
                    )));
                } else {
                    Yii::app()->user->setFlash('error', 'Un problème est apparu, les demandes n\'ont pas été transmises');
                    $this->redirect(array_merge(array(
                        'updateAndSend',
                        'id' => Yii::app()->session ['activeDemand'][0]->_id), isset($_GET['layout']) ? array('layout' => $_GET['layout']) : array()
                    ));
//
                }
            } else {
                Yii::app()->user->setFlash('notice', 'Merci de completer votre demande avant de l\'envoyer');
                $this->redirect(array_merge(array(
                    'updateAndSend',
                    'id' => $demande->_id), isset($_GET['layout']) ? array('layout' => $_GET['layout']) : array()
                ));
//
            }
        }
    }

}