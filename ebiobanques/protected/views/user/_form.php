<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note"><?php echo Yii::t('common', 'ChampsObligatoires'); ?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'prenom'); ?>
        <?php echo $form->textField($model, 'prenom', array('size' => 60, 'maxlength' => 250)); ?>
        <?php echo $form->error($model, 'prenom'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'nom'); ?>
        <?php echo $form->textField($model, 'nom', array('size' => 60, 'maxlength' => 250)); ?>
        <?php echo $form->error($model, 'nom'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'login'); ?>
        <?php echo $form->textField($model, 'login', array('size' => 60, 'maxlength' => 250)); ?>
        <?php echo $form->error($model, 'login'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 250)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 250)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'telephone'); ?>
        <?php echo $form->textField($model, 'telephone', array('size' => 60, 'maxlength' => 250)); ?>
        <?php echo $form->error($model, 'telephone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'gsm'); ?>
        <?php echo $form->textField($model, 'gsm', array('size' => 60, 'maxlength' => 250)); ?>
        <?php echo $form->error($model, 'gsm'); ?>
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
    <!--    <div class="row">
    <?php
//        echo $form->labelEx($model, 'biobank_id');
    ?>
    <?php
//echo $form->dropDownList($model, 'biobank_id', Biobank::model()->getArrayBiobanks(), array('prompt' => '----'));
    ?>
    <?php
//echo $form->error($model, 'biobank_id');
    ?>
        </div>-->

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Créer' : 'Sauvegarder'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->