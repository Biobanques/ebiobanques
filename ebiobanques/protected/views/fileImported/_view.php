<?php
/* @var $this FileImportedController */
/* @var $data FileImported */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('biobank_id')); ?>:</b>
	<?php echo CHtml::encode($data->biobank_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extraction_id')); ?>:</b>
	<?php echo CHtml::encode($data->extraction_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('given_name')); ?>:</b>
	<?php echo CHtml::encode($data->given_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('suffix_type')); ?>:</b>
	<?php echo CHtml::encode($data->suffix_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('generated_name')); ?>:</b>
	<?php echo CHtml::encode($data->generated_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_import')); ?>:</b>
	<?php echo CHtml::encode($data->date_import); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('version_format')); ?>:</b>
	<?php echo CHtml::encode($data->version_format); ?>
	<br />

	*/ ?>

</div>