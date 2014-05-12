<?php
/* @var $this NoteController */
/* @var $model Note */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'note-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('common','ChampsObligatoires'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'echantillon_id'); ?>
		<?php echo $form->textField($model,'echantillon_id'); ?>
		<?php echo $form->error($model,'echantillon_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CLE'); ?>
		<?php echo $form->textField($model,'CLE',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'CLE'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'VALEUR'); ?>
		<?php echo $form->textField($model,'VALEUR',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'VALEUR'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->