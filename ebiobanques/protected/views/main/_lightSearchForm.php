<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * JQUERY scripts for disabling textfields
 */

Yii::app()->clientScript->registerScript('disablingLF', "
  //init function : enabled first field, disable others

  $(function() {
  $('#LightBiocapForm_iccc_group1').prop('disabled',false);
  $('#LightBiocapForm_iccc_group2').prop('disabled',true);
  $('#LightBiocapForm_iccc_group3').prop('disabled',true);

  $('#LightBiocapForm_topoOrganeField1').prop('disabled',false);
  $('#LightBiocapForm_topoOrganeField2').prop('disabled',true);
  $('#LightBiocapForm_topoOrganeField3').prop('disabled',true);

  $('#LightBiocapForm_morphoHistoField1').prop('disabled',false);
  $('#LightBiocapForm_morphoHistoField2').prop('disabled',true);
  $('#LightBiocapForm_morphoHistoField3').prop('disabled',true);
  });

  //iccc fields
  $('#LightBiocapForm_iccc_group1').change(function(){

  if($('#LightBiocapForm_iccc_group1').val().length>0){
    $('#LightBiocapForm_iccc_group2').prop('disabled',false);
    $('#LFssgroup1').load('" . Yii::app()->createUrl('main/getSousGroupList') . "',
        $('#LightBiocapForm_iccc_group1').serialize()
  );
$('#LFssgroup').html('" . CActiveForm::label($model, 'iccc_sousgroup') . "');
  }else{
  $('#LFssgroup').html('');
  $('#LFssgroup1').html('');
  $('#LFssgroup2').html('');
  $('#LFssgroup3').html('');
  $('#LightBiocapForm_iccc_group2').prop('disabled',true);
  $('#LightBiocapForm_iccc_group3').prop('disabled',true);
  }


  });

  $('#LightBiocapForm_iccc_group2').change(function(){

  if($('#LightBiocapForm_iccc_group2').val().length>0){
  $('#LightBiocapForm_iccc_group3').prop('disabled',false);
  $('#LFssgroup2').load('" . Yii::app()->createUrl('main/getSousGroupList') . "',
  $('#LightBiocapForm_iccc_group2').serialize()
  );
  }else{
  $('#LightBiocapForm_iccc_group3').prop('disabled',true);
  $('#LFssgroup2').html('');
  $('#LFssgroup3').html('');


  }
  });

  $('#LightBiocapForm_iccc_group3').change(function(){
  if($('#LightBiocapForm_iccc_group3').val().length>0){
  $('#LFssgroup3').load('" . Yii::app()->createUrl('main/getSousGroupList') . "',
  $('#LightBiocapForm_iccc_group3').serialize()
  );
  }else{
  $('#LFssgroup3').html('');
  }
  });








  //topoOrgane
  $('#LightBiocapForm_topoOrganeField1').change(function(){
  if($('#LightBiocapForm_topoOrganeField1').val().length>0){
  $('#LightBiocapForm_topoOrganeField2').prop('disabled',false);
  }else{
  $('#LightBiocapForm_topoOrganeField2').prop('disabled',true);
  $('#LightBiocapForm_topoOrganeField3').prop('disabled',true);
  }
  return false;
  });
  $('#LightBiocapForm_topoOrganeField2').change(function(){
  if($('#LightBiocapForm_topoOrganeField2').val().length>0){
  $('#LightBiocapForm_topoOrganeField3').prop('disabled',false);
  }else{
  $('#LightBiocapForm_topoOrganeField3').prop('disabled',true);

  }
  return false;
  });

  //morphoHisto
  $('#LightBiocapForm_morphoHistoField1').change(function(){
  if($('#LightBiocapForm_morphoHistoField1').val().length>0){
  $('#LightBiocapForm_morphoHistoField2').prop('disabled',false);
  }else{
  $('#LightBiocapForm_morphoHistoField2').prop('disabled',true);
  $('#LightBiocapForm_morphoHistoField3').prop('disabled',true);
  }
  return false;
  });
  $('#LightBiocapForm_morphoHistoField2').change(function(){
  if($('#LightBiocapForm_morphoHistoField2').val().length>0){
  $('#LightBiocapForm_morphoHistoField3').prop('disabled',false);
  }else{
  $('#LightBiocapForm_morphoHistoField3').prop('disabled',true);

  }
  return false;
  });


  ");
?>
<div class="form"  >
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'light_search-form',
        'htmlOptions' => array(
            'autocomplete' => 'off'
        )
    ));
    ?>


    <div>
        <?php
        echo $form->label($model, 'mode_request');
        echo $form->dropDownList($model, 'mode_request', RequestTools::getModesList());
        ?>
    </div>
    <div style="display: flex">

        <div class ="biocapWindow" style="width:65%;">
            <div class='title'>DIAGNOSTIC</div>

            <div class = "row" style="text-align: right;">

                <div style='display: inline-block;  vertical-align: top;float: left;text-align: left'>
                    <?php
                    echo $form->label($model, 'iccc_group');
                    ?>

                    <div id='LFssgroup' style="margin-top: 18px;"></div>
                </div>
                <div style='display: inline-block;  vertical-align: top'>


                    <?php
                    echo $form->dropDownList($model, 'iccc_group1', SampleCollected::model()->getGroupList(), array(
                        'prompt' => 'Selectionner un groupe',
                        'display' => 'inline-block', 'style' => "width:150px", 'separator' => ' ', 'uncheckValue' => null));
                    ?>
                    <div id="LFssgroup1" style="display: block">

                    </div>
                </div>
                <div style='display: inline-block;vertical-align: top'>


                    <?php
                    echo $form->dropDownList($model, 'iccc_group2', SampleCollected::model()->getGroupList(), array(
                        'prompt' => 'Selectionner un groupe',
                        'display' => 'inline-block', 'style' => "width:150px", 'separator' => ' ', 'uncheckValue' => null));
                    ?>
                    <div id="LFssgroup2">

                    </div>
                </div>
                <div style='display: inline-block; vertical-align: top'>


                    <?php
                    echo $form->dropDownList($model, 'iccc_group3', SampleCollected::model()->getGroupList(), array(
                        'prompt' => 'Selectionner un groupe',
                        'display' => 'inline-block', 'style' => "width:150px", 'separator' => ' ', 'uncheckValue' => null));
                    ?>
                    <div id="LFssgroup3">

                    </div>
                </div>
            </div>

            <div class = "row" style="text-align: right">
                <?php
                echo $form->label($model, 'topoOrganeField', array('style' => 'display:inline-block;float:left'));
                echo $form->dropDownList($model, 'topoOrganeField1', SampleCollected::model()->getCimoTopoList(), array(
                    'prompt' => 'Selectionner un code topo',
                    'display' => 'inline-block', 'style' => "width:150px", 'separator' => ' ', 'uncheckValue' => null));
                ?>
                <?php
                //echo $form->label($model, 'topoOrganeField', array('style' => 'display:inline-block;float:left'));
//                echo $form->radioButtonList($model, 'topoOrganeType', array('cimo' => 'CIM-O', 'adicap' => 'ADICAP'), array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                ?>

                <?php
                // echo $form->textField($model, 'topoOrganeField1', array('size' => '5'));
                ?>
                <?php
                // echo $form->error($model, 'topoOrganeField1');
                ?>
                <?php
                //echo $form->textField($model, 'topoOrganeField2', array('size' => '5'));
                echo $form->dropDownList($model, 'topoOrganeField2', SampleCollected::model()->getCimoTopoList(), array(
                    'prompt' => 'Selectionner un code topo',
                    'display' => 'inline-block', 'style' => "width:150px", 'separator' => ' ', 'uncheckValue' => null));
                ?>
                <?php
                //  echo $form->error($model, 'topoOrganeField2');
                ?>
                <?php
                //  echo $form->textField($model, 'topoOrganeField3', array('size' => '5'));
                echo $form->dropDownList($model, 'topoOrganeField3', SampleCollected::model()->getCimoTopoList(), array(
                    'prompt' => 'Selectionner un code topo',
                    'display' => 'inline-block', 'style' => "width:150px", 'separator' => ' ', 'uncheckValue' => null));
                ?>
                <?php
                //  echo $form->error($model, 'topoOrganeField3');
                ?>
            </div>
            <div class = "row" style="text-align: right">
                <?php
                echo $form->label($model, 'morphoHistoField', array('style' => 'display:inline-block;float:left'));
                ?>
                <?php
//                echo $form->radioButtonList($model, 'morphoHistoType', array('cimo' => 'CIM-O', 'adicap' => 'ADICAP'), array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                ?>

                <?php
                echo $form->dropDownList($model, 'morphoHistoField1', SampleCollected::model()->getCimoMorphoList(), array(
                    'prompt' => 'Selectionner un code morpho',
                    'display' => 'inline-block', 'style' => "width:150px", 'separator' => ' ', 'uncheckValue' => null));
                // echo $form->textField($model, 'morphoHistoField1', array('size' => '5'));
                ?>
                <?php
                //echo $form->error($model, 'morphoHistoField1');
                ?>
                <?php
                echo $form->dropDownList($model, 'morphoHistoField2', SampleCollected::model()->getCimoMorphoList(), array(
                    'prompt' => 'Selectionner un code morpho',
                    'display' => 'inline-block', 'style' => "width:150px", 'separator' => ' ', 'uncheckValue' => null));
//echo $form->textField($model, 'morphoHistoField2', array('size' => '5'));
                ?>
                <?php
                //echo $form->error($model, 'morphoHistoField2');
                ?>
                <?php
                echo $form->dropDownList($model, 'morphoHistoField3', SampleCollected::model()->getCimoMorphoList(), array(
                    'prompt' => 'Selectionner un code morpho',
                    'display' => 'inline-block', 'style' => "width:150px", 'separator' => ' ', 'uncheckValue' => null));
//                echo $form->textField($model, 'morphoHistoField3', array('size' => '5'));
                ?>
                <?php
                // echo $form->error($model, 'morphoHistoField3');
                ?>
            </div>


        </div>


        <div class="biocapWindow" style="width:31%; padding-left: 0px;">
            <div class='title'>PATIENT</div>
            <div class="row aligned" >
                <?php
                echo $form->label($model, 'age', array('style' => 'width: 25%;vertical-align: top;display: inline-block;'));
                ?>
                <div style="display: inline-block;float:right;width: 70%;vertical-align: top;">
                    <?php ?>
                    <div style="display: inline-block;">
                        <?php
                        echo $form->checkBox($model, 'age[0-1]', array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                        echo $form::label($model, 'age[0-1]');
                        ?>
                    </div>
                    <div style="display: inline-block;">
                        <?php
                        echo $form->checkBox($model, 'age[2-4]', array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                        echo $form::label($model, 'age[2-4]');
                        ?>
                    </div>
                    <div style="display: inline-block;">
                        <?php
                        echo $form->checkBox($model, 'age[5-9]', array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                        echo $form::label($model, 'age[5-9]');
                        ?>
                    </div>
                    <div style="display: inline-block;">
                        <?php
                        echo $form->checkBox($model, 'age[10-14]', array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                        echo $form::label($model, 'age[10-14]');
                        ?>
                    </div>
                    <div style="display: inline-block;">
                        <?php
                        echo $form->checkBox($model, 'age[15+]', array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                        echo $form::label($model, 'age[15+]');
                        ?>
                    </div>
                </div>
                <?php
                echo $form->error($model, 'age');
                ?>

            </div>


        </div>
    </div>
    <div class='biocapWindow' style="width: 97%">
        <div class='title'>PRELEVEMENT</div>
        <div class='group'>
            <div class='title'>Prélèvement</div>
            <div>
                <?php
                echo $form->label($model, 'evenement', array('style' => 'display:inline-block'));
                ?>
            </div>
            <div class ='radiobtns'>
                <div>
                    <?php
                    echo $form->checkBox($model, 'evenement[diag_init]', array('value' => 'diagnotic initial', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'evenement[diag_init]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'evenement[rechute]', array('value' => 'rechute', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'evenement[rechute]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'evenement[sec_cancer]', array('value' => 'second cancer', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'evenement[sec_cancer]');
                    ?>
                </div>
            </div>


            <div>
            </div>
            <div>
                <?php
                echo $form->label($model, 'type_prelev', array('style' => 'display:inline-block'));
                ?>
            </div>
            <div class ='radiobtns'>
                <!--<div>-->
                <?php
//                    echo $form->checkBox($model, 'type_prelev', array('id' => 'typePrelRB1', 'value' => 'inconnu', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
//                    echo CHtml::label('Indifférent', 'typePrelRB1');
                ?>
                <!--</div>-->
                <div style="width: 19%">
                    <?php
                    echo $form->checkBox($model, 'type_prelev[tissu]', array('value' => 'tissu', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'type_prelev[tissu]');
                    ?>
                </div>
                <div style="width: 19%">
                    <?php
                    echo $form->checkBox($model, 'type_prelev[moelle]', array('value' => 'moelle', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'type_prelev[moelle]');
                    ?>
                </div>
                <div style="width: 19%">
                    <?php
                    echo $form->checkBox($model, 'type_prelev[sang]', array('value' => 'sang', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'type_prelev[sang]');
                    ?>
                </div>
                <div style="width: 19%">
                    <?php
                    echo $form->checkBox($model, 'type_prelev[liquide]', array('value' => 'liquide', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'type_prelev[liquide]');
                    ?>
                </div>
                <div style="width: 19%">
                    <?php
                    echo $form->checkBox($model, 'type_prelev[autre]', array('value' => 'autre', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'type_prelev[autre]');
                    ?>
                </div>
            </div>
            <div>
            </div>
            <div>
                <?php
                echo $form::label($model, 'mode_prelev', array('style' => 'display:inline-block'));
                ?>
            </div>
            <div class ='radiobtns'>
                <div>
                    <?php
                    echo $form->checkBox($model, 'mode_prelev[biopsie]', array('value' => 'biopsie', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'mode_prelev[biopsie]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'mode_prelev[pieceOp]', array('value' => 'pièce opératoire', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'mode_prelev[pieceOp]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'mode_prelev[ponction]', array('value' => 'ponction', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'mode_prelev[ponction]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'mode_prelev[autre]', array('value' => 'autre', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'mode_prelev[autre]');
                    ?>
                </div>
            </div>

        </div>

    </div>



    <?php
    echo CHtml::Button('Rechercher', array('id' => 'LSFSubmit'));

    $this->endWidget();
//echo CHtml::button('Effacer', array('id' => 'resetBtn'));
    ?>
</div>
