<?php
/*
 * Simplified update view
 * @since 1.8
 *
 */
//Yii::app()->clientscript->registerCssFile(Yii::app()->baseUrl . '/protected/extensions/bootstrap/assets/css/bootstrap.css');
//Yii::app()->clientscript->registerScriptFile(Yii::app()->baseUrl . '/protected/extensions/bootstrap/assets/js/bootstrap.js');

Yii::app()->clientscript->registerScript("popupScript", "$(document).ready(function(){
		$('.helpedInput').popover({
                html:true,
                trigger: \"hover\" });
});"
);
/* @var $biobank Biobank */
?>
<h1><?php echo Yii::t('common', 'biobank.updateTitle', ['{name}' => $biobank->name]) ?></h1>
<div class='form'>
    <?php
    /* @var $form CactiveForm */
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'biobank-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>
    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_1'); ?></div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'acronym'); ?>
            <?php
            echo $form->textField($biobank, 'acronym', CommonDisplayTools::getHelpBox('biobank.acronym', 'helpAcronymContent', $this));
            ?>
            <?php echo $form->error($biobank, 'acronym'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'name'); ?>
            <?php
            echo $form->textField($biobank, 'name', CommonDisplayTools::getHelpBox('biobank.name', 'helpNameContent', $this));
            ?>
            <?php echo $form->error($biobank, 'name'); ?>
        </div>
    </div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'website'); ?>
            <?php
            echo $form->textField($biobank, 'website', CommonDisplayTools::getHelpBox('biobank.website', 'helpWebsiteContent', $this));
            ?>
            <?php echo $form->error($biobank, 'website'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'identifier'); ?>
            <?php
            echo $form->textField($biobank, 'identifier', CommonDisplayTools::getHelpBox('biobank.identifier', 'helpidentifierContent', $this));
            ?>
            <?php echo $form->error($biobank, 'identifier'); ?>
        </div>
    </div>
    
    <div class='col-2-row'>
        <?php echo $form->label($biobank, 'presentation'); ?>
        <?php
        echo $form->textArea($biobank, 'presentation', array('style' => 'width: 97%; height: 160px;'), CommonDisplayTools::getHelpBox('biobank.presentation', 'helpPresentationContent', $this));
        ?>
        <?php echo $form->error($biobank, 'presentation'); ?>
    </div>
    <div class='col-2-row'>
        <?php echo $form->label($biobank, 'presentation_en'); ?>
        <?php
        echo $form->textArea($biobank, 'presentation_en', array('style' => 'width: 97%; height: 160px;'), CommonDisplayTools::getHelpBox('biobank.presentation_en', 'helpPresentationEnContent', $this));
        ?>
        <?php echo $form->error($biobank, 'presentation_en'); ?>
    </div>

    <div class = 'help help-title' style = "clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_2');
        ?></div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($biobank->address, 'street'); ?>
            <?php echo $form->textField($biobank->address, 'street'); ?>
            <?php echo $form->error($biobank->address, 'street'); ?>
        </div>

        <div class='cols2'>
            <?php echo $form->label($biobank->address, 'zip'); ?>
            <?php echo $form->textField($biobank->address, 'zip'); ?>
            <?php echo $form->error($biobank->address, 'zip'); ?>
        </div>
    </div>

    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($biobank->address, 'city'); ?>
            <?php echo $form->textField($biobank->address, 'city'); ?>
            <?php echo $form->error($biobank->address, 'city'); ?>
        </div>

        <div class='cols2'>
            <?php echo $form->label($biobank->address, 'country'); ?>
            <?php echo $form->dropDownList($biobank->address, 'country', CommonTools::getArrayCountriesSorted(), ($biobank->isNewRecord ? array('options' => array('fr' => array('selected' => true))) : "")); ?>
            <?php echo $form->error($biobank->address, 'country'); ?>
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
                <?php echo $form->label($biobank->$resp, 'lastName'); ?>
                <?php echo $form->textField($biobank->$resp, 'lastName'); ?>
                <?php echo $form->error($biobank->$resp, 'lastName'); ?>
            </div>

            <div class='cols2'>
                <?php echo $form->label($biobank->$resp, 'firstName'); ?>
                <?php echo $form->textField($biobank->$resp, 'firstName'); ?>
                <?php echo $form->error($biobank->$resp, 'firstName'); ?>
            </div>

        </div>
        <div class='col-2-row'>
            <div class='cols2'>
                <?php echo $form->label($biobank->$resp, 'email'); ?>
                <?php
                echo $form->textField($biobank->$resp, 'email', CommonDisplayTools::getHelpBox('biobank.email', 'helpEmailContent', $this));
                ?>
                <?php echo $form->error($biobank->$resp, 'email'); ?>
            </div>

            <div class='cols2'>
                <?php echo $form->label($biobank->$resp, 'direct_phone'); ?>
                <?php
                echo $form->textField($biobank->$resp, 'direct_phone', CommonDisplayTools::getHelpBox('phone', 'helpPhoneContent', $this));
                ?>
                <?php echo $form->error($biobank->$resp, 'direct_phone'); ?>
            </div>
        </div>

    <?php } ?>


    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_4'); ?></div>
    <div class='col-2-row'>


        <?php echo CHtml::label(Yii::t('common', 'biobank.material_types'), false); ?>

        <?php
        foreach ($biobank->getAttributesMaterial() as $type) {
            echo '<div style="display: inline-block;float:left;width:30%;">';
            echo $form->checkBox($biobank, $type, ['value' => 'TRUE', 'uncheckValue' => 'FALSE', 'style' => 'margin-top:10px;margin-bottom:10px;margin-right:5px']);
            echo $form->label($biobank, $type, ['style' => 'display:inline-block']);
            echo '</div>';
        }
        ?>

    </div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'nb_total_samples'); ?>
            <?php echo $form->error($biobank, 'nb_total_samples'); ?>
            <?php
            echo $form->textField($biobank, 'nb_total_samples', CommonDisplayTools::getHelpBox('biobank.nb_total_samples', 'help_nb_total_samplesContent', $this));
            ?>

        </div>
    </div>
    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_keywords'); ?></div>
    <div class='col-2-row'>
    </div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'keywords_MeSH'); ?>
            <?php
            echo $form->textArea($biobank, 'keywords_MeSH', CommonDisplayTools::getHelpBox('biobank.keywords_MeSH', 'help_keywords_MeSHContent', $this));
            ?>
            <?php echo $form->error($biobank, 'keywords_MeSH'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'keywords_MeSH_fr'); ?>
            <?php
            echo $form->textArea($biobank, 'keywords_MeSH_fr', CommonDisplayTools::getHelpBox('biobank.keywords_MeSH_fr', 'help_keywords_MeSHFRContent', $this));
            ?>
            <?php echo $form->error($biobank, 'keywords_MeSH_fr'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'pathologies_en'); ?>
            <?php
            echo $form->textArea($biobank, 'pathologies_en', CommonDisplayTools::getHelpBox('biobank.pathologies_en', 'help_pathologiesenContent', $this));
            ?>
            <?php echo $form->error($biobank, 'pathologies_en'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'pathologies'); ?>
            <?php
            echo $form->textArea($biobank, 'pathologies', CommonDisplayTools::getHelpBox('biobank.pathologies', 'help_pathologiesContent', $this));
            ?>
            <?php echo $form->error($biobank, 'pathologies'); ?>
        </div>

        <div class='cols2'>
            <?php echo $form->label($biobank, 'diagnosis_available'); ?>
            <?php
            echo $form->textArea($biobank, 'diagnosis_available', CommonDisplayTools::getHelpBox('biobank.diagnosis_available', 'help_diagnosis_availableContent', $this));
            ?>
            <?php echo $form->error($biobank, 'diagnosis_available'); ?>
        </div>
        
        <div class='cols2'>
            <?php echo $form->label($biobank, 'snomed_ct'); ?>
            <?php
            echo $form->textArea($biobank, 'snomed_ct', CommonDisplayTools::getHelpBox('biobank.snomed_ct', 'help_snomed_ctContent', $this));
            ?>
            <?php echo $form->error($biobank, 'snomed_ct'); ?>
        </div>
    </div>
    
    
    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_quality'); ?></div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'cert_ISO9001'); ?>
            <?php echo $form->dropDownList($biobank, 'cert_ISO9001', $biobank->getCertificationOptions(), ['prompt' => Yii::t('common', 'undefined')]); ?>
            <?php echo $form->error($biobank, 'cert_ISO9001'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'cert_NFS96900'); ?>
            <?php echo $form->dropDownList($biobank, 'cert_NFS96900', $biobank->getCertificationOptions(), ['prompt' => Yii::t('common', 'undefined')]); ?>
            <?php echo $form->error($biobank, 'cert_NFS96900'); ?>
        </div>
    </div>
    <div class='col-2-row'>
        <?php echo $form->label($biobank, 'cert_autres'); ?>
        <?php echo $form->textField($biobank, 'cert_autres', CommonDisplayTools::getHelpBox('biobank.cert_autres', 'help_others_certifications', $this)); ?>
        <?php echo $form->error($biobank, 'cert_autres'); ?>
    </div>
    
    <?php echo CHtml::submitButton(Yii::t('common','updateBtn')) ?>
    <?php error_reporting(E_ALL); ?>
    <?php
    $this->endWidget();
    ?>
</div>


