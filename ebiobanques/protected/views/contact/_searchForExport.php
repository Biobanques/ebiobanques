<?php
/* @var $this ContactController */
/* @var $model Contact */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.TbActiveForm', array(
        // 'action' => Yii::app()->createUrl($this->route),
        'method' => 'post',
    ));
    ?>

    <div style="display:inline-block; vertical-align: top">
        <?php echo $form->labelEx($model, 'biobank_id'); ?>
        <?php echo $form->dropDownList($model, 'biobank_id', $biobanks, array('prompt' => 'Toutes les biobanques')); ?>

        <div >
            <?php echo $form->label($model, 'last_name'); ?>
            <?php echo $form->textField($model, 'last_name', array('size' => 20, 'maxlength' => 250)); ?>
        </div>


        <div >
            <?php echo $form->label($model, 'ville'); ?>

            <?php echo $form->dropDownList($model, 'ville', $cities, array('prompt' => 'Toutes les villes')); ?>
            <?php echo $form->label($model, 'pays'); ?>

            <?php echo $form->dropDownList($model, 'pays', $countries, array('prompt' => 'Tous les pays')); ?>



        </div>
    </div>



    <div class='wide form'  style="display:inline-block">



        <?php //echo $form->checkBoxList($model, 'profils', array('resp' => 'Responsable', 'resp_adj' => 'Responsable adjoint', 'resp_op' => 'Responsable opérationnel', 'resp_qual' => 'Responsable qualité', 'nonAssigned' => 'Pas de biobanque assignée')); ?>
        <?php echo CHtml::ActiveCheckBoxList($model, 'profils', array('resp' => 'Responsable', 'resp_adj' => 'Responsable adjoint', 'resp_op' => 'Responsable opérationnel', 'resp_qual' => 'Responsable qualité', 'nonAssigned' => 'Pas de biobanque assignée'), array('checkAll' => 'Tous les profils', 'template' => '{label} {input}', 'separator' => '<br><br>')); ?>
    </div>




    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->