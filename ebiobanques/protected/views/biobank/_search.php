<?php
/* @var $this BiobankController */
/* @var $model Biobank */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 20, 'maxlength' => 45)); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'identifier'); ?>
        <?php echo $form->textField($model, 'identifier', array('size' => 20, 'maxlength' => 45)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'collection_name'); ?>
        <?php echo $form->textField($model, 'collection_name', array('size' => 20, 'maxlength' => 45)); ?>
    </div>
    <!--<div class="row">-->
    <?php //echo $form->label($model, 'qualityCombinate'); ?>
    <?php //echo $form->textField($model, 'qualityCombinate', array('size' => 20, 'maxlength' => 45)); ?>
    <!--</div>-->


    <div class="row" style='display: block'>
        <?php echo $form->label($model, 'cert_ISO9001'); ?>
        <?php // echo $form->textField($model, 'cert_ISO9001', array('size' => 20, 'maxlength' => 45)); ?>
        <div style='float:left;width: 25%;'>  <?php echo $form->checkBoxList($model, 'cert_ISO9001', array('OUI' => 'Oui', 'NON' => 'Non', 'EN COURS' => 'En cours')); ?>

        </div>
    </div>
    <div class="row" style='display: block'>
        <?php echo $form->label($model, 'cert_NFS96900'); ?>
        <?php // echo $form->textField($model, 'cert_ISO9001', array('size' => 20, 'maxlength' => 45)); ?>
        <div style='float:left;width: 25%;'>  <?php echo $form->checkBoxList($model, 'cert_NFS96900', array('OUI' => 'Oui', 'NON' => 'Non', 'EN COURS' => 'En cours')); ?>

        </div>
    </div>


    <div class="row">
        <?php echo $form->Label($model->address, 'city'); ?>
        <?php echo $form->dropDownList($model->address, 'city', $model->address->getActiveListOfCities(), array('prompt' => '----', 'style' => "width:33%")); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model->address, 'country'); ?>
        <?php echo $form->dropDownList($model->address, 'country', $model->address->getActiveListOfCountries(), array('prompt' => '----', 'style' => "width:33%")); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'contact_id'); ?>
        <?php echo $form->dropDownList($model, 'contact_id', $model->getArrayActiveContact(), array('prompt' => '----', 'style' => "width:33%")); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'responsable_adj'); ?>
        <?php echo $form->dropDownList($model->responsable_adj, 'FullNameForDDList', $model->getRespDropdownList('responsable_adj'), array('prompt' => '----', 'style' => "width:33%")); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'responsable_op'); ?>
        <?php echo $form->dropDownList($model->responsable_op, 'FullNameForDDList', $model->getRespDropdownList('responsable_op'), array('prompt' => '----', 'style' => "width:33%")); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'responsable_qual'); ?>
        <?php echo $form->dropDownList($model->responsable_qual, 'FullNameForDDList', $model->getRespDropdownList('responsable_qual'), array('prompt' => '----', 'style' => "width:33%")); ?>
    </div>


    <!--<div class="row" >-->

    <?php //echo $form->label($model, 'textSearchField'); ?>
    <!--<div>-->
    <?php
//            echo $form->dropDownList($model, 'textSearchField', [
//                'presentation' => 'Présentation',
//                'thematiques' => 'Thematiques',
//                'projetRecherche' => 'Projets de recherche',
//                'publications' => 'Publications',
//                'reseaux' => 'Réseaux',
//                    ], array('prompt' => '----', 'style' => "width:33%;vertical-align:top"));
    ?>

    <?php //echo $form->textArea($model, 'textSearchValue', array('style' => "height:80px; width:200px")); ?>
    <?php //echo $form->error($model, 'textSearchValue'); ?>
    <!--</div>-->
    <!--</div>-->
    <div class="row" >

        <?php echo $form->label($model, 'presentation'); ?>

        <?php echo $form->textArea($model, 'presentation', array('style' => "height:80px; width:200px")); ?>
        <?php echo $form->error($model, 'presentation'); ?>

    </div>
    <div class="row" >

        <?php echo $form->label($model, 'projetRecherche'); ?>


        <?php echo $form->textArea($model, 'projetRecherche', array('style' => "height:80px; width:200px")); ?>
        <?php echo $form->error($model, 'projetRecherche'); ?>

    </div>
    <div class="row" >

        <?php echo $form->label($model, 'thematiques'); ?>


        <?php echo $form->textArea($model, 'thematiques', array('style' => "height:80px; width:200px")); ?>
        <?php echo $form->error($model, 'thematiques'); ?>

    </div>
    <div class="row" >

        <?php echo $form->label($model, 'reseaux'); ?>


        <?php echo $form->textArea($model, 'reseaux', array('style' => "height:80px; width:200px")); ?>
        <?php echo $form->error($model, 'reseaux'); ?>

    </div>
    <div class="row" >

        <?php echo $form->label($model, 'publications'); ?>


        <?php echo $form->textArea($model, 'publications', array('style' => "height:80px; width:200px")); ?>
        <?php echo $form->error($model, 'publications'); ?>

    </div>



    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>

        <?php echo CHtml::resetButton('Reset'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->