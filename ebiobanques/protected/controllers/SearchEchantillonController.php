<?php
/**
 * lib d export csv
 */
Yii::import ( 'ext.ECSVExport' );
/**
 * controller de recherche d'echantillons
 * 
 * @author matthieu
 *        
 */
class SearchEchantillonController extends Controller {
	
	/**
	 *
	 * @return array action filters
	 */
	public function filters() {
		return array (
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
		return array (
				array (
						'allow', // allow authenticated user to perform 'search' actions
						'actions' => array (
								'print',
								'exportXls',
								'exportCsv',
								'exportPdf' 
						),
						'users' => array (
								'@' 
						) 
				),
				array (
						'deny', // deny all users
						'users' => array (
								'*' 
						) 
				) 
		);
	}
	
	/**
	 * export csv des echantillons.
	 */
	public function actionExportCsv() {
		set_time_limit(60);
		$model = new Echantillon ( 'search' );
		$model->unsetAttributes ();
		$criteria=$_SESSION ['criteria'];
		$criteria->limit=30000;
		if (isset ( $_GET ['Echantillon'] ))
			$model->attributes = $_GET ['Echantillon'];
		$dataProvider = new CActiveDataProvider ( 'Echantillon', array (
				'criteria' => $criteria,
				'pagination'=>false

		) );
		$filename = 'samples_list.csv';
		$csv = new ECSVExport ( $dataProvider );
		$toExclude = array ();
		$toExport = $model->attributeExportedLabels ();
		foreach ( $model->attributeLabels () as $attribute => $value ) {
			
			if (! isset ( $toExport [$attribute] ))
				$toExclude [] = $attribute;
		}
		$csv->setHeaders($toExport);
		$csv->setExclude ( $toExclude );
	//	$csv->exportCurrentPageOnly ();
		Yii::app ()->getRequest ()->sendFile ( $filename, $csv->toCSV (), "text/csv", false );
	}
	
	/**
	 * export pdf avec mpdf et liste d'index : Technique HTML to PDF
	 */
	public function actionExportPdf() {
		$mPDF1 = Yii::app ()->ePdf->mpdf ();
		$dataProvider = new CActiveDataProvider ( 'Echantillon' 
			 );
		$dataProvider = new CActiveDataProvider ( 'Echantillon', array (
				'criteria' => $_SESSION ['criteria'] 
		) );
		$mPDF1->WriteHTML ( $this->renderPartial ( 'print', array (
				'dataProvider' => $dataProvider 
		), true ) );
		$mPDF1->Output ( 'sample_list.pdf', 'I' );
	}
	/**
	 * Export des echantillons issus de la recherche en xls
	 */
	
	public function actionExportXls() {
		
		$model = new Echantillon ( 'search' );
		$model->unsetAttributes ();
		if (isset ( $_GET ['Echantillon'] ))
			$model->attributes = $_GET ['Echantillon'];
			// reprend les critères de la dernière recherche
		$dataprovider = new CActiveDataProvider ( 'Echantillon', array (
				'criteria' => $_SESSION ['criteria'],
				'pagination'=>array('pageSize'=>CommonTools::XLS_EXPORT_NB)

		) );
		// supprime la pagination pour exporter l'ensemble des echantillons
	
	//	$echantillons = $dataprovider->data;
		
		$data = array (
				1 => array_keys ( $model->attributeExportedLabels () ) 
		);
		setlocale ( LC_ALL, 'fr_FR.UTF-8' );
		$nb=0;
		foreach ( $dataprovider->data as $ech ) {

			$line = array ();
			foreach ( array_keys ( $model->attributeExportedLabels () ) as $attribute ) {
				if ($attribute != 'notes') {
					if ($ech->$attribute != null && ! empty ( $ech->$attribute )) {
						$line [] = trim(iconv ( 'UTF-8', 'ASCII//TRANSLIT', $ech->$attribute )); // solution la moins pire qui ne fait pas bugge les accents mais les convertit en caractere generique
					} else {
						$line [] = "-";
					}
				}else{
					foreach($ech->$attribute as $noteValue){
						$line[]=trim(iconv ( 'UTF-8', 'ASCII//TRANSLIT',$noteValue->CLE.' : '.$noteValue->VALEUR));
					}
				}
			}

 			$data [] = $line;
		
		}

		Yii::import ( 'application.extensions.phpexcel.JPhpExcel' );
		$xls = new JPhpExcel ( 'UTF-8', true, 'Sample list' );
 		$xls->addArray ( $data );
		$xls->generateXML ( 'sample list' );
	}
	
	/**
	 * print de la liste dechantillons
	 */
	public function actionPrint() {
		// $model = new Echantillon('search');
		$dataProvider = new CActiveDataProvider ( 'Echantillon', array (
				'criteria' => $_SESSION ['criteria'] 
		) );
		$this->render ( 'print', array (
				'dataProvider' => $dataProvider 
		) );
	}
}

?>