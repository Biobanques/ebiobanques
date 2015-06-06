<?php

/**
 * lib d export csv
 */
Yii::import('ext.ECSVExport');

/**
 * controller de recherche d'echantillons
 *
 * @author matthieu
 *
 */
class SearchSamplesController extends Controller
{

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
                    'print',
                    'exportXls',
                    'exportCsv',
                    'exportPdf'
                ),
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
     * export csv des echantillons.
     */
    public function actionExportCsv() {
        $model = new Sample('search');
        $model->unsetAttributes();
        if (isset($_GET ['Sample']))
            $model->attributes = $_GET ['Sample'];
        // reprend les critères de la dernière recherche
        if (isset($_SESSION['criteria']) && $_SESSION['criteria'] != null && $_SESSION['criteria'] instanceof EMongoCriteria) {
            $criteria = $_SESSION['criteria'];
        } else {
            $criteria = new EMongoCriteria;
        }
        $criteria->limit(200);
        $models = Sample::model()->findAll($criteria);
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
                    if (is_array($model->$attribute)) {
                        if ($attribute == 'notes')
                            $datas[$attribute] = $model->getShortNotes();
                    } else if (!is_object($model->$attribute)) {
                        $datas[$attribute] = $model->$attribute;
                    }
                } else {
                    $datas[$attribute] = "";
                }
            }
            $dataProvider[] = $datas;
        }
        $filename = 'samples_list.csv';
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
     * fonction pour preparer une colonne a ajouter dans le grid des colonnes
     */
    function addColumn($key, $header, $value) {
        return array(
            'class' => 'DataColumn',
            'name' => $key,
            'id' => 'col_' . $key,
            'value' => $value,
            'header' => $header,
            'htmlOptions' => array(
                'class' => "col_$key",
            ),
            'headerHtmlOptions' => array(
                'class' => "col_$key",
            )
        );
    }

    /**
     * export pdf avec mpdf et liste d'index : Technique HTML to PDF
     */
    public function actionExportPdf() {


        $model = new Sample;
        $columns = array();
        foreach ($model->attributeExportedLabels() as $key => $value) {
            if ($key == 'notes') {
                $columns [] = $this->addColumn($key, $value, '$data->getShortNotes()');
            } elseif ($key == 'biobank_id') {
                $columns [] = $this->addColumn('biobank_id', $value, '$data->getBiobankName()');
            } elseif ($key == 'collect_date') {
                $columns [] = $this->addColumn('collect_date', $value, '$data->collect_date');
                //TODO normaliser les dates de collecte avant d activer cette feature
                // $columns [] = getArrayColumn('collect_date', $value, 'CommonTools::toShortDateFR($data->collect_date)');
            } elseif ($key == 'storage_conditions') {
                $columns [] = $this->addColumn('storage_conditions', $value, '$data->getLiteralStorageCondition()');
            } else {
                $columns [] = $this->addColumn($key, $value, '$data->' . $key);
            }
        }


        if (isset($_SESSION['criteria']) && $_SESSION['criteria'] != null && $_SESSION['criteria'] instanceof EMongoCriteria) {
            $criteria = $_SESSION['criteria'];
        } else {
            $criteria = new EMongoCriteria;
        }
        $criteria->limit(200);
        $dataProvider = new EMongoDocumentDataProvider('Sample', array(
            'criteria' => $criteria,
            'pagination' => false,
        ));

        $mPDF1 = Yii::app()->ePdf->mpdf();

        $mPDF1->WriteHTML($this->renderPartial('print', array('dataProvider' => $dataProvider, 'columns' => $columns), true));
        $mPDF1->Output('biobanks_list.pdf', 'I');
    }

    /**
     * Export des echantillons issus de la recherche en xls
     */
    public function actionExportXls() {

        $model = new Sample('search');
        $model->unsetAttributes();
        if (isset($_GET ['Sample']))
            $model->attributes = $_GET ['Sample'];
        // reprend les critères de la dernière recherche
        $dataprovider = new EMongoDocumentDataProvider('Sample', array(
            'criteria' => $_SESSION ['criteria'],
            'pagination' => array('pageSize' => CommonTools::XLS_EXPORT_NB)
        ));
        // supprime la pagination pour exporter l'ensemble des echantillons
        //	$echantillons = $dataprovider->data;

        $data = array(
            1 => array_keys($model->attributeExportedLabels())
        );
        setlocale(LC_ALL, 'fr_FR.UTF-8');
        $nb = 0;
        foreach ($dataprovider->data as $ech) {

            $line = array();
            foreach (array_keys($model->attributeExportedLabels()) as $attribute) {
                if ($attribute != 'notes') {
                    if ($ech->$attribute != null && !empty($ech->$attribute)) {
                        $line [] = trim(iconv('UTF-8', 'ASCII//TRANSLIT', $ech->$attribute)); // solution la moins pire qui ne fait pas bugge les accents mais les convertit en caractere generique
                    } else {
                        $line [] = "-";
                    }
                } else {
                    foreach ($ech->$attribute as $noteValue) {
                        $line[] = trim(iconv('UTF-8', 'ASCII//TRANSLIT', $noteValue->key . ' : ' . $noteValue->value));
                    }
                }
            }

            $data [] = $line;
        }

        Yii::import('application.extensions.phpexcel.JPhpExcel');
        $xls = new JPhpExcel('UTF-8', true, 'Sample list');
        $xls->addArray($data);
        $xls->generateXML('sample list');
    }

    /**
     * print de la liste dechantillons
     */
    public function actionPrint() {
        // $model = new Sample('search');
        if (isset($_SESSION['criteria']) && $_SESSION['criteria'] != null && $_SESSION['criteria'] instanceof EMongoCriteria) {
            $criteria = $_SESSION['criteria'];
        } else {
            $criteria = new EMongoCriteria;
        }
        $criteria->limit(200);
        $dataProvider = new EMongoDocumentDataProvider('Sample', array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
        $columns = array();
        foreach (Sample::model()->attributeExportedLabels() as $key => $value) {
            if ($key == 'notes') {
                $columns [] = $this->addColumn($key, $value, '$data->getShortNotes()');
            } elseif ($key == 'biobank_id') {
                $columns [] = $this->addColumn('biobank_id', $value, '$data->getBiobankName()');
            } elseif ($key == 'collect_date') {
                $columns [] = $this->addColumn('collect_date', $value, '$data->collect_date');
                //TODO normaliser les dates de collecte avant d activer cette feature
                // $columns [] = getArrayColumn('collect_date', $value, 'CommonTools::toShortDateFR($data->collect_date)');
            } elseif ($key == 'storage_conditions') {
                $columns [] = $this->addColumn('storage_conditions', $value, '$data->getLiteralStorageCondition()');
            } else {
                $columns [] = $this->addColumn($key, $value, '$data->' . $key);
            }
        }
        $this->render('print', array(
            'dataProvider' => $dataProvider,
            'columns' => $columns
        ));
    }

}
?>