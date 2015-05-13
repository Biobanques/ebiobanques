<?php
/* @var $this BiobankController */
/* @var $model Biobank */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 45, 'maxlength' => 45)); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'identifier'); ?>
        <?php echo $form->textField($model, 'identifier', array('size' => 45, 'maxlength' => 45)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'collection_id'); ?>
        <?php echo $form->textField($model, 'collection_id', array('size' => 45, 'maxlength' => 45)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'collection_name'); ?>
        <?php echo $form->textField($model, 'collection_name', array('size' => 45, 'maxlength' => 45)); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'diagnosis_available'); ?>
        <?php echo $form->textField($model, 'diagnosis_available', array('size' => 45, 'maxlength' => 45)); ?>
    </div>

    <?php echo $form->label($model, 'contact_id'); ?>
    <?php echo $form->dropDownList($model, 'contact_id', $model->getArrayActiveContact(), array('prompt' => '----')); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->