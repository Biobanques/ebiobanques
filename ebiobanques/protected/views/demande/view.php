<?php
/* @var $this DemandeController */
/* @var $model Demande */


//Chargement des preferen,ces d'affichage de colonnes
if(isset(Yii::app()->session['mails'])){
	unset(Yii::app()->session['mails']);
}

$prefs = Preferences::model ()->findByAttributes ( array (
		'id_user' => Yii::app ()->user->id
) );
if ($prefs == null) {
	$prefs = new Preferences ();
	$prefs->id_user = Yii::app ()->user->id;
	$prefs->save ();
}

$prefsNames = Preferences::model ()->attributeNames ();

$sortedData = $model->getArraySamples();
$arrayBiobank=$model->getBiobanksFromSamples($sortedData);

$imageSampleDetail = Yii::app()->baseUrl.'/images/zoom.png';
$columns = array ();

$columns [] = '_id';
foreach ( $prefsNames as $property ) {

	if ($property != 'id_user') {
		if ($prefs->$property)
			$visibility = "table_cell";
		else
			$visibility = 'display:none';
		if ($property == 'notes') {
			$columns [] = array (
					'class' => 'DataColumn',
					'name' => $property,
					'id' => 'col_' . $property,
					'value' => '$data->getShortNotes()',

					'htmlOptions' => array (
							'class' => "col_$property",
							'style' => $visibility
					),
					'headerHtmlOptions' => array (
							'class' => "col_$property",
							'style' => $visibility
					)
			);
		} elseif ($property == 'biobank_id') {
			$columns [] = array (
					'class' => 'DataColumn',
					'name' => $property,
					'id' => 'col_' . $property,
					'value' => '$data->biobank_id',
					'htmlOptions' => array (
							'class' => "col_$property",
							'style' => $visibility
					),
					'headerHtmlOptions' => array (
							'class' => "col_$property",
							'style' => $visibility
					)
			);
		} elseif ($property == 'collect_date') {
			$columns [] = array (
					'class' => 'DataColumn',
					'name' => $property,
					'id' => 'col_' . $property,
					'value' => 'CommonTools::toShortDateFR($data->collect_date)',
					'htmlOptions' => array (
							'class' => "col_$property",
							'style' => $visibility
					),
					'headerHtmlOptions' => array (
							'class' => "col_$property",
							'style' => $visibility
					)
			);
		} elseif ($property == 'storage_conditions') {
			$columns [] = array (
					'class' => 'DataColumn',
					'name' => $property,
					'id' => 'col_' . $property,
					'value' => '$data->getLiteralStorageCondition()',
					'htmlOptions' => array (
							'class' => "col_$property",
							'style' => $visibility
					),
					'headerHtmlOptions' => array (
							'class' => "col_$property",
							'style' => $visibility
					)
			);
		} else {
			$columns [] = array (
					'class' => 'DataColumn',
					'name' => $property,
					'id' => 'col_' . $property,
					'value' => '$data->' . $property,
					'htmlOptions' => array (
							'class' => "col_$property",
							'style' => $visibility
					),
					'headerHtmlOptions' => array (
							'class' => "col_$property",
							'style' => $visibility
					)
			);
		}
	}
}

$columns [] = array (
		'header' => Yii::t('common','sampleDetail'),
		// 		) ), // lien d'affichage de la popup
		'class' => 'CLinkColumn',
		'labelExpression' => '$data->id',
		'urlExpression' => 'Yii::app()->createUrl("site/view",array("id"=>"$data->_id"))',
		'linkHtmlOptions' => array (
				'onclick' => 'window.open(this.href,"_blank","left=100,top=100,width=760,height=450,toolbar=0,resizable=0, location=no");return false;'
		),
		'htmlOptions'=>array('style'=>'text-align:center'),
		'imageUrl' => $imageSampleDetail
);
?>


<h1> <?php echo Yii::t('common','demande').' '.$model->titre; ?></h1>

<?php


foreach($arrayBiobank as $biobankId){
	$biobank=Biobank::model()->findByAttributes(array('id'=>$biobankId));
	$contact=Contact::model()->findByAttributes(array('id'=>$biobank->contact_id));
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
				//'id',
				//'id_user',
				array('label'=>'Biobanque',
				'value'=>$biobank->identifier
				),
				'dateDemande',
				'titre',
				'detail',
				array(
					'label'=>'Contact',
					'value'=>$biobank->getShortContact().' - '.$biobank->getEmailContact()
					)),
		));

	$dataByBiobank=array();
foreach ($sortedData as $concern_sample){ 
	if($concern_sample->biobank_id==$biobankId){
		$dataByBiobank[]=$concern_sample;
	}
}

$this->widget('application.extensions.selgridview.SelGridView', array(
		'id'=>'echSelected-grid',
'dataProvider'=>new CArrayDataProvider ($dataByBiobank),
'columns'=>$columns,
'selectableRows' => 0,
'enableHistory' => true,
'enablePagination'=>false,
));

}

echo CHtml::button('envoyer la demande',
array(
'submit'=>array('demande/envoyer','demande_id'=>$model->_id)));

?>
