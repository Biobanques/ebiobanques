<?php
/* @var $this DemandeController */
/* @var $model Demande */
/* @var $form CActiveForm */


Yii::app()->clientScript->registerScript('selectDropDown', "
       $('body select').msDropDown();
        ");
?>
<div class="form">
    <?php // aqui empieza el formulario
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'biobank_manUploaded-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>
    <div class="row" >

       

        <?php
        $criteria = new EMongoCriteria;
        $criteria->sort('identifier', EMongoCriteria::SORT_ASC);
        echo $form->dropDownList($model, 'identifier', CHtml::listData(Biobank::model()->findAll($criteria), 'identifier', 'identifierAndName'), 
                array('empty' => 'select brif code')); 
                     /* 'ajax'=> array('type'=>'POST',           
                                   // 'dataType'=>'json',
                                    'data'=> array('identifier'=>'js:this.value'),
                                    'url'=> CController::createUrl('uploadForm/uploadAll'),//$this->createUrl('uploadForm/uploadAll')
                                   //'update'=> '#identifier_id',
                                   'update'=> CHtml::activeId($model, 'identifier')
                                    //'success'=> 'function(data){if (data == null)}'
                )));*/
                                               
        ?>      
  <?php echo $form->error($model, 'identifier'); ?>
    </div>
    
    
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('common', 'createBtn') : Yii::t('common', 'saveBtn')); ?>
    </div>
  

   

    <?php $this->endWidget(); //aki terminalario ?> 

</div>
<!-- form -->





<!-- deuxieme formulaire-->

<div class="form">
    <?php // aki empieza el formulario 2
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'biobank_manUpload-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>
    <div class="row" >

        <?php
        $logo = new Logo('biobank');
        ?>
        <div class="row">
            <?php echo $form->labelEx($logo, 'filename'); ?>
            <?php echo $form->fileField($logo, 'filename'); ?>
            <?php echo $form->error($logo, 'filename'); ?>
        </div>


        <?php
      // $criteria = new EMongoCriteria;
     //  $criteria->sort('identifier', EMongoCriteria::SORT_ASC);
       /* echo $form->dropDownList($model, 'id', CHtml::listData(Biobank::model()->findAll($criteria), 'id', 'idAndName'), 
                array('empty' => 'select brif code'));  */
                      
                                                
        ?>      
  <?php //echo $form->error($model, 'identifier'); ?>
    </div>
    <div clmss="row" style="display: inline-block">


        <?php echo $form->labelEx($model, 'presentation'); ?> 
        <?php echo $form->textArea($model, 'presentation', array('style' => "height:200px; width:450px")); ?>
        <?php echo $form->error($model, 'presentation'); ?>

    </div>
    <div class="row" style="display: inline-block">
        <?php echo $form->labelEx($model, 'thematiques'); ?>
        <?php echo $form->textArea($model, 'thematiques', array('style' => "height:200px; width:450px")); ?>
        <?php echo $form->error($model, 'thematiques'); ?>
    </div>
    <div class="row" style="display: inline-block">
        <?php echo $form->labelEx($model, 'projetRecherche'); ?>
        <?php echo $form->textArea($model, 'projetRecherche', array('style' => "height:200px; width:450px")); ?>
        <?php echo $form->error($model, 'projetRecherche'); ?>
    </div>
    <div class="row" style="display: inline-block">
        <?php echo $form->labelEx($model, 'publications'); ?>
        <?php echo $form->textArea($model, 'publications', array('style' => "height:200px; width:450px")); ?>
        <?php echo $form->error($model, 'publications'); ?>
    </div>
    <div class="row" style="display: inline-block">
        <?php echo $form->labelEx($model, 'reseaux'); ?>
        <?php echo $form->textArea($model, 'reseaux', array('style' => "height:200px; width:450px")); ?>
        <?php echo $form->error($model, 'reseaux'); ?>
    </div>
    <div class="row" style="display: inline-block">
        <?php echo $form->labelEx($model, 'qualite'); ?>
        <?php echo $form->textArea($model, 'qualite', array('style' => "height:200px; width:450px")); ?>
        <?php echo $form->error($model, 'qualite'); ?>


    </div>

    

    <?php $this->endWidget(); //aki terminalario ?> 

</div>