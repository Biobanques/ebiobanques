<?php

/**
 * lib d export csv
 */
Yii::import('ext.ECSVExport');

/**
 * controller de recherche de biobanques
 * @author matthieu
 *
 */
class SearchCatalogController extends Controller
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
        $model = new Biobank('search');
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
          //  $line[]= iconv("UTF-8", "ASCII//TRANSLIT", $biobank->identifier);
            foreach (array_keys($biobank->attributeExportedLabels()) as $attribute) {

                if (isset($biobank->$attribute) && $biobank->$attribute != null && !empty($biobank->$attribute)) {
                    $line[] = iconv("UTF-8", "ASCII//TRANSLIT", $biobank->$attribute); 
                } else {
                    $line[] = "-";
                }
            }
            $line[] = iconv("UTF-8", "ASCII//TRANSLIT", $biobank->getShortContact());
            $line[] = iconv("UTF-8", "ASCII//TRANSLIT", $biobank->getEmailContact());
            $line[] = iconv("UTF-8", "ASCII//TRANSLIT", $biobank->getPhoneContact());
            
            $data[] = $line;
        }
        Yii::import('application.extensions.phpexcel.JPhpExcel');
        $xls = new JPhpExcel('UTF-8', true, 'Biobank list');
        $xls->addArray($data);
        $xls->generateXML('Biobank list');
    }

    /**
     * export pdf avec mpdf et liste  d'index : Technique HTML to PDF
     */
    public function actionExportPdf() {
        $criteria = new EMongoCriteria;
        $criteria->sort('name', EMongoCriteria::SORT_ASC);
        $models = Biobank::model()->findAll($criteria);
        BiobanksPDFExporter::exporter($models);
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

}
?>
