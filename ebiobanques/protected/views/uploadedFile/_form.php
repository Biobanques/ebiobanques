<?php
/* @var $this BiobankController */
/* @var $model Biobank */
/* @var $form CActiveForm */
/**
 * todo internationalzation
 */
Yii::app()->clientScript->registerScript("valid", "
    $('#uploadFileField').change(function(){
        var ext = $('#uploadFileField').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['xls', 'xlsx']) == -1) {
            alert('" . Yii::t('myBiobank', 'invalidExtension') . "');
            $('#uploadFileField').val('');
        }
    });");
if ($fileId != null) {
    Yii::app()->clientScript->registerScript("callProcess", "
    $(document).ready(function(){
$.ajax({url : '" . Yii::app()->createUrl('uploadedFile/processFile', array('id' => $fileId, 'add' => $add)) . "',
            success : function(code_html, statut){ // success est toujours en place, bien sûr !



       },

    });
});");
}

$fileBase = CHtml::link('template_ebiobanques.xls', Yii::app()->baseUrl . '/protected/datas/template_ebiobanques.xls');

$fileInfoBase = CHtml::link(Yii::t('myBiobank', 'uploadInfo'), '#', array('data-toggle' => "modal", 'data-target' => "#infoPopup"));
?>


<?php
/*
  $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
  'id' => 'infoPopup',
  // additional javascript options for the dialog plugin
  'options' => array(
  'title' => Yii::t('myBiobank', 'uploadInfo'),
  'autoOpen' => false,
  'width' => '90%'
  ),
  )
  ); */
?>
<div id="infoPopup" class="modal fade" role="dialog">
    <div class ="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo Yii::t('myBiobank', 'uploadInfo') ?></h4>
            </div>
            <div class="modal-body">
                <?php
                $this->renderPartial('/site/_help_message', array('title' => Yii::t('sampleProperty', 'uploadPopupHelpTitle'), 'content' => Yii::t('sampleProperty', 'uploadPopupHelpContent')));


                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'testId',
                    'dataProvider' => $dataProviderProperties,
                    'columns' => array(
                        array('name' => Yii::t('sampleProperty', 'name'),
                            'value' => '$data->name',
                            'htmlOptions' => array('class' => 'columnName')
                        ),
                        array('name' => Yii::t('sampleProperty', 'description'),
                            'value' => '$data->description',
                            'htmlOptions' => array('class' => 'columnDescription')
                        ),
                        array('name' => Yii::t('sampleProperty', 'values'),
                            'value' => '$data->values',
                            'htmlOptions' => array('class' => 'columnValues')),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
//$this->endWidget("zii.widgets.jui.CJuiDialog");

$this->renderPartial('/site/_help_message', array('title' => Yii::t('myBiobank', 'helpUploadTitle'), 'content' => Yii::t('myBiobank', 'helpUploadContent', array('fileBase' => $fileBase, 'fileInfoBase' => $fileInfoBase))));
?>



<div class="form" style="width: 500px;float: left">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'uploadedFile-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>
    <div style="padding-left:5px;padding-right:5px;padding-top:10px">


        <div class="radio_button_row">
            Sélectionner votre mode d'import de données : <br>
            <?php
            $importType = array('add' => 'Ajout des échantillons à ceux existants.', 'replace' => 'Remplacement des échantillons existants par ceux importés.');

            echo $form->radioButtonList($model, 'addOrReplace', $importType, array('separator' => ' ', 'container' => 'div',));
            ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'formLabel'); ?>
            <?php echo $form->fileField($model, 'fileUploaded', array('accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel,.xls,.xlsx', 'id' => 'uploadFileField', 'name' => 'uploadFileField')); ?>


            <?php echo $form->error($model, 'fileUploaded'); ?>
        </div>


        <div class="row">
            <?php echo CHtml::submitButton(Yii::t('common', 'saveBtn')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->