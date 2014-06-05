<?php
/* @var $this SiteController */
?>
<h1><?php echo Yii::t('common', 'forgotedPwd'); ?></h1>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'recover-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'identifier'); ?>
        <?php echo $form->textField($model, 'identifier'); ?>
        <?php echo $form->error($model, 'identifier'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email'); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>




    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('common', 'submit')); ?>
    </div>

    <?php
    $this->endWidget();
    ?>
