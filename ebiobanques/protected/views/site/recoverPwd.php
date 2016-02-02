<?php
/* @var $this SiteController */
?>
<h1><?php echo Yii::t('common', 'forgotedPwd'); ?></h1>
<div class ="help">
    <div class="help-title">Récupération de mot de passe</div>
    <div class='help-content'>Entrez votre login ou votre email. Votre mot de passe vous sera envoyé sur l'email utilisé lors de votre inscription.</div>
</div>
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
