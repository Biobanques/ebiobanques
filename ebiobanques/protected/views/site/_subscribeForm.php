<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="wide form">
    <?php
    $this->renderPartial('/site/_help_message', array('title' => Yii::t('common', 'subscribeHelpTitle'), 'content' => Yii::t('common', 'subscribeHelpContent')));
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note"><?php echo Yii::t('common', 'ChampsObligatoires'); ?></p>

    <?php echo $form->errorSummary($model); ?>
    <table><tr>
            <td>
                <?php echo $form->labelEx($model, 'prenom'); ?>
                <?php echo $form->textField($model, 'prenom', array('size' => 20, 'maxlength' => 250)); ?>
                <?php echo $form->error($model, 'prenom'); ?>
            </td>
            <td>
                <?php echo $form->labelEx($model, 'nom'); ?>
                <?php echo $form->textField($model, 'nom', array('size' => 20, 'maxlength' => 250)); ?>
                <?php echo $form->error($model, 'nom'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $form->labelEx($model, 'login'); ?>
                <?php echo $form->textField($model, 'login', array('size' => 20, 'maxlength' => 250)); ?>
                <?php echo $form->error($model, 'login'); ?>
            </td>
            <td>
                <?php echo $form->labelEx($model, 'password'); ?>
                <?php echo $form->passwordField($model, 'password', array('size' => 20, 'maxlength' => 250)); ?>
                <?php echo $form->error($model, 'password'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $form->labelEx($model, 'email'); ?>
                <?php echo $form->textField($model, 'email', array('size' => 20, 'maxlength' => 250)); ?>
                <?php echo $form->error($model, 'email'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $form->labelEx($model, 'telephone'); ?>
                <?php echo $form->textField($model, 'telephone', array('size' => 20, 'maxlength' => 250)); ?>
                <?php echo $form->error($model, 'telephone'); ?>
            </td>
            <td>
                <?php echo $form->labelEx($model, 'gsm'); ?>
                <?php echo $form->textField($model, 'gsm', array('size' => 20, 'maxlength' => 250)); ?>
                <?php echo $form->error($model, 'gsm'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <p class="note">Cliquez sur l'image pour rafraichir</p>
                <?php
                $this->widget('CCaptcha', array('clickableImage' => true, 'showRefreshButton' => false));
                echo '<br>';
                echo $form->labelEx($model, 'verifyCode');

                echo $form->textField($model, 'verifyCode');

                echo $form->error($model, 'verifyCode');
                ?>



                <div class="row buttons">
                    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'subscribe') : Yii::t('common', 'save')); ?>
                </div>
            </td></tr></table>
    <?php $this->endWidget(); ?>

</div><!-- form -->