<?php
//echo Yii::app()->request->urlReferrer;
//Chargement des preferen,ces d'affichage de colonnes
$prefs = Preferences::model ()->findByAttributes ( array (
		'id_user' => Yii::app ()->user->id
) );
if ($prefs == null) {
	$prefs = new Preferences ();
	$prefs->id_user = Yii::app ()->user->id;
	$prefs->save ();
}

$prefsNames = Preferences::model ()->attributeNames ();
$imageSampleDetail = './images/zoom.png';
$columns = array ();
foreach ( $prefsNames as $property ) {

	if ($property != 'id_user'&&$property!="_id") {
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
					'name' => Yii::t('sample','biobank_id'),
					'id' => 'col_' . $property,
					'value' => 'Biobank::model()->getBiobank($data->biobank_id)->name',
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
		'labelExpression' => '$data->_id',
		'urlExpression' => 'Yii::app()->createUrl("site/view",array("id"=>"$data->_id"))',
		'linkHtmlOptions' => array (
				'onclick' => 'window.open(this.href,"_blank","left=100,top=100,width=760,height=650,toolbar=0,resizable=0, location=no");return false;'
		),
		'htmlOptions'=>array('style'=>'text-align:center'),
		'imageUrl' => $imageSampleDetail
		);
 ?>

<h1><?php echo Yii::t('common','demande').' '.$model->titre; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model));

?>
<div style="margin:10px">
<?php


$this->widget('application.extensions.selgridview.SelGridView', array(
		'id'=>'echSelected-grid',
		'dataProvider'=>$model->getSamples(),

'columns'=>$columns,
'selectableRows' => 0,
'enableHistory' => true,
)); ?>
</div>