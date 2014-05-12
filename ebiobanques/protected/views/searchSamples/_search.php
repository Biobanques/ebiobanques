<?php
/* @var $this EchantillonController */
/* @var $model Echantillon */
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
		<?php echo $form->label($model,'id_depositor'); ?>
		<?php echo $form->textField($model,'id_depositor',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_sample'); ?>
		<?php echo $form->textField($model,'id_sample',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'consent_ethical'); ?>
		<?php echo $form->textField($model,'consent_ethical',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gender'); ?>
		<?php echo $form->textField($model,'gender',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'age'); ?>
		<?php echo $form->textField($model,'age'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'collect_date'); ?>
		<?php echo $form->textField($model,'collect_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'storage_conditions'); ?>
		<?php echo $form->textField($model,'storage_conditions',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'consent'); ?>
		<?php echo $form->textField($model,'consent',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'supply'); ?>
		<?php echo $form->textField($model,'supply',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'max_delay_delivery'); ?>
		<?php echo $form->textField($model,'max_delay_delivery'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'detail_treatment'); ?>
		<?php echo $form->textField($model,'detail_treatment',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'disease_outcome'); ?>
		<?php echo $form->textField($model,'disease_outcome',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'authentication_method'); ?>
		<?php echo $form->textField($model,'authentication_method',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'patient_birth_date'); ?>
		<?php echo $form->textField($model,'patient_birth_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tumor_diagnosis'); ?>
		<?php echo $form->textField($model,'tumor_diagnosis',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'biobank_id'); ?>
		<?php echo $form->textField($model,'biobank_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'file_imported_id'); ?>
		<?php echo $form->textField($model,'file_imported_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->