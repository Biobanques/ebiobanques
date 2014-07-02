<?php
/* @var $this ConnecteurController */
/* @var $model Connecteur */
/* @var $form CActiveForm */
/**
 * todo internationalzation
 */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'connecteur-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <p class="note"><?php echo Yii::t('common', 'requiredField'); ?></p>

    <?php echo $form->errorSummary($model); ?>
    <div style="float:left;padding-left:5px;padding-right:5px;padding-top:10px">


        <div class="row">
            <?php echo $form->labelEx($model, 'filename'); ?>
            <?php echo $form->fileField($model, 'filename'); ?>
            <?php echo $form->error($model, 'filename'); ?>
        </div>
        <!--        <div class="row">
        <?php //echo $form->labelEx($model, 'biobanque'); ?>
        <?php //echo $form->textField($model, 'metadata["biobank_id"]', array('size' => 15, 'maxlength' => 45)); ?>
        <?php //echo $form->error($model, 'metadata["biobank_id"]'); ?>
                </div>-->


        <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('common', 'saveBtn')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->