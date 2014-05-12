<?php
/* @var $this DemandeController */
/* @var $data Demande */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('_id')); ?>:</b>
	<?php //echo CHtml::link(CHtml::encode($data->_id), array('view', 'id'=>$data->_id)); ?>
	<?php echo CHtml::encode($data->_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_user')); ?>:</b>
	<?php echo CHtml::encode($data->id_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_demande')); ?>:</b>
	<?php echo CHtml::encode($data->date_demande); ?>
	<br />


</div>