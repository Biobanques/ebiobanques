<?php
/* @var $this SearchContactController */
/* @var $data Contact */
?>
<div class='view'>
<?php 
foreach(Contact::Model()->attributeExportedLabels() as $attribute=>$value){
?>
<b><?php echo CHtml::encode($data->getAttributeLabel($attribute)); ?>:</b>
<?php 
if($attribute=='adresse'){
echo $data->adresse!=null?CHtml::encode($data->adresse).' - '.CHtml::encode($data->code_postal).' '.CHtml::encode($data->ville):""; ?>

		<?php 
		}elseif($attribute=='biobank'){
echo CHtml::encode(Biobank::Model()->findByAttributes(array('contact_id'=>$data->id))->identifier);
}else
echo CHtml::encode($data->$attribute);
  ?>
<br />
<?php }?>
		<br />
		<br />
</div>
