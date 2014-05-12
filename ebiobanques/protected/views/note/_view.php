<?php
/* @var $this NoteController */
/* @var $data Note */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('echantillon_id')); ?>:</b>
	<?php echo CHtml::encode($data->echantillon_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CLE')); ?>:</b>
	<?php echo CHtml::encode($data->CLE); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('VALEUR')); ?>:</b>
	<?php echo CHtml::encode($data->VALEUR); ?>
	<br />


</div>