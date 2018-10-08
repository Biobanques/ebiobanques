<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>


    <div class="row">
        <div class="col-lg-6">
            <?php echo $form->label($model, 'username'); ?>
            <?php echo $form->textField($model, 'username'); ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6">
            <?php echo $form->label($model, 'email'); ?>
            <?php echo $form->textField($model, 'email'); ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6">
            <?php echo $form->label($model, 'biobank_name'); ?>
            <?php echo $form->textField($model, 'biobank_name'); ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6">
            <?php echo $form->label($model, 'biobank_id'); ?>
            <?php echo $form->textField($model, 'biobank_id'); ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-5">
        <?php echo $form->label($model, 'connectionDate'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'connectionDate_from',
            'options' => array(
                'dateFormat' => 'dd-mm-yy'
            )
        ));
        ?>
        </div>
        <div class="col-lg-6">
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'connectionDate_to',
            'options' => array(
                'dateFormat' => 'dd-mm-yy'
            )
        ));
        ?>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('common','search'), ['id' => 'searchUserButton']); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->