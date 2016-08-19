<?php
/* @var $this BiobankController */
/* @var $model Biobank */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table>
        <tr>
            <td>
                <?php echo $form->label($model, 'identifier'); ?>
                <?php echo $form->textField($model, 'identifier', array('size' => 30, 'maxlength' => 45)); ?>
            </td>

            <td>
                <?php echo $form->label($model, 'name'); ?>
                <?php echo $form->textField($model, 'name', array('size' => 30, 'maxlength' => 45)); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $form->label($model, 'collection_name'); ?>
                <?php echo $form->textField($model, 'collection_name', array('size' => 30, 'maxlength' => 45)); ?>
            </td>

            <td>
                <?php echo $form->label($model->address, 'city'); ?>
                <?php echo $form->textField($model->address, 'city', array('size' => 30, 'maxlength' => 45)); ?>
            </td>
        </tr>
         <tr>
            <td>
                <?php echo $form->label($model, 'diagnosis_available'); ?>
                <?php echo $form->textField($model, 'diagnosis_available', array('size' => 30, 'maxlength' => 45)); ?>
                <br> <?php echo Yii::t('common', 'icd_example');?>
            </td>

            <td>
                <?php echo $form->label($model, 'keywords_MeSH'); ?>
                <?php echo $form->textField($model, 'keywords_MeSH', array('size' => 30, 'maxlength' => 45)); ?>
            </td>
        </tr>
    </table>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('common', 'search')); ?>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- search-form -->