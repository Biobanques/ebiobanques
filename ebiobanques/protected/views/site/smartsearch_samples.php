<?php
$prefs = Preferences::model ()->findByAttributes ( array (
		'id_user' => Yii::app ()->user->id
) );
if ($prefs == null) {
	$prefs = new Preferences ();
	$prefs->id_user = Yii::app ()->user->id;
	$prefs->save ();
}
$prefsNames = Preferences::model ()->attributeNames ();
$scriptCB = '';
foreach ( $prefsNames as $property ) {
	if ($property != 'id_user') {
		$scriptCB = $scriptCB . '$(\'#Preferences_' . $property . '\').change(function(){
$(\'.col_' . $property . '\').toggle();
$(\'.prefs-form form\').submit();
return false;
});
'
		;
	}
}
// recharge le tableau d'affichage des échantillons après envoi du formulaire de recherche avancée
Yii::app ()->clientScript->registerScript ( 'search', "
$('.smart-search-form form').submit(function(){
	$('#sample-grid').yiiGridView('update', {
		data: $(this).serialize()
	});

	return false;
});
$('.prefs-form form').submit(function(){
	$('#sample-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
		
	return false;
});
$scriptCB;
" );
?>

<h1><?php echo Yii::t('common','searchsamples');?></h1>

<div style="margin: 5px;"><?php echo Yii::t('common','totalnumbersamples');?> : <b><?php echo $model->count();?></b>.<br>

</div>
</div>
<br>
<div class="smart-search-form">
<?php

$this->renderPartial ( '_search_smart_samples', array (
		'smartForm' => $smartForm 
) );
?>
 </div> 



<?php
//definition du widget d'affichage des prefernces
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
		'id'=>'selectPopup',
		// additional javascript options for the dialog plugin
		'options'=>array(
				'title'=>'Choix des colonnes ',
				'autoOpen'=>false,
				'width'=>'220px'
		),
));
?>
<div class="prefs-form" >
<?php 
   $this->renderPartial ( '_prefs_settings', array (
		'model' => $prefs
) );
?>
</div>
<?php 
$this->endWidget('zii.widgets.jui.CJuiDialog');

$imageSelect= CHtml::image(Yii::app()->baseUrl.'/images/table-icone.png', Yii::t('common','prefsSelect'));
$this->widget ( 'application.widgets.menu.CMenuBarLineWidget', array (
		'links' => array (),
		'controllerName' => 'searchSamples',
		'searchable' => false 
) );
?>
</div>
<?php
$columns = array ();

foreach ( $prefsNames as $property ) {
	
	if ($property != 'id_user'&&$property!='_id') {
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
					'value' => '$data->getBiobankName()',
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
$columns [] = array( 'class'=>'CButtonColumn',
'header' => CHtml::link ( $imageSelect, '#', array (
				'onclick' => '$("#selectPopup").dialog("open");return false;'
		) ), // lien d'affichage de la popup
'template'=>'{view}',
'buttons'=>array(
'view'=>array(
	'url' => 'Yii::app()->createUrl("site/view",array("id"=>"$data->_id", "asDialog"=>1))',
	'click'=>'function(){window.open(this.href,"_blank","left=100,top=100,width=760,height=650,toolbar=0,resizable=1, location=no");return false;}'
		
),
),
);
$this->widget ( 'zii.widgets.grid.CGridView', array (
		'id' => 'sample-grid',
		'dataProvider' => $model->searchWithNotes (),
		'columns' => $columns, 

) ); 
