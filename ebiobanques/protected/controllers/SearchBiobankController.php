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
class SearchBiobankController extends Controller{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
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
	public function accessRules()
	{
		return array(
				array('allow', // allow authenticated user to perform 'search' actions
						'actions'=>array('print','exportXls','exportCsv','exportPdf'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
		
	/**
	 * export csv des biobanques.
	 */
	public function actionExportCsv()
	{
		$model = new Biobank('search');
		$model->unsetAttributes();
		if(isset($_GET['Biobank']))
			$model->attributes=$_GET['Biobank'];
		$dataProvider = new CActiveDataProvider('Biobank',array('criteria'=>$_SESSION['criteria']));
		$filename = 'biobanks_list.csv';
		$csv = new ECSVExport($dataProvider);
		$toExclude=array();
		$toExport=$model->attributeExportedLabels();
		foreach($model->attributeLabels() as $attribute=>$value){
			
			if (!isset($toExport[$attribute]))
				$toExclude[]=$attribute;
		}
		$csv->setExclude($toExclude);
		$csv->exportCurrentPageOnly();
		Yii::app()->getRequest()->sendFile($filename, $csv->toCSV(), "text/csv", false);
	}
	
	/**
	 * export pdf avec mpdf et liste  d'index : Technique HTML to PDF
	 */
	public function actionExportPdf()
	{
		$mPDF1 = Yii::app()->ePdf->mpdf();
				$dataProvider = new CActiveDataProvider('Biobank',array('criteria'=>$_SESSION['criteria']));
		$mPDF1->WriteHTML($this->renderPartial('print', array('dataProvider'=>$dataProvider), true));
		$mPDF1->Output('biobanks_list.pdf', 'I');
	}
	/**
	 * export xls des biobanques
	 */
	public function actionExportXls(){
		$model = new Biobank('search');
		$model->unsetAttributes();
		if(isset($_GET['Biobank']))
			$model->attributes=$_GET['Biobank'];
		$dataProvider = new CActiveDataProvider('Biobank',array('criteria'=>$_SESSION['criteria']));
		$biobanks = $dataProvider->data;
		$data = array(1 =>array_keys($model->attributeExportedLabels()));
		setlocale(LC_ALL,'fr_FR.UTF-8');
		foreach($biobanks as $biobank){
			$line = array();
			foreach(array_keys($model->attributeExportedLabels()) as $attribute){
				if($biobank->$attribute!=null&&!empty($biobank->$attribute)){
					$line[]=iconv("UTF-8", "ASCII//TRANSLIT",$biobank->$attribute);//solution la moins pire qui ne fait pas bugge les accents mais les convertit en caractere generique
				}else{
					$line[]="-";
				}
			}
			$data[]=$line;
		}
		Yii::import('application.extensions.phpexcel.JPhpExcel');
		$xls = new JPhpExcel('UTF-8', true, 'Biobank list');
		$xls->addArray($data);
		$xls->generateXML('Biobank list');
	}
	
	/**
	 * print de la liste des biobanques
	 */
	public function actionPrint()
	{
		$dataProvider = new CActiveDataProvider('Biobank',array('criteria'=>$_SESSION['criteria']));
		$this->render('print',array(
				'dataProvider'=>$dataProvider,
		));
	}
}

?>