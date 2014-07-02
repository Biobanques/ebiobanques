<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <table>
        <tr>
            <td>
                <?php echo $form->label($model, 'biobank_id'); ?>
                <?php
                $biobank = new Biobank;
                echo $form->dropDownList($model, 'biobank_id', $biobank->getArrayBiobank($biobank_id));
                ?>
            </td>
            <td>
<?php echo $form->label($model, 'field_age_min'); ?>
                <?php echo $form->textField($model, 'field_age_min', array('size' => 10, 'maxlength' => 3)); ?>
            </td>
            <td>
<?php echo $form->label($model, 'storage_conditions'); ?>
<?php echo $form->dropDownList($model, 'storage_conditions', $model->getArrayStorage(), array('prompt' => '----')); ?>
            </td>
        </tr>
        <tr>
            <td>
<?php echo $form->label($model, 'id_depositor'); ?>
                <?php echo $form->textField($model, 'id_depositor', array('size' => 10, 'maxlength' => 20)); ?>
            </td>
            <td>
<?php echo $form->label($model, 'field_age_max'); ?>
                <?php echo $form->textField($model, 'field_age_max', array('size' => 10, 'maxlength' => 3)); ?>
            </td>
            <td>
<?php echo $form->label($model, 'gender'); ?>
<?php echo $form->dropDownList($model, 'gender', $model->getArrayGender(), array('prompt' => '----')); ?>
            </td>
        </tr>
        <tr>
            <td>
<?php echo $form->label($model, 'id_sample'); ?>
                <?php echo $form->textField($model, 'id_sample', array('size' => 10, 'maxlength' => 20)); ?>
            </td>
            <td>
<?php echo $form->label($model, 'consent'); ?>
                <?php echo $form->dropDownList($model, 'consent', $model->getArrayConsent(), array('prompt' => '----')); ?>
            </td>
            <td>
<?php echo $form->label($model, 'max_delay_delivery'); ?>
<?php echo $form->textField($model, 'max_delay_delivery', array('size' => 10, 'maxlength' => 2)); ?>
            </td>
        </tr>
        <tr>


        </tr>
        <tr>
            <td>
<?php echo $form->label($model, 'detail_treatment'); ?>
                <?php echo $form->textField($model, 'detail_treatment', array('size' => 10, 'maxlength' => 20)); ?>
            </td>
            <td>
<?php echo $form->label($model, 'disease_outcome'); ?>
                <?php echo $form->textField($model, 'disease_outcome', array('size' => 10, 'maxlength' => 20)); ?>
            </td>
            <td>
<?php echo $form->label($model, 'tumor_diagnosis'); ?>
<?php echo $form->textField($model, 'tumor_diagnosis', array('size' => 10, 'maxlength' => 20)); ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
<?php echo $form->label($model, 'field_notes'); ?>
<?php echo $form->textField($model, 'field_notes', array('size' => 60, 'maxlength' => 60)); ?>
            </td>
        </tr>
    </table>
    <div class="row buttons">
    <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->