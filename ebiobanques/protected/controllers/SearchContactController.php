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
class SearchContactController extends Controller{
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
	 * export csv des contacts.
	 */
	public function actionExportCsv()
	{
		$model = new Contact('search');
		$model->unsetAttributes();
		if(isset($_GET['Contact']))
			$model->attributes=$_GET['Contact'];
		$dataProvider = new CActiveDataProvider('Contact',array('criteria'=>$_SESSION['criteria']));
		$filename = 'contacts_list.csv';
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
		$dataProvider = new CActiveDataProvider('Contact',array('criteria'=>$_SESSION['criteria']));
		$mPDF1->WriteHTML($this->renderPartial('print', array('dataProvider'=>$dataProvider), true));
		$mPDF1->Output('contacts_list.pdf', 'I');
	}
	
	public function actionExportXls(){
		$model = new Contact('search');
		$model->unsetAttributes();
		if(isset($_GET['Contact']))
			$model->attributes=$_GET['Contact'];
		$dataProvider = new CActiveDataProvider('Contact',array('criteria'=>$_SESSION['criteria']));
		
		$contacts = $dataProvider->data;
		$data = array(1 =>array_keys($model->attributeExportedLabels()));
		setlocale(LC_ALL,'fr_FR.UTF-8');
		foreach($contacts as $contact){
			$line = array();
			foreach(array_keys($model->attributeExportedLabels()) as $attribute){
				if($contact->$attribute!=null&&!empty($contact->$attribute)){
					$line[]=iconv("UTF-8", "ASCII//TRANSLIT",$contact->$attribute);//solution la moins pire qui ne fait pas bugge les accents mais les convertit en caractere generique
				}else{
					$line[]="-";
				}
			}
			$data[]=$line;
		}
		Yii::import('application.extensions.phpexcel.JPhpExcel');
		$xls = new JPhpExcel('UTF-8', true, 'Contact list');
		$xls->addArray($data);
		$xls->generateXML('Contact list');
	}
	
	/**
	 * print de la liste des contacts
	 */
	public function actionPrint()
	{
				$dataProvider = new CActiveDataProvider('Contact',array('criteria'=>$_SESSION['criteria']));
		$this->render('print',array(
				'dataProvider'=>$dataProvider,
		));
	}
}

?>