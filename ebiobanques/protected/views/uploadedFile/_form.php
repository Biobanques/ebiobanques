<?php
/* @var $this BiobankController */
/* @var $model Biobank */
/* @var $form CActiveForm */
/**
 * todo internationalzation
 */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'uploadedFile-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <p class="note"><?php echo Yii::t('common', 'requiredField'); ?></p>

    <?php echo $form->errorSummary($model); ?>
    <div style="float:left;width:750px;padding-left:5px;padding-right:5px;padding-top:10px">


        <div class="row">
            <?php echo $form->labelEx($model, 'formLabel'); ?>
            <?php echo $form->fileField($model, 'fileUploaded'); ?>
            <?php echo $form->error($model, 'fileUploaded'); ?>
        </div>


        <div class="row">
            <?php echo CHtml::submitButton(Yii::t('common', 'saveBtn')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->