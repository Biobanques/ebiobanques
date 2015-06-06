<?php

/**
 * lib d export csv
 */
Yii::import('ext.ECSVExport');

/**
 * controller de recherche de contacts
 * @author matthieu
 *
 */
class SearchContactController extends Controller
{

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
                'actions' => array('print', 'exportXls', 'exportCsv', 'exportPdf'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionExportCsv() {
        $model = new Contact('search');
        $model->unsetAttributes();
        if (isset($_GET['Contact']))
            $model->attributes = $_GET['Contact'];

        if (isset($_SESSION['criteria']) && $_SESSION['criteria'] != null && $_SESSION['criteria'] instanceof EMongoCriteria) {
            $criteria = $_SESSION['criteria'];
        } else {
            $criteria = new EMongoCriteria;
        }
        $models = Contact::model()->findAll($criteria);
        $listAttributes = array();
        foreach ($models as $model) {
//récuperation de la liste totale des attributs
            foreach ($model->attributes as $attributeName => $attributeValue) {
                $listAttributes[$attributeName] = $attributeName;
            }
        }
        $dataProvider = array();
        //creation du dataprovider
        foreach ($models as $model) {
            $datas = array();
            foreach ($listAttributes as $attribute) {
                if (isset($model->$attribute)) {
                    if (!is_object($model->$attribute)) {
                        $datas[$attribute] = $model->$attribute;
                    }
                } else {
                    $datas[$attribute] = "";
                }
            }
//create full adress
            $datas['fullAddress'] = $model->fullAddress;
            //create biobank
            $datas['fullAddress'] = $model->biobankName;
            $dataProvider[] = $datas;
        }
        $filename = 'biobanks_list.csv';
        $csv = new ECSVExport($dataProvider);
        $toExclude = array();
        $toExport = $model->attributeExportedLabels();
        foreach ($model->attributes as $attribute => $value) {

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
        } $dataProvider = new EMongoDocumentDataProvider('Contact', array('criteria' => $criteria, 'pagination' => false));
        $mPDF1->WriteHTML($this->renderPartial('print', array('dataProvider' => $dataProvider), true));
        $mPDF1->Output('contacts_list.pdf', 'I');
    }

    public function actionExportXls() {
        $model = new Contact('search');
        $model->unsetAttributes();
        if (isset($_GET['Contact']))
            $model->attributes = $_GET['Contact'];
        if (isset($_SESSION['criteria']) && $_SESSION['criteria'] != null && $_SESSION['criteria'] instanceof EMongoCriteria) {
            $criteria = $_SESSION['criteria'];
        } else {
            $criteria = new EMongoCriteria;
        } $dataProvider = new EMongoDocumentDataProvider('Contact', array('criteria' => $criteria, 'pagination' => false));

        $contacts = $dataProvider->data;
        $data = array(1 => array_keys($model->attributeExportedLabels()));
        setlocale(LC_ALL, 'fr_FR.UTF-8');
        foreach ($contacts as $contact) {
            $line = array();
            foreach (array_keys($model->attributeExportedLabels()) as $attribute) {
                if ($contact->$attribute != null && !empty($contact->$attribute)) {
                    $line[] = iconv("UTF-8", "ASCII//TRANSLIT", $contact->$attribute); //solution la moins pire qui ne fait pas bugge les accents mais les convertit en caractere generique
                } else {
                    $line[] = "-";
                }
            }
            $data[] = $line;
        }
        Yii::import('application.extensions.phpexcel.JPhpExcel');
        $xls = new JPhpExcel('UTF-8', true, 'Contact list');
        $xls->addArray($data);
        $xls->generateXML('Contact list');
    }

    /**
     * print de la liste des contacts
     */
    public function actionPrint() {
        if (isset($_SESSION['criteria']) && $_SESSION['criteria'] != null && $_SESSION['criteria'] instanceof EMongoCriteria) {
            $criteria = $_SESSION['criteria'];
        } else {
            $criteria = new EMongoCriteria;
        }
        $dataProvider = new EMongoDocumentDataProvider('Contact', array('criteria' => $criteria, 'pagination' => false));
        $this->render('print', array(
            'dataProvider' => $dataProvider,
        ));
    }

}
?>