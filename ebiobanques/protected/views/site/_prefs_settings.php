
<div>

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'prefs-form',

	
)); 
foreach($model->attributeNames () as $field){
	if($field!='id_user' && $field!='_id'&& $field!='id'){
	if($model->$field==1)
	$checked=true;
	else 
		$checked=false;
	?>
	<div style="float:left;width:200px;font-size:8pt">
	<?php echo $form->checkBox($model,$field,array('checked'=>$checked));?>
<span >
	<?php echo $form->label($model,$field);?>
	</span>
 </div> 

<?php 
}}
?>

	

<?php $this->endWidget(); ?>
</div>