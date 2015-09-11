
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'SampleCollected-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note"><?php echo Yii::t('common', 'ChampsObligatoires'); ?></p>

    <?php echo $form->errorSummary($model); ?>
    <div style="float:left;width:95%;padding-left:5px;">

        <?php
        foreach ($model->attributes as $nameAtt => $valueAtt) {
            if ($nameAtt != "_id") {
                ?>
                <div style="float: left; width: 24%">
                    <?php echo $form->labelEx($model, $nameAtt); ?>
                    <?php echo $form->textField($model, $nameAtt, array('size' => 5, 'maxlength' => 45)); ?>
                    <?php echo $form->error($model, $nameAtt); ?>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->