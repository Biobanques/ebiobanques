<?php
/* @var $this DemandeController */
/* @var $model Demande */
/* @var $form CActiveForm */

//
//Yii::app()->clientScript->registerScript('selectDropDown', "
//       $('body select').msDropDown();
//        ");
//
?>
<div class="form">
    <?php
    // aqui empieza el formulario
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'biobank_manUploaded-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'text/html', 'accept-charset' => "UTF-8"),
    ));
    ?>

    <?php echo $form->errorSummary($biobankIdentifier); ?>
    <div class="row" >



        <?php
        $criteria = new EMongoCriteria;
        $criteria->sort('identifier', EMongoCriteria::SORT_ASC);
        echo $form->dropDownList($biobankIdentifier, 'identifier', CHtml::listData(Biobank::model()->findAll($criteria), 'identifier', 'identifierAndName'), array('empty' => 'select brif code'));
        /* 'ajax'=> array('type'=>'POST',
          // 'dataType'=>'json',
          'data'=> array('identifier'=>'js:this.value'),
          'url'=> CController::createUrl('uploadForm/uploadAll'),//$this->createUrl('uploadForm/uploadAll')
          //'update'=> '#identifier_id',
          'update'=> CHtml::activeId($model, 'identifier')
          //'success'=> 'function(data){if (data == null)}'
          ))); */
        ?>
        <?php echo $form->error($biobankIdentifier, 'identifier'); ?>
    </div>





    <div class="row buttons">
        <?php echo CHtml::submitButton('Rechercher'); ?>
    </div>

    <?php $this->endWidget(); //aki terminalario   ?>

</div>
<!-- form -->





<!-- deuxieme formulaire-->

<div class="form">
    <?php
    // aki empieza el formulario 2
    $form2 = $this->beginWidget('CActiveForm', array(
        'id' => 'biobank_manUpload-form2',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'accept-charset' => "UTF-8"),
    ));
    ?>

    <?php echo $form2->errorSummary($model); ?>
    <div class="row" >

        <?php
//        $logo = new Logo('biobank');
        ?>

        <!--        <div class="row">
        <?php //echo $form2->labelEx($logo, 'filename'); ?>
        <?php //echo $form2->fileField($logo, 'filename'); ?>
        <?php //echo $form2->error($logo, 'filename');  ?>
                </div>-->


        <?php
        // $criteria = new EMongoCriteria;
        //  $criteria->sort('identifier', EMongoCriteria::SORT_ASC);
        /* echo $form2->dropDownList($model, 'id', CHtml::listData(Biobank::model()->findAll($criteria), 'id', 'idAndName'),
          array('empty' => 'select brif code')); */
        ?>
        <?php //echo $form2->error($model, 'identifier');  ?>
    </div>
    <div class="row" style="display: inline-block">

        <?php echo $form2->hiddenField($model, 'identifier'); ?>

        <?php echo $form2->labelEx($model, 'presentation'); ?>
        <?php echo $form2->textArea($model, 'presentation', array('style' => "height:200px; width:450px")); ?>
        <?php echo $form2->error($model, 'presentation'); ?>

    </div>
    <div class="row" style="display: inline-block">
        <?php echo $form2->labelEx($model, 'thematiques'); ?>
        <?php echo $form2->textArea($model, 'thematiques', array('style' => "height:200px; width:450px")); ?>
        <?php echo $form2->error($model, 'thematiques'); ?>
    </div>
    <div class="row" style="display: inline-block">
        <?php echo $form2->labelEx($model, 'projetRecherche'); ?>
        <?php echo $form2->textArea($model, 'projetRecherche', array('style' => "height:200px; width:450px")); ?>
        <?php echo $form2->error($model, 'projetRecherche'); ?>
    </div>
    <div class="row" style="display: inline-block">
        <?php echo $form2->labelEx($model, 'publications'); ?>
        <?php echo $form2->textArea($model, 'publications', array('style' => "height:200px; width:450px")); ?>
        <?php echo $form2->error($model, 'publications'); ?>
    </div>
    <div class="row" style="display: inline-block">
        <?php echo $form2->labelEx($model, 'reseaux'); ?>
        <?php echo $form2->textArea($model, 'reseaux', array('style' => "height:200px; width:450px")); ?>
        <?php echo $form2->error($model, 'reseaux'); ?>
    </div>
    <div class="row" style="display: inline-block">
        <?php echo $form2->labelEx($model, 'qualite'); ?>
        <?php echo $form2->textArea($model, 'qualite', array('style' => "height:200px; width:450px")); ?>
        <?php echo $form2->error($model, 'qualite'); ?>


    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Mettre à jour'); ?>
    </div>

    <?php $this->endWidget(); //aki terminalario   ?>

</div>