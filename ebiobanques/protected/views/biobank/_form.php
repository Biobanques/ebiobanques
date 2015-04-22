<?php
/* @var $this BiobankController */
/* @var $model Biobank */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'biobank-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('common','ChampsObligatoires'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

        <div><p>Identifier must be the BRIF Code if possible</p></div>
	<div class="row">
		<?php echo $form->labelEx($model,'identifier'); ?>
		<?php echo $form->textField($model,'identifier',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'identifier'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'collection_name'); ?>
		<?php echo $form->textField($model,'collection_name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'collection_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'collection_id'); ?>
		<?php echo $form->textField($model,'collection_id',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'collection_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_entry'); ?>
		<?php echo $form->textField($model,'date_entry'); ?>
		<?php echo $form->error($model,'date_entry'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'folder_reception'); ?>
		<?php echo $form->textField($model,'folder_reception',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'folder_reception'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'folder_done'); ?>
		<?php echo $form->textField($model,'folder_done',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'folder_done'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'passphrase'); ?>
		<?php echo $form->textField($model,'passphrase',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'passphrase'); ?>
	</div>
        <div><p>Le contact de la biobanque est une entrée différente de l utilisateur.<br>Elle est utile pour l'envoi d'informations tels les emails automatqiues de mise à jour.</p></div>
	<div class="row">
		<?php echo $form->labelEx($model,'contact_id'); ?>
                <?php echo $form->dropDownList($model,'contact_id',Contact::model()->getArrayContacts(),array('prompt' => '----')); ?>
		<?php echo $form->error($model,'contact_id'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'diagnosis_available'); ?>
		<?php echo $form->textField($model,'diagnosis_available',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'diagnosis_available'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->