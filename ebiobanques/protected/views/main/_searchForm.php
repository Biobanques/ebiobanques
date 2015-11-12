<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * JQUERY scripts for disabling textfields
 */

Yii::app()->clientScript->registerScript('disabling', "
    //init function : enabled first field, disable others

$(function() {
  $('#BiocapForm_iccc_group1').prop('disabled',false);
  $('#BiocapForm_iccc_group2').prop('disabled',true);
  $('#BiocapForm_iccc_group3').prop('disabled',true);

  $('#BiocapForm_topoOrganeField1').prop('disabled',false);
  $('#BiocapForm_topoOrganeField2').prop('disabled',true);
  $('#BiocapForm_topoOrganeField3').prop('disabled',true);

  $('#BiocapForm_morphoHistoField1').prop('disabled',false);
  $('#BiocapForm_morphoHistoField2').prop('disabled',true);
  $('#BiocapForm_morphoHistoField3').prop('disabled',true);
});

//iccc fields
$('#BiocapForm_iccc_group1').change(function(){




 if($('#BiocapForm_iccc_group1').val().length>0){
           $('#BiocapForm_iccc_group2').prop('disabled',false);
           $('#ssgroup1').load('" . Yii::app()->createUrl('main/getSousGroupList') . "',
    $('#BiocapForm_iccc_group1').serialize()
   );
$('#ssgroup').html('" . CActiveForm::label($model, 'iccc_sousgroup') . "');
    }else{
        $('#ssgroup').html('');
        $('#ssgroup1').html('');
        $('#ssgroup2').html('');
        $('#ssgroup3').html('');
        $('#BiocapForm_iccc_group2').prop('disabled',true);
  $('#BiocapForm_iccc_group3').prop('disabled',true);
  }


});

$('#BiocapForm_iccc_group2').change(function(){

     if($('#BiocapForm_iccc_group2').val().length>0){
           $('#BiocapForm_iccc_group3').prop('disabled',false);
           $('#ssgroup2').load('" . Yii::app()->createUrl('main/getSousGroupList') . "',
    $('#BiocapForm_iccc_group2').serialize()
   );
    }else{
         $('#BiocapForm_iccc_group3').prop('disabled',true);
                 $('#ssgroup2').html('');
        $('#ssgroup3').html('');


}
});

$('#BiocapForm_iccc_group3').change(function(){
if($('#BiocapForm_iccc_group3').val().length>0){
$('#ssgroup3').load('" . Yii::app()->createUrl('main/getSousGroupList') . "',
    $('#BiocapForm_iccc_group3').serialize()
   );
   }else{
     $('#ssgroup3').html('');
   }
});





/*

$('#BiocapForm_iccc_group1').change(function(){
       if($('#BiocapForm_iccc_group1').val().length>0){
           $('#BiocapForm_iccc_group2').prop('disabled',false);
    }else{
         $('#BiocapForm_iccc_group2').prop('disabled',true);
  $('#BiocapForm_iccc_group3').prop('disabled',true);
}
return false;
});
$('#BiocapForm_iccc_group2').change(function(){
       if($('#BiocapForm_iccc_group2').val().length>0){
           $('#BiocapForm_iccc_group3').prop('disabled',false);
    }else{
         $('#BiocapForm_iccc_group3').prop('disabled',true);

}
return false;
});
*/
//topoOrgane
$('#BiocapForm_topoOrganeField1').change(function(){
       if($('#BiocapForm_topoOrganeField1').val().length>0){
           $('#BiocapForm_topoOrganeField2').prop('disabled',false);
    }else{
         $('#BiocapForm_topoOrganeField2').prop('disabled',true);
  $('#BiocapForm_topoOrganeField3').prop('disabled',true);
}
return false;
});
$('#BiocapForm_topoOrganeField2').change(function(){
       if($('#BiocapForm_topoOrganeField2').val().length>0){
           $('#BiocapForm_topoOrganeField3').prop('disabled',false);
    }else{
         $('#BiocapForm_topoOrganeField3').prop('disabled',true);

}
return false;
});

//morphoHisto
$('#BiocapForm_morphoHistoField1').change(function(){
       if($('#BiocapForm_morphoHistoField1').val().length>0){
           $('#BiocapForm_morphoHistoField2').prop('disabled',false);
    }else{
         $('#BiocapForm_morphoHistoField2').prop('disabled',true);
  $('#BiocapForm_morphoHistoField3').prop('disabled',true);
}
return false;
});
$('#BiocapForm_morphoHistoField2').change(function(){
       if($('#BiocapForm_morphoHistoField2').val().length>0){
           $('#BiocapForm_morphoHistoField3').prop('disabled',false);
    }else{
         $('#BiocapForm_morphoHistoField3').prop('disabled',true);

}
return false;
});

");
?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'search-form',
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
                <?php
//                echo $form->label($model, 'iccc_group', array('style' => 'display:inline-block;float:left'));
                ?>

                <?php
//                echo $form->textField($model, 'iccc_group1', array('size' => '5'));
                ?>
                <?php
//                echo $form->error($model, 'iccc_group1');
                ?>
                <?php
//                echo $form->textField($model, 'iccc_group2', array('size' => '5'));
                ?>
                <?php
//                echo $form->error($model, 'iccc_group2');
                ?>
                <?php
//                echo $form->textField($model, 'iccc_group3', array('size' => '5'));
                ?>
                <?php
//                echo $form->error($model, 'iccc_group3');
                ?>



                <div style='display: inline-block;  vertical-align: middle;float: left;text-align: left'>
                    <?php
                    echo $form->label($model, 'iccc_group');
                    ?>
                    <div id='ssgroup' style="margin-top: 18px;"></div>

                </div>
                <div style='display: inline-block;  vertical-align: top'>


                    <?php
                    echo $form->dropDownList($model, 'iccc_group1', SampleCollected::model()->getGroupList(), array(
                        'prompt' => 'Selectionner un groupe',
                        'display' => 'inline-block', 'style' => "width:150px", 'separator' => ' ', 'uncheckValue' => null));
                    ?>
                    <div id="ssgroup1">

                    </div>
                </div>
                <div style='display: inline-block;vertical-align: top'>


                    <?php
                    echo $form->dropDownList($model, 'iccc_group2', SampleCollected::model()->getGroupList(), array(
                        'prompt' => 'Selectionner un groupe',
                        'display' => 'inline-block', 'style' => "width:150px", 'separator' => ' ', 'uncheckValue' => null));
                    ?>
                    <div id="ssgroup2">

                    </div>
                </div>
                <div style='display: inline-block; vertical-align: top'>


                    <?php
                    echo $form->dropDownList($model, 'iccc_group3', SampleCollected::model()->getGroupList(), array(
                        'prompt' => 'Selectionner un groupe',
                        'display' => 'inline-block', 'style' => "width:150px", 'separator' => ' ', 'uncheckValue' => null));
                    ?>
                    <div id="ssgroup3">

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

            <div class="row" >
                <div style='display: inline-block;width: 30%'>
                    <?php
                    echo $form->label($model, 'metastasique');
                    ?>
                    <?php
                    echo $form->dropDownList($model, 'metastasique', array('inconnu' => 'Indifférent', 'oui' => 'Oui', 'non' => 'Non'), array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    ?>
                    <?php
                    echo $form->error($model, 'metastasique');
                    ?>
                </div>  <div style='display: inline-block;width: 31%'>
                    <?php
                    echo $form->label($model, 'cr_anapath_dispo');
                    ?>
                    <?php
                    echo $form->dropDownList($model, 'cr_anapath_dispo', array('inconnu' => 'Indifférent', 'oui' => 'Oui', 'non' => 'Non'), array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    ?>
                    <?php
                    echo $form->error($model, 'cr_anapath_dispo');
                    ?>
                </div>  <div style='display: inline-block;width: 31%'>

                    <?php
                    echo $form->label($model, 'donCliInBase');
                    ?>
                    <?php
                    echo $form->dropDownList($model, 'donCliInBase', array('inconnu' => 'Indifférent', 'oui' => 'Oui', 'non' => 'Non'), array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    ?>
                    <?php
                    echo $form->error($model, 'donCliInBase');
                    ?>
                </div>
            </div>
        </div>


        <div class="biocapWindow" style="width:31%; padding-left: 0px;">
            <div class='title'>PATIENT</div>
            <div class="row aligned" >
                <?php
                echo $form->label($model, 'age', array('style' => 'width:25%;vertical-align: top;'));
                ?>
                <div style="display: inline-block;width: 70%;vertical-align: top;">
                    <?php
                    ?>
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
            <div class ="row aligned">
                <?php
                echo $form->label($model, 'sexe', array('style' => 'display:inline-block;width:55%;'));
                ?>
                <?php
                echo $form->dropDownList($model, 'sexe', array('inconnu' => 'Indifférent', 'Masculin' => 'Masculin', 'Féminin' => 'Féminin'), array('display' => 'inline-block', 'float' => 'right', 'separator' => ' ', 'uncheckValue' => null));
                ?>
            </div>
            <div class ="row aligned">
                <?php
                echo $form->label($model, 'stat_vital', array('style' => 'display:inline-block;width:55%;'));
                ?>
                <?php
                echo $form->dropDownList($model, 'stat_vital', array('inconnu' => 'Indifférent', 'vivant' => 'Vivant', 'decede' => 'Décédé'), array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                ?>
            </div>
            <div class ="row aligned">
                <?php
                echo $form->label($model, 'ano_chrom_constit', array('style' => 'display:inline-block;width:55%;'));
                ?>

                <?php
//                echo $form->radioButtonList($model, 'ano_chrom_constit', array('inconnu' => 'Indifférent', 'oui' => 'Oui', 'non' => 'Non'), array('display' => 'inline-block', 'float' => 'right', 'separator' => ' ', 'uncheckValue' => null));
                echo $form->dropDownList($model, 'ano_chrom_constit', array('inconnu' => 'Indifférent', 'oui' => 'Oui', 'non' => 'Non'), array('display' => 'inline-block', 'float' => 'right', 'separator' => ' ', 'uncheckValue' => null));
                ?>
            </div>
            <div class ="row aligned">
                <?php
                echo $form->label($model, 'affect_gen', array('style' => 'display:inline-block;width:55%;'));
                ?>

                <?php
                echo $form->textField($model, 'affect_gen', array('size' => '5'));
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
                echo $form->label($model, 'avantChimio', array('style' => 'display:inline-block'));
                ?></div>
            <div class ='radiobtns'>
                <div>
                    <?php
                    echo $form->radioButton($model, 'avantChimio', array('id' => 'avChRB1', 'value' => 'inconnu', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null, 'disabled' => true));
                    echo CHtml::label('Indifférent', 'avChRB1');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->radioButton($model, 'avantChimio', array('id' => 'avChRB2', 'value' => 'oui', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null, 'disabled' => true));
                    echo CHtml::label('Oui', 'avChRB2');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->radioButton($model, 'avantChimio', array('id' => 'avChRB3', 'value' => 'non', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null, 'disabled' => true));
                    echo CHtml::label('Non', 'avChRB3');
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
        <div class='title'>INFORMATIONS ECHANTILLONS</div>
        <div class='group'>
            <div class='title'>Echantillon tumoral</div>
            <div>
                <?php
                echo $form->label($model, 'ETLLoc', array('style' => 'display:inline-block'));
                ?>
            </div>
            <div class ='radiobtns'>
                <div>
                    <?php
                    echo $form->checkBox($model, 'ETLLoc[tum_prim]', array('value' => 'Tumeur primaire', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null, 'disabled' => true));
                    echo $form::label($model, 'ETLLoc[tum_prim]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'ETLLoc[metastase]', array('value' => 'metastase', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null, 'disabled' => true));
                    echo $form::label($model, 'ETLLoc[metastase]');
                    ?>
                </div>

            </div>
            <div>
            </div>
            <div>
                <?php
                echo $form->label($model, 'ETLTyp', array('style' => 'display:inline-block'));
                ?>
            </div>
            <div class ='radiobtns'>
                <div>
                    <?php
                    echo $form->checkBox($model, 'ETLTyp[tissu_cong]', array('value' => 'Tissu tumoral congelé', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'ETLTyp[tissu_cong]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'ETLTyp[bloc_para]', array('value' => 'Tissu tumoral', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'ETLTyp[bloc_para]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'ETLTyp[cell_DMSO]', array('value' => 'Cellules DMSO', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'ETLTyp[cell_DMSO]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'ETLTyp[cell_CS]', array('value' => 'Cellules culot sec', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'ETLTyp[cell_CS]');
                    ?>
                </div>
            </div>
            <div>
            </div>
            <div>
                <?php
                echo $form->label($model, 'ETLDer', array('style' => 'display:inline-block'));
                ?>
            </div>
            <div class ='radiobtns'>
                <div>
                    <?php
                    echo $form->checkBox($model, 'ETLDer[adn_der]', array('value' => 'ADN dérivé', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'ETLDer[adn_der]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'ETLDer[arn_der]', array('value' => 'ARN dérivé', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'ETLDer[arn_der]');
                    ?>


                </div>
            </div>
        </div>
        <div class='group'>
            <div class='title'>Echantillon non tumoral</div>
            <div>
                <?php
                echo $form->label($model, 'ENTLoc', array('style' => 'display:inline-block'));
                ?>
            </div>
            <div class ='radiobtns'>
                <div style="width: 32%; padding-right: 4px">
                    <?php
                    echo $form->checkBox($model, 'ENTLoc[tissu_sain_org_tumeur]', array('value' => 'tissu_sain_org_tumeur', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null, 'disabled' => true));
                    echo $form::label($model, 'ENTLoc[tissu_sain_org_tumeur]');
                    ?>
                </div>
                <div style="width: 32%; padding-right: 4px">
                    <?php
                    echo $form->checkBox($model, 'ENTLoc[tissu_sain_autre_org]', array('value' => 'tissu_sain_autre_org', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null, 'disabled' => true));
                    echo $form::label($model, 'ENTLoc[tissu_sain_autre_org]');
                    ?>
                </div>
                <div style="width: 32%; padding-right: 4px">
                    <?php
                    echo $form->checkBox($model, 'ENTLoc[moelle_sang_rem]', array('value' => 'moelle_sang_rem', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null, 'disabled' => true));
                    echo $form::label($model, 'ENTLoc[moelle_sang_rem]');
                    ?>
                </div>
            </div>
            <div></div>
            <div>
                <?php
                echo $form->label($model, 'ENTTyp', array('style' => 'display:inline-block'));
                ?>
            </div>
            <div class="radiobtns">


                <div>
                    <?php
                    echo $form->checkBox($model, 'ENTTyp[tiss_sain]', array('value' => 'Tissu sain', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'ENTTyp[tiss_sain]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'ENTTyp[sang_tot_cong]', array('value' => 'Sang total congelé', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'ENTTyp[sang_tot_cong]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'ENTTyp[cellNT]', array('value' => 'Cellules non tumoral', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'ENTTyp[cellNT]');
                    ?>
                </div>
                <!--                <div>
                <?php
//                    echo $form->checkBox($model, 'ENTTyp[lymphocyte]', array('value' => 'lymphocyte', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null, 'disabled' => true));
//                    echo $form::label($model, 'ENTTyp[lymphocyte]');
                ?>
                                </div>-->
                <div>
                    <?php
                    echo $form->checkBox($model, 'ENTTyp[salive]', array('value' => 'salive', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'ENTTyp[salive]');
                    ?>
                </div>
            </div>
            <div></div>
            <div>
                <?php
                echo $form->label($model, 'ENTDer', array('style' => 'display:inline-block'));
                ?>
            </div>
            <div class="radiobtns">
                <div style="width: 48%; padding-right: 4px">
                    <?php
                    echo $form->checkBox($model, 'ENTDer[adn_const]', array('value' => 'ADN constitutionnel', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'ENTDer[adn_const]');
                    ?>
                </div>
                <div style="width: 48%; padding-right: 4px">
                    <?php
                    echo $form->checkBox($model, 'ENTDer[arn_const]', array('value' => 'ARN constitutionnel', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo $form::label($model, 'ENTDer[arn_const]');
                    ?>
                </div>
            </div>
            <div></div>
            <div>
                <?php
                echo $form->label($model, 'ENTRBA', array('style' => 'display:inline-block'));
                ?>
            </div>
            <div class="radiobtns">
                <div>
                    <?php
                    echo $form->checkBox($model, 'ENTRBA[serum]', array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null, 'disabled' => true));
                    echo $form::label($model, 'ENTRBA[serum]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'ENTRBA[plasma]', array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null, 'disabled' => true));
                    echo $form::label($model, 'ENTRBA[plasma]');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->checkBox($model, 'ENTRBA[autre]', array('display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null, 'disabled' => true));
                    echo $form::label($model, 'ENTRBA[autre]');
                    ?>
                </div>
            </div>



        </div>
        <div class="group">
            <div class="title">
                Consentement
            </div>
            <div><?php echo $form::label($model, 'consent_rech'); ?></div>
            <div class ='radiobtns'>
                <div>
                    <?php
                    echo $form->radioButton($model, 'consent_rech', array('id' => 'CRRB1', 'value' => 'inconnu', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo CHtml::label('Indifférent', 'CRRB1');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->radioButton($model, 'consent_rech', array('id' => 'CRRB2', 'value' => 'oui', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo CHtml::label('Oui', 'CRRB2');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->radioButton($model, 'consent_rech', array('id' => 'CRRB3', 'value' => 'non', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo CHtml::label('Non', 'CRRB3');
                    ?>
                </div>
            </div>
            <div></div>

            <div><?php echo $form::label($model, 'consent_RGC'); ?></div>
            <div class ='radiobtns'>
                <div>
                    <?php
                    echo $form->radioButton($model, 'consent_RGC', array('id' => 'CRGCRB1', 'value' => 'inconnu', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo CHtml::label('Indifférent', 'CRGCRB1');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->radioButton($model, 'consent_RGC', array('id' => 'CRGCRB2', 'value' => 'oui', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo CHtml::label('Oui', 'CRGCRB2');
                    ?>
                </div>
                <div>
                    <?php
                    echo $form->radioButton($model, 'consent_RGC', array('id' => 'CRGCRB3', 'value' => 'non', 'display' => 'inline-block', 'separator' => ' ', 'uncheckValue' => null));
                    echo CHtml::label('Non', 'CRGCRB3');
                    ?>
                </div>
            </div>

        </div>
    </div>



    <?php
    echo CHtml::Button('Rechercher', array('id' => 'SFSubmit'));

    $this->endWidget();
    //echo CHtml::button('Effacer', array('id' => 'resetBtn'));
    ?>
</div>
