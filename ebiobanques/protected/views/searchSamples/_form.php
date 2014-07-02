

<?php
/* @var $this EchantillonController */
/* @var $model Echantillon */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'echantillon-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('common','ChampsObligatoires'); ?></p>

	<?php echo $form->errorSummary($model); ?>
<div style="float:left;width:300px;padding-left:5px;">
	<div class="row">
		<?php echo $form->labelEx($model,'id_depositor'); ?>
		<?php echo $form->textField($model,'id_depositor',array('size'=>5,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'id_depositor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'id_sample'); ?>
		<?php echo $form->textField($model,'id_sample',array('size'=>5,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'id_sample'); ?>
	</div>

	<div class="row">
			<?php echo $form->label($model,'consent_ethical'); ?>
			<?php echo $form->dropDownList($model,'consent_ethical',$model->getArrayConsent(),array('prompt' => '----')); ?>
	
	</div>

	<div class="row">
		<?php echo $form->label($model,'gender'); ?>
			<?php echo $form->dropDownList($model,'gender',$model->getArrayGender(),array('prompt' => '----')); ?>
	
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'age'); ?>
		<?php echo $form->textField($model,'age',array('size'=>5)); ?>
		<?php echo $form->error($model,'age'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'collect_date'); ?>
		<?php echo $form->textField($model,'collect_date',array('size'=>5)); ?>
		<?php echo $form->error($model,'collect_date'); ?>
	</div>
</div>
<div style="float:left;width:300px;padding-left:5px;padding-right:5px;">
	<div class="row">
			<?php echo $form->label($model,'storage_conditions'); ?>
			<?php echo $form->dropDownList($model,'storage_conditions',$model->getArrayStorage(),array('prompt' => '----')); ?>
	
	</div>

	<div class="row">
			<?php echo $form->label($model,'consent'); ?>
			<?php echo $form->dropDownList($model,'consent',$model->getArrayConsent(),array('prompt' => '----')); ?>
	
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supply'); ?>
		<?php echo $form->textField($model,'supply',array('size'=>5,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'supply'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'max_delay_delivery'); ?>
		<?php echo $form->textField($model,'max_delay_delivery',array('size'=>5)); ?>
		<?php echo $form->error($model,'max_delay_delivery'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'detail_treatment'); ?>
		<?php echo $form->textField($model,'detail_treatment',array('size'=>5,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'detail_treatment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'disease_outcome'); ?>
		<?php echo $form->textField($model,'disease_outcome',array('size'=>5,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'disease_outcome'); ?>
	</div>
</div>
<div style="float:left;width:300px;padding-right:5px;">
	<div class="row">
		<?php echo $form->labelEx($model,'authentication_method'); ?>
		<?php echo $form->textField($model,'authentication_method',array('size'=>5,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'authentication_method'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'patient_birth_date'); ?>
		<?php echo $form->textField($model,'patient_birth_date',array('size'=>5)); ?>
		<?php echo $form->error($model,'patient_birth_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tumor_diagnosis'); ?>
		<?php echo $form->textField($model,'tumor_diagnosis',array('size'=>5,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'tumor_diagnosis'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'biobank_id'); ?>
		<?php echo $form->textField($model,'biobank_id',array('size'=>5)); ?>
		<?php echo $form->error($model,'biobank_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_imported_id'); ?>
		<?php echo $form->textField($model,'file_imported_id',array('size'=>5)); ?>
		<?php echo $form->error($model,'file_imported_id'); ?>
	</div>
</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->