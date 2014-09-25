<div style="padding: 5px;border:1px solid blueviolet;background-color: #D8E4F1;">
    <img src="<?php echo Yii::app()->request->baseUrl . '/images/'; ?>information.gif"/><div style="display: inline;margin-left: 5px;"><b><?php echo Yii::t('sample', 'helpSearchTitle') ?></b></div>
    <div style="margin-left: 5px;">

        <?php
        echo Yii::t('sample', 'helpSearchContent');
        ?>
    </div>
</div>

<div class = "wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route, $_GET),
        'method' => 'post',
    ));
    ?>

    <div>
    </div>
    <div class="row">
        <?php echo $form->label($smartForm, 'expression'); ?>
        <?php echo $form->textField($smartForm, 'keywords', array('style' => 'width:400px',)); ?>
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- smart search-form -->