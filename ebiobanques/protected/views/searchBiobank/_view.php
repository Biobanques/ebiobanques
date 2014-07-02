<?php
/* @var $this SearchBiobankController */
/* @var $data Biobank */
?>
<div class='view'>
<?php 
foreach(Biobank::Model()->attributeExportedLabels() as $attribute=>$value){
?>
<b><?php echo CHtml::encode($data->getAttributeLabel($attribute)); ?>:</b>
<?php 
if($attribute=='contact_id'){
		echo $data->contact_id!=null&&!empty($data->contact_id)?CHtml::encode($data->getShortContact()).'<br>'.CHtml::encode($data->getEmailContact()).'<br>'.CHtml::encode($data->getPhoneContact()):""; ?>

		<?php 
		}else
echo CHtml::encode($data->$attribute); ?>
<br />
<?php }?>
		<br />
		<br />
</div>