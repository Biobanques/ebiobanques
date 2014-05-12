<?php
/* @var $this EchantillonController */
/* @var $model Echantillon */

$this->breadcrumbs=array(
	'Echantillons'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Echantillon', 'url'=>array('index')),
	array('label'=>'Create Echantillon', 'url'=>array('create')),
	array('label'=>'Update Echantillon', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete Echantillon', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Echantillon', 'url'=>array('admin')),
);
?>

<h1>View Echantillon #<?php echo $model->biobank_id.'_'.$model->id_sample; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
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
	),
)); ?>
