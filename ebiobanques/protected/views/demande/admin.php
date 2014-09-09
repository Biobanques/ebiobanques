<?php
/* @var $this DemandeController */
/* @var $model Demande */



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#demande-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->beginWidget ( 'zii.widgets.jui.CJuiDialog', array (
		'id' => 'detailsDemande',
		// additional javascript options for the dialog plugin
		'options' => array (
				'title' => 'Détails de la demande',
				'autoOpen' => false,
				'width' => '220px'
		)
) );
?>
<div class="prefs-form">
<?php
$this->renderPartial ( '_view', array (
		'data' => $model
) );
?>
</div>
<?php
$this->endWidget ( 'zii.widgets.jui.CJuiDialog' );
?>

<h1>Manage Demandes</h1>



<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
$imageSelect = CHtml::image ( Yii::app()->baseUrl.'/images/table-icone.png', Yii::t ( 'common', 'prefsSelect' ) );
$imageSampleDetail = Yii::app()->baseUrl.'/images/zoom.png';
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'demande-grid',
	'dataProvider'=>$model->searchForCurrentUser(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		//'id_user',
		'date_demande',
array (
		'class' => 'CCheckBoxColumn',
		'id' => 'selectionCB',
		'headerHtmlOptions' => array (
				'onchange' => 'addAllEchToDemand()'
		),
		'checkBoxHtmlOptions' => array (
				'onchange' => 'addEchToDemand(this.value)'
		),

		'selectableRows' => 1,

		'checked' => '$data->isActive()'
),
array (
		'header' => CHtml::link ( $imageSelect, '#', array (
				'onclick' => '$("#detailsDemande").dialog("open");return false;'
		) ), // lien d'affichage de la popup
		'class' => 'CLinkColumn',
		'labelExpression' => '$data->id',
		'urlExpression' => 'Yii::app()->createUrl("demande/update",array("id"=>"$data->id"))',
		'linkHtmlOptions' => array (
				'onclick' => 'window.open(this.href,"_blank","left=100,top=100,width=800,height=450,toolbar=0,resizable=0, location=no");return false;'
		),
		'imageUrl' => $imageSampleDetail
)
// 		array(
// 			'class'=>'CButtonColumn',
// 		),
	),
'selectableRows'=>0,


)); ?>
