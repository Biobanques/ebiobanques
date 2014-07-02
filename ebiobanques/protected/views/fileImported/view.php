<?php
/* @var $this FileImportedController */
/* @var $model FileImported */

$this->breadcrumbs=array(
	'File Importeds'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FileImported', 'url'=>array('index')),
	array('label'=>'Create FileImported', 'url'=>array('create')),
	array('label'=>'Update FileImported', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FileImported', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FileImported', 'url'=>array('admin')),
);
?>

<h1>View FileImported #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'biobank_id',
		'extraction_id',
		'given_name',
		'suffix_type',
		'generated_name',
		'date_import',
		'version_format',
	),
)); ?>
