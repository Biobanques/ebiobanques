<?php
/*
 * Simplified create view
 * @since 1.8
 *
 */
Yii::app()->clientscript->registerCssFile(Yii::app()->baseUrl . '/protected/extensions/bootstrap/assets/css/bootstrap.css');
Yii::app()->clientscript->registerScriptFile(Yii::app()->baseUrl . '/protected/extensions/bootstrap/assets/js/bootstrap.js');

Yii::app()->clientscript->registerScript("popupScript", "$(document).ready(function(){
		$('.helpedInput').popover({
                html:true,
                trigger: \"hover\" });
});"
);
/* @var $biobank Biobank */
?>
<h1><?php echo Yii::t('common', 'biobank.createTitle') ?></h1>

<div class='form'>
    <?php
    /* @var $form CactiveForm */
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'biobank-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    
    
    $logo = new Logo('biobank');
    ?>

    <div class="row">
    <?php echo $form->labelEx($logo, 'filename'); ?>
    <?php echo $form->fileField($logo, 'filename'); ?>
    <?php echo $form->error($logo, 'filename'); ?>
    </div>
    
    
    <p class="note"><?php echo Yii::t('common', 'ChampsObligatoires'); ?></p>
    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_1'); ?></div>
    
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($model, 'acronym'); ?>
            <?php
            echo $form->textField($model, 'acronym', CommonDisplayTools::getHelpBox('biobank.acronym', 'helpAcronymContent', $this));
            ?>
            <?php echo $form->error($model, 'acronym'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php
            echo $form->textField($model, 'name', CommonDisplayTools::getHelpBox('biobank.name', 'helpNameContent', $this));
            ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>
    </div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($model, 'website'); ?>
            <?php
            echo $form->textField($model, 'website', CommonDisplayTools::getHelpBox('biobank.website', 'helpWebsiteContent', $this));
            ?>
            <?php echo $form->error($model, 'website'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->labelEx($model, 'identifier'); ?>
            <?php
            echo $form->textField($model, 'identifier', CommonDisplayTools::getHelpBox('biobank.identifier', 'helpidentifierContent', $this));
            ?>
            <?php echo $form->error($model, 'identifier'); ?>
        </div>
    </div>
    <div class='col-2-row'>
        <?php echo $form->label($model, 'presentation'); ?>
        <?php
        echo $form->textArea($model, 'presentation', array('style' => 'width: 97%; height: 160px;'), CommonDisplayTools::getHelpBox('biobank.presentation', 'helpPresentationContent', $this));
        ?>
        <?php echo $form->error($model, 'presentation'); ?>
    </div>
    <div class='col-2-row'>
        <?php echo $form->label($model, 'presentation_en'); ?>
        <?php
        echo $form->textArea($model, 'presentation_en', array('style' => 'width: 97%; height: 160px;'), CommonDisplayTools::getHelpBox('biobank.presentation_en', 'helpPresentationEnContent', $this));
        ?>
        <?php echo $form->error($model, 'presentation_en'); ?>
    </div>

    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_quality'); ?></div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($model, 'cert_ISO9001'); ?>
            <?php echo $form->dropDownList($model, 'cert_ISO9001', $model->getCertificationOptions(), ['prompt' => Yii::t('common', 'undefined')]); ?>
            <?php echo $form->error($model, 'cert_ISO9001'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($model, 'cert_NFS96900'); ?>
            <?php echo $form->dropDownList($model, 'cert_NFS96900', $model->getCertificationOptions(), ['prompt' => Yii::t('common', 'undefined')]); ?>
            <?php echo $form->error($model, 'cert_NFS96900'); ?>
        </div>
    </div>
    <div class='col-2-row'>
        <?php echo $form->label($model, 'cert_autres'); ?>
        <?php echo $form->textField($model, 'cert_autres', CommonDisplayTools::getHelpBox('biobank.cert_autres', 'help_others_certifications', $this)); ?>
        <?php echo $form->error($model, 'cert_autres'); ?>
    </div>
    <div class = 'help help-title' style = "clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_2');
        ?></div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->labelEx($model->address, 'street'); ?>
            <?php echo $form->textField($model->address, 'street'); ?>
            <?php echo $form->error($model->address, 'street'); ?>
        </div>

        <div class='cols2'>
            <?php echo $form->labelEx($model->address, 'zip'); ?>
            <?php echo $form->textField($model->address, 'zip'); ?>
            <?php echo $form->error($model->address, 'zip'); ?>
        </div>
    </div>

    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->labelEx($model->address, 'city'); ?>
            <?php echo $form->textField($model->address, 'city'); ?>
            <?php echo $form->error($model->address, 'city'); ?>
        </div>

        <div class='cols2'>
            <?php echo $form->labelEx($model->address, 'country'); ?>
            <?php echo $form->dropDownList($model->address, 'country', CommonTools::getArrayCountriesSortedUnique(), ($model->isNewRecord ? array('options' => array('fr' => array('selected' => true))) : "")); ?>
            <?php echo $form->error($model->address, 'country'); ?>
        </div>
    </div>



    <?php
    $resps = [
        'contact_resp',
        'responsable_adj',
        'responsable_op',
        'responsable_qual',
    ];
    foreach ($resps as $resp) {
        ?>

        <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_' . $resp); ?></div>
        <div class='col-2-row'>
            <div class='cols2'>
                <?php echo $form->labelEx($model->$resp, 'lastName'); ?>
                <?php echo $form->textField($model->$resp, 'lastName'); ?>
                <?php echo $form->error($model->$resp, 'lastName'); ?>
            </div>

            <div class='cols2'>
                <?php echo $form->labelEx($model->$resp, 'firstName'); ?>
                <?php echo $form->textField($model->$resp, 'firstName'); ?>
                <?php echo $form->error($model->$resp, 'firstName'); ?>
            </div>

        </div>
        <div class='col-2-row'>
            <div class='cols2'>
                <?php echo $form->labelEx($model->$resp, 'email'); ?>
                <?php
                echo $form->textField($model->$resp, 'email', CommonDisplayTools::getHelpBox('biobank.email', 'helpEmailContent', $this));
                ?>
                <?php echo $form->error($model->$resp, 'email'); ?>
            </div>

            <div class='cols2'>
                <?php echo $form->labelEx($model->$resp, 'direct_phone'); ?>
                <?php
                echo $form->textField($model->$resp, 'direct_phone', CommonDisplayTools::getHelpBox('phone', 'helpPhoneContent', $this));
                ?>
                <?php echo $form->error($model->$resp, 'direct_phone'); ?>
            </div>
        </div>

    <?php } ?>


    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_4'); ?></div>
    <div class='col-2-row'>


        <?php echo CHtml::label(Yii::t('common', 'biobank.material_types'), false); ?>

        <?php
        foreach ($model->getAttributesMaterial() as $type) {
            echo '<div style="display: inline-block;float:left;width:30%;">';
            echo $form->checkBox($model, $type, ['value' => 'TRUE', 'uncheckValue' => 'FALSE', 'style' => 'margin-top:10px;margin-bottom:10px;margin-right:5px']);
            echo $form->label($model, $type, ['style' => 'display:inline-block']);
            echo '</div>';
        }
        ?>

    </div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($model, 'nb_total_samples'); ?>
            <?php echo $form->error($model, 'nb_total_samples'); ?>
            <?php
            echo $form->textField($model, 'nb_total_samples', CommonDisplayTools::getHelpBox('biobank.nb_total_samples', 'help_nb_total_samplesContent', $this));
            ?>

        </div>
    </div>
    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_keywords'); ?></div>
    <div class='col-2-row'>
    </div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($model, 'keywords_MeSH'); ?>
            <?php
            echo $form->textArea($model, 'keywords_MeSH', CommonDisplayTools::getHelpBox('biobank.keywords_MeSH', 'help_keywords_MeSHContent', $this));
            ?>
            <?php echo $form->error($model, 'keywords_MeSH'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($model, 'keywords_MeSH_fr'); ?>
            <?php
            echo $form->textArea($model, 'keywords_MeSH_fr', CommonDisplayTools::getHelpBox('biobank.keywords_MeSH_fr', 'help_keywords_MeSHFRContent', $this));
            ?>
            <?php echo $form->error($model, 'keywords_MeSH_fr'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($model, 'pathologies_en'); ?>
            <?php
            echo $form->textArea($model, 'pathologies_en', CommonDisplayTools::getHelpBox('biobank.pathologies_en', 'help_pathologiesenContent', $this));
            ?>
            <?php echo $form->error($model, 'pathologies_en'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($model, 'pathologies'); ?>
            <?php
            echo $form->textArea($model, 'pathologies', CommonDisplayTools::getHelpBox('biobank.pathologies', 'help_pathologiesContent', $this));
            ?>
            <?php echo $form->error($model, 'pathologies'); ?>
        </div>

        <div class='cols2'>
            <?php echo $form->labelEx($model, 'diagnosis_available'); ?>
            <?php
            echo $form->textArea($model, 'diagnosis_available', CommonDisplayTools::getHelpBox('biobank.diagnosis_available', 'help_diagnosis_availableContent', $this));
            ?>
            <?php echo $form->error($model, 'diagnosis_available'); ?>
        </div>
    </div>
    <div class='col-2-row'>
         <?php echo CHtml::resetButton('Cancel', array('id' => 'resetButton')); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save') ?>
    </div>
    <?php
    $this->endWidget();
    ?>
</div>