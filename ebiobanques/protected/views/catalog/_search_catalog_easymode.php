<?php
/* @var $this BiobankController */
/* @var $model Biobank */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'catalog-form',
        'enableAjaxValidation'=>false,
        'method'=>'get',
    ));
    ?>
    <table>
        <tr>
            <td>
                <?php echo $form->label($modelForm, 'keywords'); ?>
                
                <?php echo $form->textField($modelForm, 'keywords', array('size' => '100%', 'maxlength' => 300)); ?>
                
            </td>
        </tr>
        <tr><td>
            <i><?php echo Yii::t('help', 'helpCatalogSearch'); ?></i>
            </td></tr>
    </table>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('common', 'search')); ?>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- search-form -->
