<?php
/* @var $this DemandeController */
/* @var $model Demande */
/* @var $form CActiveForm */
?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'demande-form',
        'enableAjaxValidation' => true
            ));
    ?>
    <?php echo $form->errorSummary($model); ?>
    <div class="row" style="float:left;">
        <?php echo $form->labelEx($model, 'titre'); ?>
        <?php echo $form->textField($model, 'titre'); ?>
        <?php echo $form->error($model, 'titre'); ?>
    </div>
    <div class="row" style="float:left;padding-left:10px;">
        <?php echo $form->labelEx($model, 'dateDemande'); ?>
        <?php echo $form->textField($model, 'dateDemande', array('disabled' => 'disabled')); ?>
        <?php echo $form->error($model, 'dateDemande'); ?>
    </div>
    <div class="row" style="clear:both;">
        <?php echo $form->labelEx($model, 'detail'); ?>
        <?php echo $form->textArea($model, 'detail', array('rows' => 5, 'cols' => 80)); ?>
        <?php echo $form->error($model, 'detail'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'createBtn') : Yii::t('common', 'saveBtn')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>
<!-- form -->