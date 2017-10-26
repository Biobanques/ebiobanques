<?php
/* @var $this UserController */
/* @var $model User */
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
        <?php echo $form->label($model, 'prenom'); ?>
        <?php echo $form->textField($model, 'prenom', array('size' => 60, 'maxlength' => 250)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'nom'); ?>
        <?php echo $form->textField($model, 'nom', array('size' => 60, 'maxlength' => 250)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'login'); ?>
        <?php echo $form->textField($model, 'login', array('size' => 60, 'maxlength' => 250)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 250)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'telephone'); ?>
        <?php echo $form->textField($model, 'telephone', array('size' => 60, 'maxlength' => 250)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'gsm'); ?>
        <?php echo $form->textField($model, 'gsm', array('size' => 60, 'maxlength' => 250)); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'profil'); ?>
        <?php echo $form->dropDownList($model, 'profil', User::model()->getArrayProfil(), array('prompt' => '----')); ?>
        <?php echo $form->error($model, 'profil'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'inactif'); ?>
        <?php echo $form->dropDownList($model, 'inactif', User::model()->getArrayInactif(), array('prompt' => '----')); ?>
        <?php echo $form->error($model, 'inactif'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'biobank_id'); ?>
        <?php echo $form->dropDownList($model, 'biobank_id', Biobank::model()->getArrayBiobanks(), array('prompt' => '----')); ?>
        <?php echo $form->error($model, 'biobank_id'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('common','search'), ['id' => 'searchUserButton']); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->