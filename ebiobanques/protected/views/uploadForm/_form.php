<?php
/* @var $this DemandeController */
/* @var $model Demande */
/* @var $form CActiveForm */

//Yii::app()->clientScript->registerScript('selectDropDown', "
//     $('body select').msDropDown();
//    ");

/* Yii::app()->clientScript->registerScript('biobank_manUploaded-form', "
  $('.search-button').change(function(){
  $('.-form').update('biobank_manUploaded-form',{
  data: $(this).serialize()
  });
  return false;
  });
  $('.search-form form').submit(function(){ //copiar la primera linea : con biobank_manUploaded-form
  $('#biobanks-grid').yiiGridView('update', {
  data: $(this).serialize()
  });
  return false;
  });

  "); */

Yii::app()->clientScript->registerScript('sendSelectForm', "
$('#BiobankIdentifierForm_identifier').change(function(){
    $('#biobank_manUploaded-form').submit();
});

//

$('#biobank_manUploaded-form').submit(function(){

$.ajax({
type:'POST',
data:$(this).serialize(),
  success : function(result){
 
//alert('success');
 var resultForm = $($.parseHTML(result)).find('#biobank_manUpload-form2').html();
  $('#biobank_manUpload-form2').html(resultForm);

  },
  error : function(result){
  alert('Error on biobank information');
  }
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
    echo $form->DropDownList($biobankIdentifier, 'identifier', CHtml::listData(Biobank::model()->findAll($criteria), 'identifier', 'identifierAndName'), array(
        'empty' => 'select brif code',
            //    'onchange'=> 'this.form.submit()' //'js:validate_dropdown(this.value)'
            /* 'ajax'=>array(
              'type'=>'POST',
              'url'=> Yii::app()->createUrl('uploadForm/uploadAll'),
              'update'=>'#identifier',
              'data' =>array($biobankIdentifier => 'js:this.value'),
              ) */
    ));
    ?>
        <?php echo $form->error($biobankIdentifier, 'identifier'); ?>
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
    <?php // echo $form2->labelEx($logo, 'filename'); ?>
    <?php //echo $form2->fileField($logo, 'filename');  ?>
    <?php //echo $form2->error($logo, 'filename'); ?>
          </div> -->



        <?php echo $form2->hiddenField($model, 'identifier'); ?>

    </div>
    <div class="row" style="display: inline-block">


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

        <?php $this->endWidget(); ?>

</div>