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
                'actions' => array('admin', 'constructAttachment', 'viewReport'),
                'expression' => '$user->isBiobankAdmin()||$user->isAdmin()',
            ),
//            array('allow', // allow authenticated user to perform 'search' actions
//                'users' => array('*'),
//                'actions' => array('')
//            ),
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
        if (isset($_FILES['uploadFileField']) && $_FILES['uploadFileField']['error'] == 0) {
            $add = false;
            if (isset($_POST['UploadedFile']['addOrReplace']) && $_POST['UploadedFile']['addOrReplace'] == 'add') {
                $add = true;
            }
            $fileId = $this->uploadEchFile($_FILES['uploadFileField']);

            if ($fileId != null) {
                $file = CommonTools::importFile($this->loadModel($fileId), $add);
                $this->sendReportMail($file);
            }
        }

        $datas = $this->getDataForFileConstruct();


        $dataProviderProperties = new CArrayDataProvider($datas, array('keyField' => false, 'pagination' => false,));


        $model->addOrReplace = 'add';
        $this->render('admin', array('model' => $model, 'dataProviderProperties' => $dataProviderProperties));
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
            $tempFilename = $file["tmp_name"];
            $filename = $file["name"];
            if ($file['size'] < 15000000) {

                $splitted = explode(".", $filename);
                $extension = end($splitted);
                if (in_array($extension, array('xls', 'xlsx'))) {
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

    private function getDataForFileConstruct() {
        $datas = array();
        $datas[] = new SampleProperty("id_sample", "Identification number of the biological material", "Text"
        );
        $datas[] = new SampleProperty("id_depositor", "Identification of depositor", "Text"
        );
        $datas[] = new SampleProperty("id_family", "Identification number of the family", "Text"
        );
        $datas[] = new SampleProperty("id_donor", "Identification number of the donor", "Text"
        );

        $datas[] = new SampleProperty("consent_ethical", "Consent/Approval by ethical commitee", "Fixed values(Yes, No, Unknown) : Y,N,U"
        );
        $datas[] = new SampleProperty("gender", "Gender of donor", "Fixed values(Male, Female, Hermaphrodite, Unknown) : M, F, H, U "
        );
        $datas[] = new SampleProperty("age", "Age of donor", "Integer"
        );
        $datas[] = new SampleProperty("pathology", "Pathology of family with OMIM number", "Integer (unique six-digit number)"
        );
        $datas[] = new SampleProperty("status_sample", "Status of the biological materiel", "Fixed Values( A=Affected, NA= Non-affected, IS=indication of suspected diagnosis, IT=indication of grade of tumor+value) : "
        );
        $datas[] = new SampleProperty("collect_date", "date of collect of the material", "ISO-standard (8601) time format : 2014-04-18"
        );
        $datas[] = new SampleProperty("nature_sample_dna", "nature of the human biological material where dna was extracted from", "fixed values ( affected, non affected)"
        );
        $datas[] = new SampleProperty("storage_conditions", "preservation or storage conditions", "fixed values (LN=liquid nitrogen, 80=-80C, RT=room temperature, 4=4°C, 20=-20°C)"
        );
        $datas[] = new SampleProperty("quantity", "quantity of biological material", "for dna concentration µg/µl and number of µl"
        );
        $datas[] = new SampleProperty("disease_diagnosis", "Disease diagnosis", "Text"
        );
        $datas[] = new SampleProperty("origin", "Origin of the biological material", "Organ and tissue"
        );
        $datas[] = new SampleProperty("hazard_status", "hazard status", "Text"
        );
        $datas[] = new SampleProperty("nature_sample_tissue", "nature of the human biological material", "fixed values ( T=tissue, S=slide,C=cells, P=pellet)"
        );
        $datas[] = new SampleProperty("processing_method", "documentation on processing method", "Text"
        );
        $datas[] = new SampleProperty("nature_sample_cells", "nature of the cells", "fixed values(epithelia, fibroblast,myphocyt)"
        );
        $datas[] = new SampleProperty("culture_condition", "culture condition", "medium and subculture routine"
        );
        $datas[] = new SampleProperty("consent", "consent", "Fixed values(Yes, No, Unknown) : Y,N,U"
        );
        $datas[] = new SampleProperty("family_tree", "family tree", "Fixed values(Yes, No, Unknown) : Y,N,U"
        );
        $datas[] = new SampleProperty("available_relatives_samples", "samples from relatives available", "Fixed values(Yes, No, Unknown) : Y,N,U"
        );
        $datas[] = new SampleProperty("supply", "form of supply", "Text"
        );

        $datas[] = new SampleProperty("max_delay_delivery", "maximum delay for delivery", "Integer ( hours)"
        );
        $datas[] = new SampleProperty("karyotype", "karyotype", "Text"
        );
        $datas[] = new SampleProperty("quantity_families", "quantity of families and subjects available for the specific disease", "Integer"
        );
        $datas[] = new SampleProperty("detail_treatment", "detail information of treatment/medications", "Text"
        );
        $datas[] = new SampleProperty("disease_outcome", "information on disease outcome", "Text"
        );
        $datas[] = new SampleProperty("associated_clinical_data", "associated clinical data", "Fixed values(Yes, No, Unknown) : Y,N,U"
        );
        $datas[] = new SampleProperty("associated_molecular_data", "associated molecular data ( ref associated clinical data OCDE)", "Fixed values(Yes, No, Unknown) : Y,N,U"
        );
        $datas[] = new SampleProperty("associated_imagin_data", "associated imagin data ( ref associated clinical data OCDE)", "Fixed values(Yes, No, Unknown) : Y,N,U"
        );
        $datas[] = new SampleProperty("life_style", "information on life style", "Text"
        );
        $datas[] = new SampleProperty("family_history", "information on family history", "Text"
        );
        $datas[] = new SampleProperty("authentication_method", "dna fingerprinting or another method of authentication", "Text"
        );
        $datas[] = new SampleProperty("hazard_status", "hazard status", "Text"
        );
        $datas[] = new SampleProperty("details_diagnosis", "details of diagnosis", "Text"
        );
        $datas[] = new SampleProperty("related_biological_material", "related biological material", "Fixed Values : DNA Biopsy, tissue,serum, dna"
        );
        $datas[] = new SampleProperty("quantity_available", "Quantiy available", "Text"
        );
        $datas[] = new SampleProperty("concentration_available", "Concentration available", "Text"
        );
        $datas[] = new SampleProperty("samples_characteristics", "characteristics of the sample", "Text (sample composition, content tumour cells)"
        );
        $datas[] = new SampleProperty("delay_freezing", "delay of freezing", "Integer(minutes)"
        );
        $datas[] = new SampleProperty("cells_characterization", "characterization of cells", "Text (doubling time, tumorigenicity, karyotype etc)"
        );
        $datas[] = new SampleProperty("number_of_passage", "number of passage", "Text"
        );
        $datas[] = new SampleProperty("morphology_and_growth_characteristics", "morphology and growth characteristics", "Text"
        );
        $datas[] = new SampleProperty("reference_paper", "reference paper", "Text"
        );
        $datas[] = new SampleProperty("biobank_id", "biobank id", "Text : Use BRIF Code to store this variable"
        );
        $datas[] = new SampleProperty("biobank_name", "biobank name", "Text"
        );
        $datas[] = new SampleProperty("biobank_date_entry", "Date of Entry", " ISO-standard (8601) time format when data about the biobank was reported into a database. : 2014-04-18T06:28:42Z"
        );
        $datas[] = new SampleProperty("biobank_collection_id", "Sample Collection/Study ID*", "Text :   Textual string depicting the unique ID or acronym for the sample collection or study"
        );
        $datas[] = new SampleProperty("biobank_collection_name", "Collection/Study name*", "Text : Textual string of letters denoting the name of the study in English");
        $datas[] = new SampleProperty("patient_birth_date", "birth date patient", "Date format ISO 8601 : YYYY-MM-DD exemple 2014-04-18"
        );
        $datas[] = new SampleProperty("tumor_diagnosis", "tumor_diagnosis", "Text : CIM 10 format");

        return $datas;
    }

    protected function sendReportMail($file) {
        $subject = 'Import samples file report';
        $this->layout = '//layouts/withoutMenu';
        $flashMessages = Yii::app()->user->getFlashes();

        $body = $this->render('reportMail', array('model' => $file, 'forMail' => true), true);
        foreach ($flashMessages as $messageKey => $messageValue)
            Yii::app()->user->setFlash($messageKey, $messageValue);
        $this->layout = '/layouts/menu_mybiobank';
        $emailTo = Yii::app()->user->email;

        $attachment = $this->constructAttachmentForMail($file);
        CommonMailer::directSend($subject, $body, $emailTo, null, $attachment);
    }

    public function actionViewReport($id) {

        //   CommonMailer::directSend('testSJ', 'testBody', 'matthieu.penicaud@gmail.com', null, null);
        // $this->layout = '//layouts/withoutMenu';
        $file = $this->loadModel(new MongoId($id));
        //  $attachment = $this->constructAttachmentForMail($file);
        $this->render('reportMail', array('model' => $file, 'forMail' => false), false);
    }

    public function actionConstructAttachment($id) {
        $file = $this->loadModel(new MongoId($id));
        $excelFile = $this->constructFileForDownload($file);

        $writer = PHPExcel_IOFactory::createWriter($excelFile, 'Excel5');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment;filename="nomfichier.xls"');

        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function constructAttachmentForMail($file) {
        $attachment = null;
        if (isset($file->metadata['errors']) && count($file->metadata['errors'])) {
            $arrayErrors = $file->getCollection()->aggregate(array(
                array('$match' => array('_id' => $file->_id)),
                array('$unwind' => '$metadata.errors'),
                array('$unwind' => '$metadata.errors.attributes'),
                array('$unwind' => '$metadata.errors.attributes.errorValue'),
                array('$project' => array('metadata.errors' => 1))));
            $attachment = array();
            //   MongoDate::toDateTime();

            $attachment['name'] = 'sample_import_report_' . $file->uploadDate->toDateTime()->format('Y-m-d') . '.xls';
            $excelFile = $this->constructExcelFile($arrayErrors);

            $writer = PHPExcel_IOFactory::createWriter($excelFile, 'Excel5');

            ob_start();

            $writer->save('php://output');
            $attachment['data'] = ob_get_contents();
        }
        return $attachment;
    }

    public function constructFileForDownload($file) {

        if (isset($file->metadata['errors']) && count($file->metadata['errors'])) {
            $arrayErrors = $file->getCollection()->aggregate(array(
                array('$match' => array('_id' => $file->_id)),
                array('$unwind' => '$metadata.errors'),
                array('$unwind' => '$metadata.errors.attributes'),
                array('$unwind' => '$metadata.errors.attributes.errorValue'),
                array('$project' => array('metadata.errors' => 1))));
//            $attachment = array();
//            //   MongoDate::toDateTime();
//
//            $attachment['name'] = 'sample_import_report_' . $file->uploadDate->toDateTime()->format('Y-m-d') . '.xls';
            return $excelFile = $this->constructExcelFile($arrayErrors);
        }
        return null;
    }

    public function constructExcelFile($arrayErrors) {
        include_once(Yii::app()->basePath . '/extensions/ExcelExt/PHPExcel.php');

        $excelFile = new PhpExcel();
        $excelFile->getProperties()->setCreator('ebiobanques.fr');
        $excelFile->getProperties()->setTitle('Samples import report');
        $excelSheet = $excelFile->setActiveSheetIndex(0);

        $excelSheet->setCellValueByColumnAndRow(0, 1, 'Error on line');
        $excelSheet->setCellValueByColumnAndRow(1, 1, 'Attribute name');
        $excelSheet->setCellValueByColumnAndRow(2, 1, 'Error message');
        $row = 2;
        $col = 0;

        foreach ($arrayErrors['result'] as $error) {
            $rowError = $error['metadata']['errors']['row'];
            $excelSheet->setCellValueByColumnAndRow($col, $row, $rowError);
            $attributeName = $error['metadata']['errors']['attributes']['attributeName'];
            $excelSheet->setCellValueByColumnAndRow($col + 1, $row, $attributeName);
            $errorValue = $error['metadata']['errors']['attributes']['errorValue'];
            $excelSheet->setCellValueByColumnAndRow($col + 2, $row, $errorValue);

            $row++;
        }
        return $excelFile;
    }

}