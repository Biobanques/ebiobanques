<?php
/* @var $this EchantillonController */
/* @var $model Echantillon */

$this->breadcrumbs=array(
	'Echantillons'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Echantillon', 'url'=>array('index')),
	array('label'=>'Create Echantillon', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#echantillon-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Echantillons</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'echantillon-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'id_depositor',
		'id_sample',
		'consent_ethical',
		'gender',
		'age',
		'collect_date',
		'storage_conditions',
		'consent',
		'supply',
		'max_delay_delivery',
		'detail_treatment',
		'disease_outcome',
		'authentication_method',
		'patient_birth_date',
		'tumor_diagnosis',
		'biobank_id',
		'file_imported_id',
		array('header'=>'notes','value'=>'$data->getShortNotes()'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
