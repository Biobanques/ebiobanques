<?php

class BiobankController extends Controller {

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
        return array(array('allow',
                'actions' => array('map'), // deny all users
                'users' => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'create', 'admin', 'view', 'update', 'oldUpdate', 'delete', 'deleteFlashMsg', 'print', 'exportXls', 'exportSelectedXls', 'exportCsv', 'exportPdf', 'globalStats', 'detailledStats', 'removeCim', 'addCim'),
                'expression' => '$user->isAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

//
//    public function actionMap() {
//        $this->layout = '//layouts/main';
//        $this->render('map');
//    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->render('view', array(
            'model' => $model,
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

    public function actionRemoveCim($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['idCim']) && $_POST['idCim'] != null)
            $model->removeCimCode($_POST['idCim']);
        $this->redirect(array('biobank/update', 'id' => $id));
    }

    public function actionAddCim($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['Biobank']['cims']['new']) && $_POST['Biobank']['cims']['new'] != null && $_POST['Biobank']['cims']['new'] != '') {

            $result = $model->addCimCode($_POST['Biobank']['cims']['new']);
        }
        if ($result)
            $this->redirect(array('biobank/update', 'id' => $id));
        else
            echo "Error";
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
            if (isset($_POST['Contact_resp']) && $_POST['Contact_resp']['lastName'] != null && $_POST['Contact_resp']['lastName'] != "") {
                $model->contact_resp = new Op_resp('insert');
                $model->contact_resp = $_POST['Contact_resp'];
            }
            if (isset($_POST['Op_resp']) && $_POST['Op_resp']['lastName'] != null && $_POST['Op_resp']['lastName'] != "") {
                $model->responsable_op = new Op_resp('insert');
                $model->responsable_op = $_POST['Op_resp'];
            }
            if (isset($_POST['Adj_resp']) && $_POST['Adj_resp']['lastName'] != null && $_POST['Adj_resp']['lastName'] != "") {
                $model->responsable_adj = new Adj_resp('insert');
                $model->responsable_adj = $_POST['Adj_resp'];
            }
            if (isset($_POST['Qual_resp']) && $_POST['Qual_resp']['lastName'] != null && $_POST['Qual_resp']['lastName'] != "") {
                $model->responsable_qual = new Qual_resp('insert');
                $model->responsable_qual = $_POST['Qual_resp'];
            }
            if ($model->save()) {
                $flashMsg = 'La biobanque a bien été créée.';
                if (!isset($model->contact_id) || $model->contact_id == "")
                    $flashMsg.='<br>Le contact n\'a pas été renseigné, n\'oubliez pas de le faire après sa création';
                Yii::app()->user->setFlash('success', $flashMsg);

                $this->redirect(array('view', 'id' => $model->_id));
            } else
                Yii::app()->user->setFlash('error', Yii::t('common','error_create_biobank'));
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
            if (isset($_POST['Contact_resp']) ) {
                $model->contact_resp = $_POST['Contact_resp'];
            }
            if (isset($_POST['Op_resp']) ) {
                $model->responsable_op = $_POST['Op_resp'];
            }
            if (isset($_POST['Qual_resp']) ) {
                // if (isset($_POST['Qual_resp'])) {
                $model->responsable_qual = $_POST['Qual_resp'];
            }
            if (isset($_POST['Adj_resp']) ) {
                //if (isset($_POST['Adj_resp'])) {
                $model->responsable_adj = $_POST['Adj_resp'];
            }
           // $contact = $model->contact;
            /*if (isset($_POST['Contact'])) {

                foreach ($_POST['Contact'] as $contactAttrName => $contactAttrValue) {
                    $contact->$contactAttrName = $contactAttrValue;
                }
            }*/
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

    public function actionOldUpdate($id) {

        /* @var $model Biobank */
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
            //Yii::log('saving biobank', CLogger::LEVEL_WARNING);
            //Save is isabled to prevent problems with this old update
            /*   if ($model->save()) {

              Yii::app()->user->setFlash('success', 'La biobanque a bien été mise à jour.');


              // $this->redirect(array('view', 'id' => $model->_id));
              } else
              Yii::app()->user->setFlash('error', 'La biobanque n\'a pas pu être mise à jour'); */
        }

//        $this->render('update', array(
//            'model' => $model,
//        ));
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
//        if (!isset($model->textSearchValue))
//            $model->initSoftAttribute('textSearchValue');
//        if (!isset($model->textSearchField))
//            $model->initSoftAttribute('textSearchField');
        if (!isset($model->presentation))
            $model->initSoftAttribute('presentation');
        if (!isset($model->projetRecherche))
            $model->initSoftAttribute('projetRecherche');
        if (!isset($model->reseaux))
            $model->initSoftAttribute('reseaux');
        if (!isset($model->thematiques))
            $model->initSoftAttribute('thematiques');
        if (!isset($model->publications))
            $model->initSoftAttribute('publications');
        if (!isset($model->cert_ISO9001))
            $model->initSoftAttribute('cert_ISO9001');
        if (!isset($model->cert_NFS96900))
            $model->initSoftAttribute('cert_NFS96900');




        if (isset($_GET['Biobank']))
            $model->attributes = $_GET['Biobank'];
        if (isset($_GET['Address']))
            $model->address->attributes = $_GET['Address'];
        foreach (array('Op_resp' => 'responsable_op', 'Adj_resp' => 'responsable_adj', 'Qual_resp' => 'responsable_qual')as $obj => $prop) {
            if (isset($_GET[$obj]['FullNameForDDList']) && $_GET[$obj]['FullNameForDDList'] != null) {

                list($model->$prop->lastName, $model->$prop->firstName) = explode('_', $_GET[$obj]['FullNameForDDList']);
            }
        }



        $this->render('admin', array(
            'model' => $model
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

    public function actionExportCsv() {
        $model = new Biobank();
        $model->unsetAttributes();
        if (isset($_GET['Biobank']))
            $model->attributes = $_GET['Biobank'];

        if (isset($_SESSION['criteria']) && $_SESSION['criteria'] != null && $_SESSION['criteria'] instanceof EMongoCriteria) {
            $criteria = $_SESSION['criteria'];
        } else {
            $criteria = new EMongoCriteria;
        }
        $models = Biobank::model()->findAll($criteria);
        $dataProvider = array();
        $listAttributes = array();
        foreach ($models as $model) {
//récuperation de la liste totale des attributs
            foreach ($model->attributes as $attributeName => $attributeValue) {
                $listAttributes[$attributeName] = $attributeName;
            }
        }

        foreach ($models as $model) {
            $datas = array();
            foreach ($listAttributes as $attribute) {
                if (isset($model->$attribute)) {
                    if (!is_object($model->$attribute)) {
                        $datas[$attribute] = $model->$attribute;
                    } else {
                        switch ($attribute) {
                            case "address":
                                $datas[$attribute] = $model->getAddress();
                                break;
                            case "responsable_op":
                                $datas[$attribute] = $model->getResponsableOp();
                                break;
                            case "responsable_qual":
                                $datas[$attribute] = $model->getResponsableQual();
                                break;
                            case "responsable_adj":
                                $datas[$attribute] = $model->getResponsableAdj();
                                break;
                           /* case "contact_resp":
                                $datas[$attribute] = $model->getContactResp();
                                break;*/
                        }
                    }
                } else {
                    $datas[$attribute] = "";
                }
            }
            $dataProvider[] = $datas;
        }
        $filename = 'biobanks_list.csv';
        $csv = new ECSVExport($dataProvider);
        $toExclude = array();
        $toExport = $model->attributeExportedLabels();
        foreach ($listAttributes as $attribute) {

            if (!isset($toExport[$attribute]))
                $toExclude[] = $attribute;
        }
        $csv->setExclude($toExclude);
        // $csv->exportCurrentPageOnly();
        Yii::app()->getRequest()->sendFile($filename, $csv->toCSV(), "text/csv", false);
    }

    /**
     * export pdf avec mpdf et liste  d'index : Technique HTML to PDF
     */
    public function actionExportPdf() {
        $mPDF1 = Yii::app()->ePdf->mpdf();
        if (isset($_SESSION['criteria']) && $_SESSION['criteria'] != null && $_SESSION['criteria'] instanceof EMongoCriteria) {
            $criteria = $_SESSION['criteria'];
        } else {
            $criteria = new EMongoCriteria;
        }

        $dataProvider = new EMongoDocumentDataProvider('Biobank', array('criteria' => $criteria, 'pagination' => false));
        $mPDF1->WriteHTML($this->renderPartial('printPdf', array('dataProvider' => $dataProvider), true));
        $mPDF1->Output('biobanks_list.pdf', 'I');
    }

    /**
     * export xls des biobanques
     */
    public function actionExportXls() {
        $model = new Biobank('search');
        $model->unsetAttributes();
        if (isset($_GET['Biobank']))
            $model->attributes = $_GET['Biobank'];
        if (isset($_SESSION['criteria']) && $_SESSION['criteria'] != null && $_SESSION['criteria'] instanceof EMongoCriteria) {
            $criteria = $_SESSION['criteria'];
        } else {
            $criteria = new EMongoCriteria;
        }

        $biobanks = Biobank::model()->findAll($criteria);
        $data = array(1 => array_keys(Biobank::model()->attributeExportedLabels()));
        setlocale(LC_ALL, 'fr_FR.UTF-8');
        foreach ($biobanks as $biobank) {
            $line = array();
            //echo "biobank:".$biobank->id;
            //Yii::log('Pb converting string: : ' . $biobank->id, CLogger::LEVEL_ERROR);
            foreach (array_keys($biobank->attributeExportedLabels()) as $attribute) {

                if (isset($biobank->$attribute) && $biobank->$attribute != null && !empty($biobank->$attribute)) {
                    if (is_string($biobank->$attribute))
                        $line[] = CommonTools::convertStringToAscii($biobank->$attribute); //solution la moins pire qui ne fait pas bugge les accents mais les convertit en caractere generique
                    else {
                        switch ($attribute) {
                            case "address":
                                $line[] = CommonTools::convertStringToAscii($biobank->getAddress());
                                break;
                            case "responsable_op":
                                $line[] = CommonTools::convertStringToAscii($biobank->getResponsableOp());
                                break;
                            case "responsable_qual":
                                $line[] = CommonTools::convertStringToAscii($biobank->getResponsableQual());
                                break;
                            case "responsable_adj":
                                $line[] = CommonTools::convertStringToAscii($biobank->getResponsableAdj());
                                break;
                        }
                    }
                } else {
                    $line[] = "-";
                }
            }
            $data[] = $line;
        }
        Yii::import('application.extensions.phpexcel.JPhpExcel');
        $xls = new JPhpExcel('UTF-8', true, 'Biobank list');
        $xls->addArray($data);
        $xls->generateXML('Biobank list');
    }

    public function actionExportSelectedXls() {
        $model = new Biobank('search');
        $model->unsetAttributes();
        if (isset($_GET['Biobank']))
            $model->attributes = $_GET['Biobank'];
        if (isset($_SESSION['criteria']) && $_SESSION['criteria'] != null && $_SESSION['criteria'] instanceof EMongoCriteria) {
            $criteria = $_SESSION['criteria'];
        } else {
            $criteria = new EMongoCriteria;
        }
        if (isset($_POST['fields']))
            $fields = $_POST['fields'];
        else
            $fields = array_keys(Biobank::model()->attributeExportedLabels());

        $biobanks = Biobank::model()->findAll($criteria);
        $fieldsLabels = [];
        foreach ($fields as $key => $value) {
            $fieldsLabels[$key] = $value;
        }
        $data = array(1 => $fieldsLabels);
        setlocale(LC_ALL, 'fr_FR.UTF-8');
        foreach ($biobanks as $biobank) {
            $line = array();
            //echo "biobank:".$biobank->id;
            //Yii::log('Pb converting string: : ' . $biobank->id, CLogger::LEVEL_ERROR);
            foreach ($fields as $attribute) {

                if (isset($biobank->$attribute) && $biobank->$attribute != null && !empty($biobank->$attribute)) {
                    if (is_string($biobank->$attribute))
                        switch ($attribute) {
                            case'contact_id':
                                $line[] = CommonTools::convertStringToAscii("$biobank->shortContactInv - $biobank->emailContact - $biobank->phoneContact");
                                break;
                            default:
                                $line[] = CommonTools::convertStringToAscii($biobank->$attribute); //solution la moins pire qui ne fait pas bugge les accents mais les convertit en caractere generique
                                break;
                        } else {
                        switch ($attribute) {
                            case "address":
                                $line[] = CommonTools::convertStringToAscii($biobank->getAddress());
                                break;
                            case "responsable_op":
                                $line[] = CommonTools::convertStringToAscii($biobank->getResponsableOp());
                                break;
                            case "responsable_qual":
                                $line[] = CommonTools::convertStringToAscii($biobank->getResponsableQual());
                                break;
                            case "responsable_adj":
                                $line[] = CommonTools::convertStringToAscii($biobank->getResponsableAdj());
                                break;
                        }
                    }
                } else {
                    $line[] = "-";
                }
            }
            $data[] = $line;
        }
        Yii::import('application.extensions.phpexcel.JPhpExcel');
        $xls = new JPhpExcel('UTF-8', true, 'Biobank list');
        $xls->addArray($data);
        $xls->generateXML('Biobank list');
    }

    /**
     * print de la liste des biobanques
     */
    public function actionPrint() {
        if (isset($_SESSION['criteria']) && $_SESSION['criteria'] != null && $_SESSION['criteria'] instanceof EMongoCriteria) {
            $criteria = $_SESSION['criteria'];
        } else {
            $criteria = new EMongoCriteria;
        }
        $dataProvider = new EMongoDocumentDataProvider('Biobank', array('criteria' => $criteria, 'pagination' => false));

        $this->render('print', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionGlobalStats() {
        $datas = array();
        $datas['categories'] = array();
        $datas['missingFields'] = array();
        $datas['presentFields'] = array();

        $stats = BiobankCompletionTools::getBiobankAttributesGlobalCompletudeRate();
        $index = 0;
        foreach ($stats as $keyStats => $valueStats) {
            if (is_array($valueStats)) {
                $datas['categories'][$index] = $keyStats;
                $datas['missingFields'][$index] = ((1 - $valueStats['GCR']) * 100);
                $datas['presentFields'][$index] = $valueStats['GCR'] * 100;
                $index++;
            }
        }

        $counts = array('nbBiobanks' => $stats['nbBiobanks'], 'nbFields' => $stats['nbFields'], 'avgGCR' => $stats['avgGCR']);

//        foreach ($stats as $key => $value) {
//            if (isset($value['GCR'])) {
//                $datas[$key] = array();
//                $datas[$key]['GCR'] = $value['GCR'];
//                $datas[$key]['nbIds'] = $value['nbIds'];
//            }
//        }

        $this->render('globalStats', array(
            'counts' => (object) $counts,
            'datas' => $datas
                //  'dataProvider' => $datas,
                //  'statsGlobales' => $stats
        ));
    }

    public function actionDetailledStats() {



        if (isset($_GET['id'])) {
            $biobank_id = new MongoId($_GET['id']);
        }
        $model = $this->loadModel($biobank_id);
        $stats = $model->getDetailledStats();
        $statsGlobales = BiobankCompletionTools::getBiobankAttributesGlobalCompletudeRate();
        $this->render('detailledStats', array(
            'model' => $model,
            'stats' => $stats,
            'statsGlobales' => $statsGlobales,
        ));
    }

}
