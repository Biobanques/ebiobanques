<?php
/*
 * Simplified update view
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
<h1><?php echo Yii::t('biobank', 'updateTitle', ['{name}' => $biobank->name]) ?></h1>
<div class='form'>
    <?php
    /* @var $form CactiveForm */
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'biobank-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('biobank', 'form_part_1'); ?></div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'acronym'); ?>
            <?php
            echo $form->textField($biobank, 'acronym', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
                $this->renderPartial('/site/_help_message', array(
                    'title' => Yii::t('biobank', 'acronym'),
                    'content' => Yii::t('biobank', 'helpAcronymContent')
                        ), true
                )
            ]);
            ?>
            <?php echo $form->error($biobank, 'acronym'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'name'); ?>
            <?php
            echo $form->textField($biobank, 'name', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
                $this->renderPartial('/site/_help_message', array(
                    'title' => Yii::t('biobank', 'name'),
                    'content' => Yii::t('biobank', 'helpNameContent')
                        ), true
                )
            ]);
            ?>
            <?php echo $form->error($biobank, 'name'); ?>
        </div>
    </div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'website'); ?>
            <?php
            echo $form->textField($biobank, 'website', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
                $this->renderPartial('/site/_help_message', array(
                    'title' => Yii::t('biobank', 'website'),
                    'content' => Yii::t('biobank', 'helpWebsiteContent')
                        ), true
                )
            ]);
            ?>
            <?php echo $form->error($biobank, 'website'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'identifier'); ?>
            <?php
            echo $form->textField($biobank, 'identifier', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
                $this->renderPartial('/site/_help_message', array(
                    'title' => Yii::t('biobank', 'identifier'),
                    'content' => Yii::t('biobank', 'helpidentifierContent')
                        ), true
                )
            ]);
            ?>
            <?php echo $form->error($biobank, 'identifier'); ?>
        </div>
    </div>





    <div class='col-2-row'>

        <?php echo $form->label($biobank, 'presentation'); ?>
        <?php
        echo $form->textArea($biobank, 'presentation', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
            $this->renderPartial('/site/_help_message', array(
                'title' => Yii::t('biobank', 'presentation'),
                'content' => Yii::t('biobank', 'helpPresentationContent')
                    ), true
            )
        ]);
        ?>
        <?php echo $form->error($biobank, 'presentation'); ?>
    </div>
    <div class='col-2-row'>
        <?php echo $form->label($biobank, 'presentation_en'); ?>
        <?php
        echo $form->textArea($biobank, 'presentation_en', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
            $this->renderPartial('/site/_help_message', array(
                'title' => Yii::t('biobank', 'presentation_en'),
                'content' => Yii::t('biobank', 'helpPresentationEnContent')
                    ), true
            )
        ]);
        ?>
        <?php echo $form->error($biobank, 'presentation_en'); ?>
    </div>

    <div class = 'help help-title' style = "clear: both;margin-bottom: 15px"><?php echo Yii::t('biobank', 'form_part_2');
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


    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('biobank', 'form_part_3'); ?></div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($biobank->contact, 'last_name'); ?>
            <?php echo $form->textField($biobank->contact, 'last_name'); ?>
            <?php echo $form->error($biobank->contact, 'last_name'); ?>
        </div>

        <div class='cols2'>
            <?php echo $form->label($biobank->contact, 'first_name'); ?>
            <?php echo $form->textField($biobank->contact, 'first_name'); ?>
            <?php echo $form->error($biobank->contact, 'first_name'); ?>
        </div>


        <div class='cols2'>
            <?php echo $form->label($biobank->contact, 'email'); ?>
            <?php
            echo $form->textField($biobank->contact, 'email', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
                $this->renderPartial('/site/_help_message', array(
                    'title' => Yii::t('biobank', 'email'),
                    'content' => Yii::t('biobank', 'helpEmailContent')
                        ), true
                )
            ]);
            ?>
<?php echo $form->error($biobank->contact, 'email'); ?>
        </div>

        <div class='cols2'>
            <?php echo $form->label($biobank->contact, 'phone'); ?>
            <?php
            echo $form->textField($biobank->contact, 'phone', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
                $this->renderPartial('/site/_help_message', array(
                    'title' => Yii::t('biobank', 'phone'),
                    'content' => Yii::t('biobank', 'helpPhoneContent')
                        ), true
                )
            ]);
            ?>
            <?php echo $form->error($biobank->contact, 'phone'); ?>
        </div>
    </div>
    <?php
    $resps = [
        'responsable_adj',
        'responsable_op',
        'responsable_qual',
    ];
    foreach ($resps as $resp) {
        ?>

        <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('biobank', 'form_part_' . $resp); ?></div>
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
                echo $form->textField($biobank->$resp, 'email', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
                    $this->renderPartial('/site/_help_message', array(
                        'title' => Yii::t('biobank', 'email'),
                        'content' => Yii::t('biobank', 'helpEmailContent')
                            ), true
                    )
                ]);
                ?>
    <?php echo $form->error($biobank->$resp, 'email'); ?>
            </div>

            <div class='cols2'>
                <?php echo $form->label($biobank->$resp, 'direct_phone'); ?>
                <?php
                echo $form->textField($biobank->$resp, 'direct_phone', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
                    $this->renderPartial('/site/_help_message', array(
                        'title' => Yii::t('biobank', 'phone'),
                        'content' => Yii::t('biobank', 'helpPhoneContent')
                            ), true
                    )
                ]);
                ?>
    <?php echo $form->error($biobank->$resp, 'direct_phone'); ?>
            </div>
        </div>

<?php } ?>


    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('biobank', 'form_part_4'); ?></div>
    <div class='col-2-row'>

        <?php
        $attributes_material = [
            'materialStoredDNA',
            'materialStoredPlasma',
            'materialStoredSerum',
            'materialStoredUrine',
            'materialStoredSaliva',
            'materialStoredFaeces',
            'materialStoredRNA',
            'materialStoredBlood',
            'materialStoredTissueFrozen',
            'materialStoredTissueFFPE',
            'materialStoredImmortalizedCellLines',
            'materialTumoralTissue',
            'materialHealthyTissue',
            'materialLCR',
            'materialOther',
        ];
        ?>
        <?php echo CHtml::label(Yii::t('biobank', 'material_types'), false); ?>

        <?php
        foreach ($attributes_material as $type) {
            echo '<div style="display: inline-block;float:left;width:30%;">';
            echo $form->checkBox($biobank, $type, ['value' => 'TRUE', 'uncheckValue' => 'FALSE', 'style' => 'margin-top:10px;margin-bottom:10px;margin-right:5px']);
            echo $form->label($biobank, $type, ['style' => 'display:inline-block']);
            echo '</div>';
            //    echo $form->radioButtonList($biobank, $type['attributeName'], $type['value']);
        }
        ?>

    </div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'nb_total_samples'); ?>
            <?php
            echo $form->textField($biobank, 'nb_total_samples', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
                $this->renderPartial('/site/_help_message', array(
                    'title' => Yii::t('biobank', 'nb_total_samples'),
                    'content' => Yii::t('biobank', 'help_nb_total_samplesContent')
                        ), true
                )
            ]);
            ?>
<?php echo $form->error($biobank, 'name'); ?>
        </div>

    </div>
    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('biobank', 'form_part_keywords'); ?></div>
    <div class='col-2-row'>


    </div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'keywords_MeSH'); ?>
            <?php
            echo $form->textField($biobank, 'keywords_MeSH', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
                $this->renderPartial('/site/_help_message', array(
                    'title' => Yii::t('biobank', 'keywords_MeSH'),
                    'content' => Yii::t('biobank', 'help_keywords_MeSHContent')
                        ), true
                )
            ]);
            ?>
            <?php echo $form->error($biobank, 'name'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'diagnosis_available'); ?>
            <?php
            echo $form->textField($biobank, 'diagnosis_available', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
                $this->renderPartial('/site/_help_message', array(
                    'title' => Yii::t('biobank', 'diagnosis_available'),
                    'content' => Yii::t('biobank', 'help_diagnosis_availableContent')
                        ), true
                )
            ]);
            ?>
            <?php echo $form->error($biobank, 'diagnosis_available'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'pathologies'); ?>
            <?php
            echo $form->textField($biobank, 'pathologies', ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
                $this->renderPartial('/site/_help_message', array(
                    'title' => Yii::t('biobank', 'pathologies'),
                    'content' => Yii::t('biobank', 'help_pathologiesContent')
                        ), true
                )
            ]);
            ?>
<?php echo $form->error($biobank, 'name'); ?>
        </div>

    </div>
    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('biobank', 'form_part_quality'); ?></div>
    <div class='col-2-row'>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'cert_ISO9001'); ?>
<?php echo $form->dropDownList($biobank, 'cert_ISO9001', ['OUI' => 'Oui', 'NON' => 'NON', 'EN COURS' => 'En cours'], ['prompt' => Yii::t('common', 'undefined')]); ?>
            <?php echo $form->error($biobank, 'cert_ISO9001'); ?>
        </div>
        <div class='cols2'>
            <?php echo $form->label($biobank, 'cert_NFS96900'); ?>
<?php echo $form->dropDownList($biobank, 'cert_NFS96900', ['OUI' => 'Oui', 'NON' => 'Non', 'EN COURS' => 'En cours'], ['prompt' => Yii::t('common', 'undefined')]); ?>
<?php echo $form->error($biobank, 'cert_NFS96900'); ?>
        </div>
    </div>
    <div class='col-2-row'>
        <?php echo $form->label($biobank, 'cert_autres'); ?>
    <?php echo $form->textField($biobank, 'cert_autres'); ?>
    <?php echo $form->error($biobank, 'cert_autres'); ?>
    </div>
    <?php echo CHtml::submitButton('Mettre à jour') ?>
    <?php
    $this->endWidget();
    ?>

