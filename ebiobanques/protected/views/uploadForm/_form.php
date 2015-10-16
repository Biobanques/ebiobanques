<?php
/* @var $this DemandeController */
/* @var $model Demande */
/* @var $form CActiveForm */

//Yii::app()->clientScript->registerScript('selectDropDown', "
  //     $('body select').msDropDown();
    //    ");

Yii::app()->clientScript->registerScript('biobank_manUploaded-form', "
$('.search-button').change(function(){
	$('.-form').update('biobank_manUploaded-form',{
	data: $(this).serialize()
        });
	return false;
});
$('.search-form form').submit(function(){
$('#biobanks-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

");
?>
<div class="form">
    <?php 
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'biobank_manUploaded-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <?php echo $form->errorSummary($biobankIdentifier); ?>
    <div class="row" >

       

        <?php
        $criteria = new EMongoCriteria;
        $criteria->sort('identifier', EMongoCriteria::SORT_ASC);
        echo $form->dropDownList($biobankIdentifier, 'identifier', CHtml::listData(Biobank::model()->findAll($criteria), 'identifier', 'identifierAndName'), 
                array('empty' => 'select brif code',
                    'onchange'=>'javascript:click(this);')); /*'on change => 'myFonction()'*/
                     
                                               
        ?>      
  <?php echo $form->error($biobankIdentifier, 'identifier'); ?>
    </div>
    
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('rechercher'); ?>
    </div>
  

   

    <?php $this->endWidget(); ?> 

</div>
<!-- form -->





<!-- deuxieme formulaire-->

<div class="form">
    <?php 
    $form2 = $this->beginWidget('CActiveForm', array(
        'id' => 'biobank_manUpload-form2',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <?php echo $form2->errorSummary($model); ?>
    <div class="row" >

        <?php
       // $logo = new Logo('biobank');
        ?>
      <!--  <div class="row">
           <?php// echo $form2->labelEx($logo, 'filename'); ?>
           <?php //echo $form2->fileField($logo, 'filename'); ?>
           <?php //echo $form2->error($logo, 'filename'); ?>
        </div> -->

     
      
   <?php echo $form2->hiddenField($model, 'identifier'); ?>
      
    </div>
    <div clmss="row" style="display: inline-block">


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
          <?php echo CHtml::submitButton('Enregistrer'); ?>
    </div>

    <?php $this->endWidget();  ?> 

</div>