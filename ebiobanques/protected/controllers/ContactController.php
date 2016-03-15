<?php

class ContactController extends Controller
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
                'actions' => array('index', 'create', 'admin', 'exportContact', 'view', 'update', 'delete', 'exportXLS'),
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Contact;
        if (isset($_POST['Contact'])) {
            $model->attributes = $_POST['Contact'];
            //last name to upper case automatically /prevent pb to sort and display
            $model->last_name = strtoupper($model->last_name);
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->_id));
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
        if (isset($_POST['Contact'])) {
            $model->attributes = $_POST['Contact'];
            //last name to upper case automatically /prevent pb to sort and display
            $model->last_name = strtoupper($model->last_name);
            if ($model->update())
                $this->redirect(array('view', 'id' => $id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new EMongoDocumentDataProvider('Contact');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Contact('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Contact']))
            $model->attributes = $_GET['Contact'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionExportContact() {
        $form = new GlobalContactForm();
        $model = new Contact();
        $model->unsetAttributes();  // clear any default values
        $form->profils = array(0);  // clear any default values
        $dataContact = array();
        $dataBiobank = array();
        $resp_types = array('responsable_adj', 'responsable_qual', 'responsable_op');
        $contactCriteria = new EMongoCriteria;
        $biobankIdCriteria = null;
        $nameCriteria = null;
        $cityCriteria = null;
        $countryCriteria = null;
        if (isset($_POST['GlobalContactForm'])) {
            $resp_types = array();
            if (isset($_POST['GlobalContactForm']['profils']) && is_array($_POST['GlobalContactForm']['profils'])) {

                if (in_array('resp_adj', $_POST['GlobalContactForm']['profils']))
                    $resp_types[] = 'responsable_adj';
                if (in_array('resp_qual', $_POST['GlobalContactForm']['profils']))
                    $resp_types[] = 'responsable_qual';
                if (in_array('resp_op', $_POST['GlobalContactForm']['profils']))
                    $resp_types[] = 'responsable_op';
                if (in_array('resp', $_POST['GlobalContactForm']['profils']) || in_array('nonAssigned', $_POST['GlobalContactForm']['profils'])) {
                    $contactCriteria->createOrGroup('profil');

                    if (in_array('resp', $_POST['GlobalContactForm']['profils']))
                        $contactCriteria->addCondToOrGroup('profil', array('biobank_id' => array('$ne' => null)));
                    if (in_array('nonAssigned', $_POST['GlobalContactForm']['profils']))
                        $contactCriteria->addCondToOrGroup('profil', array('biobank_id' => array('$eq' => null)));
                    $contactCriteria->addOrGroup('profil');
                }
            }
            if (isset($_POST['GlobalContactForm']['biobank_id']) && !empty($_POST['GlobalContactForm']['biobank_id']) && $_POST['GlobalContactForm']['biobank_id'] != null) {
                $biobankIdCriteria = $_POST['GlobalContactForm']['biobank_id'];
                $contactCriteria->addCond('biobank_id', '==', $_POST['GlobalContactForm']['biobank_id']);
            }
            if (isset($_POST['GlobalContactForm']['last_name']) && !empty($_POST['GlobalContactForm']['last_name']) && $_POST['GlobalContactForm']['last_name'] != null) {
                $nameCriteria = $_POST['GlobalContactForm']['last_name'];
                $contactCriteria->addCond('last_name', '==', new MongoRegex('/' . $_POST['GlobalContactForm']['last_name'] . '/i'));
            }
            if (isset($_POST['GlobalContactForm']['ville']) && !empty($_POST['GlobalContactForm']['ville']) && $_POST['GlobalContactForm']['ville'] != null) {
                $cityCriteria = $_POST['GlobalContactForm']['ville'];
                $contactCriteria->addCond('ville', '==', new MongoRegex('/' . $_POST['GlobalContactForm']['ville'] . '/i'));
            }
            if ((isset($_POST['GlobalContactForm']['pays']) && !empty($_POST['GlobalContactForm']['pays']) && $_POST['GlobalContactForm']['pays'] != null) || $_POST['GlobalContactForm']['pays'] == '0') {
                $countryCriteria = $_POST['GlobalContactForm']['pays'];
                $contactCriteria->addCond('pays', '==', new MongoRegex('/' . $_POST['GlobalContactForm']['pays'] . '/i'));
            }
            if (!empty($contactCriteria->getConditions()) && isset($contactCriteria->getConditions()['$and']))
                $dataContact = Contact::model()->findAll($contactCriteria);
        }else {
            $dataContact = Contact::model()->findAll($contactCriteria);
        }

        if (!empty($resp_types))
            $dataBiobank = Biobank::model()->getContactsFormatted($resp_types, $biobankIdCriteria, $nameCriteria, $cityCriteria, $countryCriteria);
        $data = array_merge($dataContact, $dataBiobank);
        Yii::app()->user->setState('xlsExportData', $data);
        $dataProvider = new CArrayDataProvider($data, array('pagination' => array('pageSize' => 10), 'keyField' => '_id'));
        $biobankList = Biobank::getArrayBiobanks();
        $citiesList = $this->getCombinedCitiesList();
        $countriesList = $this->getCombinedcountriesList();
        $this->render('exportContact', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'form' => $form,
            'biobanks' => $biobankList,
            'cities' => $citiesList,
            'countries' => $countriesList
        ));
    }

    public function actionExportXLS() {
        $contacts = Yii::app()->user->getState('xlsExportData');
        $data = array(1 => array_keys(Contact::model()->attributeExportedLabels()));
        setlocale(LC_ALL, 'fr_FR.UTF-8');
        foreach ($contacts as $contact) {
            $line = array();
            foreach (array_keys(Contact::model()->attributeExportedLabels()) as $attribute) {
                if (is_array($contact)) {
                    $selectCriteria = new EMongoCriteria;
                    $selectCriteria->select(array('name'));
                    $contact['biobankName'] = Biobank::model()->findByPk(new MongoId($contact['biobank_id']), $selectCriteria)->name;
                }
                if (is_object($contact) && isset($contact->$attribute) && $contact->$attribute != null && !empty($contact->$attribute)) {
                    $line[] = iconv("UTF-8", "ASCII//TRANSLIT", $contact->$attribute); //solution la moins pire qui ne fait pas bugge les accents mais les convertit en caractere generique
                } elseif (is_array($contact) && isset($contact[$attribute]) && $contact[$attribute] != null && !empty($contact[$attribute])) {
                    $line[] = iconv("UTF-8", "ASCII//TRANSLIT", $contact[$attribute]); //solution la moins pire qui ne fait pas bugge les accents mais les convertit en caractere generique
                } else {
                    $line[] = "-";
                }
            }
            $data[] = $line;
        }
        Yii::import('application.extensions.phpexcel.JPhpExcel');
        $xls = new JPhpExcel('UTF-8', true, 'Contacts list');
        $xls->addArray($data);
        $xls->generateXML('Contacts list');
    }

    public function getCombinedCitiesList() {
        $results = array();
        $biobank = new Biobank();
        $contact = new Contact();

        $biobanksCities = $biobank->address->getActiveListOfCities();
        $ContactCities = $contact->getActiveListOfCities();
        $results = array_merge($biobanksCities, $ContactCities);
        if (isset($results['1']))
            unset($results['1']);
        natcasesort($results);
        return $results;
    }

    public function getCombinedCountriesList() {
        $results = array();
        $biobank = new Biobank();
        $contact = new Contact();

        $biobanksCountries = $biobank->address->getActiveListOfCountries();
        $ContactCountries = $contact->getActiveListOfCountries();
        $results = array_merge($biobanksCountries, $ContactCountries);
        if (isset($results['1']))
            unset($results['1']);
        natcasesort($results);
        return $results;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Contact the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Contact::model()->findByPk(new MongoID($id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Contact $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'contact-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}