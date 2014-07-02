<h1><?php echo Yii::t('common','sample').' #'.$model->biobank_id.'_'.$model->id_sample; ?></h1>

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