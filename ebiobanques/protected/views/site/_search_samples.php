<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
    ));
    ?>

    <table>
        <tr>
            <td>
                <?php echo $form->label($model, 'biobank_id'); ?>
                <?php
                if ($this->layout == '//layouts/vitrine_layout') {
                    $biobank = $_SESSION['vitrine']['biobank'];
                    echo $form->dropDownList($model, 'biobank_id', array($biobank->id => $biobank->identifier));
                } else {
                    $biobank = new Biobank;
                    echo $form->dropDownList($model, 'biobank_id', $biobank->getArrayBiobanks(), array('prompt' => '----', 'style' => 'width:145px'));
                }
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
                <?php echo $form->dropDownList($model, 'gender', $model->getArrayGender(), array('prompt' => '----', 'style' => 'width:145px')); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $form->label($model, 'id_sample'); ?>
                <?php echo $form->textField($model, 'id_sample', array('size' => 10, 'maxlength' => 20)); ?>
            </td>
            <td>
                <?php echo $form->label($model, 'consent'); ?>
                <?php echo $form->dropDownList($model, 'consent', $model->getArrayConsent(), array('prompt' => '----', 'style' => 'width:145px')); ?>
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

            <td>
                <?php echo CHtml::label(Biobank::model()->getAttributeLabel('collection_id'), 'collection_id') ?>
                <?php echo CHtml::textArea('collection_id', '', array('cols' => 18)); ?>
            </td><td rowspan="2" colspan ="2">
                <?php
                $this->renderPartial('/site/_help_message', array('title' => 'Conseils pour la recherche par collection', 'content' => 'Séparez les expressions recherchées par des virgules.'));
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::label(Biobank::model()->getAttributeLabel('collection_name'), 'collection_name'); ?>
                <?php echo CHtml::textArea('collection_name', '', array('cols' => 18)); ?>
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
        <?php echo CHtml::submitButton(Yii::t('common', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->