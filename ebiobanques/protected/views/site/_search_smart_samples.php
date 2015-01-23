<?php
$this->renderPartial('/site/_help_message', array('title' => Yii::t('sample', 'helpSearchTitle'), 'content' => Yii::t('sample', 'helpSearchContent')));
?>
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