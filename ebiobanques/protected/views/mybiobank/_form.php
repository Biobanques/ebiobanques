<?php
/* @var $this BiobankController */
/* @var $model Biobank */
/* @var $form CActiveForm */
/**
 * todo internationalzation
 */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'biobank-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('common','requiredField');?></p>

	<?php echo $form->errorSummary($model); ?>
<div style="float:left;width:320px;padding-left:5px;padding-right:5px;padding-top:10px">


	<div class="row">
		<?php echo $form->labelEx($model,'identifier'); ?>
		<?php echo $form->textField($model,'identifier',array('size'=>15,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'identifier'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>15,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'collection_name'); ?>
		<?php echo $form->textField($model,'collection_name',array('size'=>15,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'collection_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'collection_id'); ?>
		<?php echo $form->textField($model,'collection_id',array('size'=>15,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'collection_id'); ?>
	</div>
</div>
<div style="float:left;width:340px;padding-left:5px;padding-top:10px">
	<div class="row">
		<?php echo $form->labelEx($model,'date_entry'); ?>
		<?php echo $form->textField($model,'date_entry',array('size'=>15,'maxlength'=>200,'readonly'=>true)); ?>
		<?php echo $form->error($model,'date_entry'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'folder_reception'); ?>
		<?php echo $form->textField($model,'folder_reception',array('size'=>15,'maxlength'=>200,'readonly'=>true)); ?>
		<?php echo $form->error($model,'folder_reception'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'folder_done'); ?>
		<?php echo $form->textField($model,'folder_done',array('size'=>15,'maxlength'=>200,'readonly'=>true)); ?>
		<?php echo $form->error($model,'folder_done'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'passphrase'); ?>
		<?php echo $form->textField($model,'passphrase',array('size'=>15,'maxlength'=>200,'readonly'=>true)); ?>
		<?php echo $form->error($model,'passphrase'); ?>
	</div>
	<div class="row">
<!-- 	aggregation des champs nom et prenom pour affichage dans textfield non modifiable -->
		<?php 
		$name=$model->getShortContact();
// $name=$model->contact->first_name.' '.$model->contact->last_name
?>
		<?php echo $form->labelEx($model,'contact_id'); ?>
		<?php echo CHtml::textField('contact',$name,array('size'=>15,'maxlength'=>200,'readonly'=>true)); ?>
		<?php echo $form->error($model,'contact_id'); ?>
	</div>
</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('common','saveBtn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->