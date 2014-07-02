<?php
/* @var $this FileImportedController */
/* @var $model FileImported */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'biobank_id'); ?>
		<?php echo $form->textField($model,'biobank_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'extraction_id'); ?>
		<?php echo $form->textField($model,'extraction_id',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'given_name'); ?>
		<?php echo $form->textField($model,'given_name',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'suffix_type'); ?>
		<?php echo $form->textField($model,'suffix_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'generated_name'); ?>
		<?php echo $form->textField($model,'generated_name',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_import'); ?>
		<?php echo $form->textField($model,'date_import'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'version_format'); ?>
		<?php echo $form->textField($model,'version_format'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->