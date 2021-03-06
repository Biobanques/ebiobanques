<?php
/* @var $this BiobankController */
/* @var $data Biobank */
?>

<div class="view">
        <table width="720" border="1" cellpadding="10" cellspacing="0" bordercolor="#000000">
<tr>
<td nowrap>
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('identifier')); ?>:</b>
	<?php echo CHtml::encode($data->identifier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('collection_name')); ?>:</b>
	<?php echo CHtml::encode($data->collection_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('collection_id')); ?>:</b>
	<?php echo CHtml::encode($data->collection_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_entry')); ?>:</b>
	<?php echo CHtml::encode($data->date_entry); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('folder_reception')); ?>:</b>
	<?php echo CHtml::encode($data->folder_reception); ?>
	<br />
        </td>
</tr>
</table>
        <hr width=75%"/>
        
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('folder_done')); ?>:</b>
	<?php echo CHtml::encode($data->folder_done); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passphrase')); ?>:</b>
	<?php echo CHtml::encode($data->passphrase); ?>
	<br />

	*/ ?>

</div>