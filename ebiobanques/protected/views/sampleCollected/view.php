<?php
/* @var $this EchantillonController */
/* @var $model Echantillon */
?>

<h1>Echantillon #<?php echo $model->_id ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
//	'attributes'=>array(
//		'id_depositor',
//		'id_sample',
//		'consent_ethical',
//		'gender',
//		'age',
//		'collect_date',
//		'storage_conditions',
//		'consent',
//		'supply',
//		'max_delay_delivery',
//		'detail_treatment',
//		'disease_outcome',
//		'authentication_method',
//		'patient_birth_date',
//		'tumor_diagnosis',
//		array('name'=>'biobank','value'=>$model->getBiobankName()),
//		'file_imported_id',
//	),
));
?>
