<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
<?php echo $form->label($model, 'old_value'); ?>
<?php echo $form->textArea($model, 'old_value', array('rows' => 6, 'cols' => 50)); ?>
    </div>

    <div class="row">
<?php echo $form->label($model, 'new_value'); ?>
<?php echo $form->textArea($model, 'new_value', array('rows' => 6, 'cols' => 50)); ?>
    </div>

    <div class="row">
<?php echo $form->label($model, 'action'); ?>
<?php echo $form->dropDownList($model, 'action', $model->getActions(), array('prompt' => '---')); ?>
    </div>

    <div class="row">
<?php echo $form->label($model, 'model'); ?>
<?php echo $form->textField($model, 'model', array('size' => 60, 'maxlength' => 255)); ?>
    </div>

    <div class="row">
<?php echo $form->label($model, 'field'); ?>
<?php echo $form->textField($model, 'field', array('size' => 60, 'maxlength' => 64)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'stamp'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'stamp_from',
            'options' => array(
                'dateFormat' => 'dd-mm-yy'
            )
        ));
        ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'stamp_to',
            'options' => array(
                'dateFormat' => 'dd-mm-yy'
            )
        ));
        ?>
    </div>

    <div class="row">
<?php echo CHtml::label('nom', 'nom'); ?>
<?php echo CHtml::textField('nom'); ?>
    </div>

    <div class="row">
<?php echo CHtml::label('prenom', 'prenom'); ?>
<?php echo CHtml::textField('prenom'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->