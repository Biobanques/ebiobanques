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


        <div class="radio_button_row">
            Sélectionner votre mode d'import de données : <br>
            <?php
            $importType = array('add' => 'Ajout des échantillons à ceux existants.', 'replace' => 'Remplacement des échantillons existants par ceux importés.');

            echo $form->radioButtonList($model, 'addOrReplace', $importType, array('separator' => ' ', 'container' => 'div',));
            ?>
        </div>
        <div class="row">
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