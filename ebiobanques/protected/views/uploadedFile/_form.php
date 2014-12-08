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
            <h3>What do you want to do?</h3>
            <h4><input type="radio" name="addOrRemove"  value="add">Add samples to previous</h4>

            <h4><input type="radio" name="addOrRemove" value="remove" checked="true">Remove previous after insert</h4>

            <?php // echo Yii::t('common', 'addOrReplace'); ?>
            <?php // echo $form->radioButtonList('', 'addOrRemove', array('add' => 'add samples to previous ones.', 'remove' => 'Remove samples after import')); ?>
            <?php // echo $form->radioButton(); ?>
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