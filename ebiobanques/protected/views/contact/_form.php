<?php
/* @var $this ContactController */
/* @var $model Contact */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('common','ChampsObligatoires'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?><p>Format : +33601020304</p>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'adresse'); ?>
		<?php echo $form->textField($model,'adresse',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'adresse'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ville'); ?>
		<?php echo $form->textField($model,'ville',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'ville'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pays'); ?>
		<?php echo $form->textField($model,'pays'); ?>
		<?php echo $form->error($model,'pays'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'code_postal'); ?>
		<?php echo $form->textField($model,'code_postal',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'code_postal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inactive'); ?>
		<?php echo $form->textField($model,'inactive'); ?>
		<?php echo $form->error($model,'inactive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->