<?php
/* @var $this BiobankController */
/* @var $model Biobank */

$this->breadcrumbs=array(
	'Biobanks'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Biobank', 'url'=>array('index')),
	array('label'=>'Create Biobank', 'url'=>array('create')),
	array('label'=>'Update Biobank', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Biobank', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Biobank', 'url'=>array('admin')),
);
?>

<h1>View Biobank #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'identifier',
		'name',
		'collection_name',
		'collection_id',
		'date_entry',
		'folder_reception',
		'folder_done',
		'passphrase',
            'diagnosis_available'
	),
)); ?>
