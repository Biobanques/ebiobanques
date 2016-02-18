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
        <?php echo $form->textField($model, 'name', array('size' => 20, 'maxlength' => 45)); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'identifier'); ?>
        <?php echo $form->textField($model, 'identifier', array('size' => 20, 'maxlength' => 45)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'collection_name'); ?>
        <?php echo $form->textField($model, 'collection_name', array('size' => 20, 'maxlength' => 45)); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'qualityCombinate'); ?>
        <?php echo $form->textField($model, 'qualityCombinate', array('size' => 20, 'maxlength' => 45)); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model->address, 'city'); ?>
        <?php echo $form->dropDownList($model->address, 'city', $model->address->getActiveListOfCities(), array('prompt' => '----', 'style' => "width:33%")); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model->address, 'country'); ?>
        <?php echo $form->dropDownList($model->address, 'country', $model->address->getActiveListOfCountries(), array('prompt' => '----', 'style' => "width:33%")); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'contact_id'); ?>
        <?php echo $form->dropDownList($model, 'contact_id', $model->getArrayActiveContact(), array('prompt' => '----', 'style' => "width:33%")); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'responsable_adj'); ?>
        <?php echo $form->dropDownList($model->responsable_adj, 'FullNameForDDList', $model->getRespDropdownList('responsable_adj'), array('prompt' => '----', 'style' => "width:33%")); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'responsable_op'); ?>
        <?php echo $form->dropDownList($model->responsable_op, 'FullNameForDDList', $model->getRespDropdownList('responsable_op'), array('prompt' => '----', 'style' => "width:33%")); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'responsable_qual'); ?>
        <?php echo $form->dropDownList($model->responsable_qual, 'FullNameForDDList', $model->getRespDropdownList('responsable_qual'), array('prompt' => '----', 'style' => "width:33%")); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->