<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note"><?php echo Yii::t('common', 'requiredField') ?></p>

    <?php echo $form->errorSummary($model); ?>
    <div style="float:left;width:450px;padding-top:10px;">
        <div class="row" style="margin-left:0px;">
            <?php echo $form->labelEx($model, 'prenom'); ?>
            <?php echo $form->textField($model, 'prenom', array('size' => 25, 'maxlength' => 250)); ?>
            <?php echo $form->error($model, 'prenom'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'nom'); ?>
            <?php echo $form->textField($model, 'nom', array('size' => 25, 'maxlength' => 250)); ?>
            <?php echo $form->error($model, 'nom'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'login'); ?>
            <?php echo $form->textField($model, 'login', array('size' => 25, 'maxlength' => 250)); ?>
            <?php echo $form->error($model, 'login'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', array('size' => 25, 'maxlength' => 250)); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'passwordCompare'); ?>
            <?php echo $form->passwordField($model, 'passwordCompare', array('size' => 25, 'maxlength' => 250)); ?>
            <?php echo $form->error($model, 'passwordCompare'); ?>
        </div>

    </div>
    <div style="float:left;width:450px;padding-top:10px;">
        <div class="row">
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email', array('size' => 25, 'maxlength' => 250)); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'telephone'); ?>

            <?php echo $form->textField($model, 'telephone', array('size' => 20, 'maxlength' => 250, 'placeholder' => CommonTools::getPhoneRegex()['fr']['readable'])); ?>
            <?php echo $form->error($model, 'telephone'); ?>

            <?php echo $form->labelEx($model, 'gsm'); ?>
            <?php echo $form->textField($model, 'gsm', array('size' => 20, 'maxlength' => 250, 'placeholder' => CommonTools::getPhoneRegex()['fr']['readable'])); ?>
            <?php echo $form->error($model, 'gsm'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'profil'); ?>
            <?php echo CHtml::textField('profil', $model->getProfil(), array('size' => 25, 'maxlength' => 250, 'readonly' => true)); ?>
            <?php echo $form->error($model, 'profil'); ?>
        </div>

    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('common', 'saveBtn')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->