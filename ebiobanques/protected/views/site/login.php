<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
?>

<h1><?php echo Yii::t('common', 'seconnecter') ?></h1>


<p><?php echo Yii::t('common', 'identifyYou') ?></p>
<table>
    <tr>
        <td>
            <div class="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'login-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                ));
                ?>

                <p class="note"><?php echo Yii::t('common', 'ChampsObligatoires'); ?></p>

                <div class="row">
                    <?php echo $form->labelEx($model, 'username'); ?>
                    <?php echo $form->textField($model, 'username'); ?>
                    <?php echo $form->error($model, 'username'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'password'); ?>
                    <?php echo $form->passwordField($model, 'password'); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>

                <div class="row rememberMe">
                    <?php echo $form->checkBox($model, 'rememberMe'); ?>
                    <?php echo $form->label($model, 'rememberMe'); ?>
                    <?php echo $form->error($model, 'rememberMe'); ?>
                </div>

                <div class="row buttons">
                    <?php echo CHtml::submitButton(Yii::t('common', 'seconnecter')); ?>
                </div>

                <?php
                $this->endWidget();

                echo CHtml::link(Yii::t('common', 'forgotedPwd'), array_merge(array("site/recoverPwd"), isset($_GET['layout']) ? array('layout' => $_GET['layout']) : array()));
                ?>


            </div><!-- form -->
        </td>
        <td>
            <div align='center'>
                <?php echo Yii::t('common', 'noAccount') ?><br><br>
                <?php
                echo CHtml::button(Yii::t('common', 'subscribe'), array(
                    'submit' => array_merge(array("site/subscribe"), isset($_GET['layout']) ? array('layout' => $_GET['layout']) : array())
                ));
                ?>
            </div>
        </td>
    </tr>
</table>


