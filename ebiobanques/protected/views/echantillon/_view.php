<?php
/* @var $this EchantillonController */
/* @var $data Echantillon */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->_id), array('view', 'id'=>$data->_id)); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('biobank_id')); ?>:</b>
	<?php echo CHtml::encode($data->biobank_id); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('id_sample')); ?>:</b>
	<?php echo CHtml::encode($data->id_sample); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_depositor')); ?>:</b>
	<?php echo CHtml::encode($data->id_depositor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('consent_ethical')); ?>:</b>
	<?php echo CHtml::encode($data->consent_ethical); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('age')); ?>:</b>
	<?php echo CHtml::encode($data->age); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('collect_date')); ?>:</b>
	<?php echo CHtml::encode($data->collect_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('storage_conditions')); ?>:</b>
	<?php echo CHtml::encode($data->storage_conditions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('consent')); ?>:</b>
	<?php echo CHtml::encode($data->consent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supply')); ?>:</b>
	<?php echo CHtml::encode($data->supply); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_delay_delivery')); ?>:</b>
	<?php echo CHtml::encode($data->max_delay_delivery); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('detail_treatment')); ?>:</b>
	<?php echo CHtml::encode($data->detail_treatment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('disease_outcome')); ?>:</b>
	<?php echo CHtml::encode($data->disease_outcome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('authentication_method')); ?>:</b>
	<?php echo CHtml::encode($data->authentication_method); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('patient_birth_date')); ?>:</b>
	<?php echo CHtml::encode($data->patient_birth_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tumor_diagnosis')); ?>:</b>
	<?php echo CHtml::encode($data->tumor_diagnosis); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('biobank_id')); ?>:</b>
	<?php echo CHtml::encode($data->biobank_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_imported_id')); ?>:</b>
	<?php echo CHtml::encode($data->file_imported_id); ?>
	<br />

	*/ ?>

</div>