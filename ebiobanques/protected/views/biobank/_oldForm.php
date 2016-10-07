<?php
/* @var $this BiobankController */
/* @var $model Biobank */
/* @var $form CActiveForm */
$cancelRoute = Yii::app()->createAbsoluteUrl('biobank/admin');
$delCimUrl = $this->createUrl("biobank/removeCim", array('id' => $model->_id));

/**
 * Register custom script for del CIM codes buttons, to avoid issue of reloading script after an ajax request
 * Get cim code from id, send ajax request to remove concerned cim code, and reload cim codes tab.
 */
Yii::app()->clientScript->registerScript('addCim', ""
        . "jQuery('body').on('click','.delCimButton',function(){"
        . "var id = this.id;"
        . "var splitedId = id.split('_');"
        . "$.ajax({"
        . "type:'POST',"
        . "data:{'idCim':splitedId[1]},"
        . "url:'$delCimUrl',"
        . "success:function(response){"
        . "div_content = $(response).find('#form_codes_cim').html();"
        . "$('#form_codes_cim').html(div_content);"
        . "}"
        . "})"
        . ""
        . "})"
        . "");


Yii::app()->clientScript->registerScript('create', "

 $('.menuTab').click(function(){
 $('.menuTab').removeClass('active');
 $(this).addClass('active');
 var id = $(this).attr('id').replace('#','');
 $('.TabForm').toggle(false);
 	$('#form_'+id).toggle(true);
 	return false;
 });

 $('#addField').submit(function(){
var wrapper = $('#form_other');
var name = $('#newFieldName').val();
name= name.replace(' ','_');
name= name.replace(',','-');
var type = $('#newFieldType').val();

if(type=='text'){
var balise = '<input type=\"'+type+'\"';

}else{
var balise = '<'+type +' rows=5';

}

$(wrapper).append('<div><label for=\"Biobank_'+name+'\">'+name+'</label>'+balise+' name=\"Biobank['+name+']\" id=\"Biobank_'+name+'\" style=\"width:230px \"  /><input type = \"button\" class=\"removeField\" value=\"remove\"></div>');


 	return false;
 });
$(document).on('click', '.removeField', function() {
    $(this).parent().remove();
});

$('#resetButton').click(function(){
window.location.href='$cancelRoute';
    return false;
});


");


//widget de popup d'ajout dynamique de champ
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'addFieldPopup',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Ajout d\'un champ',
        'autoOpen' => false,
        'width' => '350px'
    ),
));
?>
<div class='wide form'>
    <form id="addField">
        <label for="newFieldName"> Field name </label>
        <input id="newFieldName" type="text" name="fieldName" />
        <label for="newFieldType"> Field type </label>
        <select id="newFieldType"  name="fieldType" >
            <option value="text">Text field</option>
            <option value="textarea">Text area</option>
        </select>
        <br>
        <div style="text-align: center">
            <input type='reset' value='cancel'/>
            <input type="submit" value="Add"/>
        </div>
    </form>
</div>

<?php
$this->endWidget();

//widget de popup d'ajout dynamique de champ
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'addCimPopup',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Ajout d\'un code CIM',
        'autoOpen' => false,
        'width' => '350px'
    ),
));
?>
<div class='wide form'>
    <?php
    $newCimForm = $this->beginWidget('CActiveForm', array(
        'id' => 'newCim-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    $this->renderPartial('/site/_help_message', array('title' => 'Formats valides', 'content' => 'Les formats suivants sont valides : <br><ul>'
        . '<li>A00</li>'
        . '<li>A00.0</li>'
        . '<li>A00-Z99</li>'
    ));
    echo $newCimForm->textField($model, 'cims[new]');
    echo '<br>';
    echo CHtml::ajaxSubmitButton('add cim', $this->createUrl('addCim', array('id' => $model->_id)), array(
        // 'update' => '#form_codes_cim',
        'success' => 'js:function(response){'
        . 'if(response=="Error"){'
        . 'alert("Erreur, merci de vérifier que le format est bon et que le code n\'est pas déjà présent dans la liste");'
        . 'return;'
        . '}'
        . 'div_content = $(response).find("#form_codes_cim").html();'
        . '$("#form_codes_cim").html(div_content);'
        . '$("#addCimPopup").dialog("close");'
        . '}'
    ));
    $this->endWidget('newCim-form');
    ?>
</div>

<?php
$this->endWidget('addCimPopup');
?>

<?php
/**
 * Création des listes d'attributs à affciher dans les différentes parties
 * La liste $attributes_oblig représente la liste des attributs obligatoire, et doit être présente.
 * Elle ne doit pas être ajoutée à la liste d'onglets
 *
 * La liste $attributes_other regroupe tous les attributs non présents dans les autres listes. Elle doit être ajoutée en dernière à la liste d'onglets
 */
$attributes_oblig = array(
    'identifier',
    'name',
    'collection_id',
    'collection_name',
    'biobank_class',
    'diagnosis_available',
   // array('attributeName' => 'contact_id', 'value' => Contact::model()->getArrayContacts()),
    'address',
    'contact_resp',
    'responsable_op',
    'responsable_qual',
    'responsable_adj'
);

$attributes_facult = array(
    'website',
    'acronym',
    // 'vitrine',
    'folder_reception',
    'folder_done',
    'date_entry',
    'passphrase',
    'longitude',
    'latitude',
);
$listOnglets['facultatif'] = $attributes_facult;

$attributes_qualite = array(
    'cert_ISO9001',
    'cert_NFS96900',
    'cert_autres',
    'observations',
);


$listOnglets['qualite'] = $attributes_qualite;


$cims = array('cims');
$listOnglets['codes_cim'] = $cims;

$attributes_info = array(
    array('attributeName' => 'gest_software', 'value' => CommonTools::getSoftwareList()),
    'other_software',
    array('attributeName' => 'connector_installed', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    'connector_version',
);
$listOnglets['info'] = $attributes_info;

$attributes_sampling = array(
    array('attributeName' => 'sampling_practice', 'value' => Biobank::model()->getArraySamplingPractice()),
    'nb_total_samples',
    'sampling_disease_group',
    'sampling_disease_group_code',
    'nbs_dna_samples_affected',
    'nbs_dna_samples_relatives',
    'nbs_cdna_samples_affected',
    'nbs_cdna_samples_relatives',
    'nbs_wholeblood_samples_affected',
    'nbs_wholeblood_samples_relatives',
    'nbs_bloodcellisolates_samples_affected',
    'nbs_bloodcellisolates_samples_relatives'
    , 'nbs_serum_samples_affected'
    , 'nbs_serum_samples_relatives'
    , 'nbs_plasma_samples_affected'
    , 'nbs_plasma_samples_relatives'
    , 'nbs_fluids_samples_affected'
    , 'nbs_fluids_samples_relatives'
    , 'nbs_tissuescryopreserved_samples_affected'
    , 'nbs_tissuescryopreserved_samples_relatives'
    , 'nbs_tissuesparaffinembedded_samples_affected'
    , 'nbs_tissuesparaffinembedded_samples_relatives'
    , 'nbs_celllines_samples_affected'
    , 'nbs_celllines_samples_relatives'
    , 'nbs_other_samples_affected'
    , 'nbs_other_samples_relatives', 'nbs_other_specification'
);
$listOnglets['sampling'] = $attributes_sampling;

$attributes_network = [
    'networkAcronym',
    array('attributeName' => 'NetworkCommonCharter', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    array('attributeName' => 'NetworkCommonCollectionFocus', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    array('attributeName' => 'NetworkCommonDataAccessPolicy', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    array('attributeName' => 'NetworkCommonMTA', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    array('attributeName' => 'NetworkCommonRepresentation', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    array('attributeName' => 'NetworkCommonSampleAccessPolicy', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    array('attributeName' => 'NetworkCommonSOPs', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    array('attributeName' => 'NetworkCommonURL', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    'NetworkDescription',
    'NetworkJuridicalPerson',
    'NetworkName',
    'NetworkURL',
];
$listOnglets['Network'] = $attributes_network;


$attributes_partners = [

    array('attributeName' => 'PartnerCharterSigned', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    array('attributeName' => 'collaborationPartnersCommercial', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    array('attributeName' => 'collaborationPartnersNonforprofit', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
];
$listOnglets['Partners-collaboration'] = $attributes_partners;

$attributes_material = [

    array('attributeName' => 'materialStoredDNA', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    array('attributeName' => 'materialStoredPlasma', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    array('attributeName' => 'materialStoredSerum', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    array('attributeName' => 'materialStoredTissueFFPE', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
    array('attributeName' => 'materialStoredTissueFrozen', 'value' => array('TRUE' => 'Oui', 'FALSE' => 'Non')),
];
$listOnglets['Material'] = $attributes_material;
//make array of attributes stored but not defined in the common model
$attributes_other = array();
$definedAttributes = array_merge($attributes_oblig, $attributes_facult, $attributes_qualite, $attributes_info, $attributes_sampling, $attributes_network, $attributes_partners, $attributes_material, $cims, array('_id', 'contact_id', 'gest_software', 'connector_installed', 'vitrine', 'sampling_practice', 'location', 'activeLogo', 'qualite', 'qualite_en'));

$att = $model->getAttributes();
foreach ($att as $attributeName => $attributeValue) {
    if (!in_array($attributeName, $definedAttributes)) {
        $attributes_other[] = $attributeName;
    }
}
$listOnglets['other'] = $attributes_other;
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'biobank-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <p class="note"><?php echo Yii::t('common', 'ChampsObligatoires'); ?></p>

    <?php
    echo $form->errorSummary($model);

    /**
     * Affichage des attributs obligatoires
     */
    $logo = new Logo('biobank');
    ?>
    <div class="row">
        <?php echo $form->labelEx($logo, 'filename'); ?>
        <?php echo $form->fileField($logo, 'filename'); ?>
        <?php echo $form->error($logo, 'filename'); ?>
    </div>



    <table style="border-collapse: collapse;">
        <?php
        $count = 0;
        foreach ($attributes_oblig as $attName) {

            $count++;
            if ($count % 2 == 0)
                echo' <td>';
            else
                echo'<tr ><td width="50%">';

            if (is_string($attName)) {

                if (is_object($model->$attName)) {
                    $partialCount = 0;
                    $count = 0;
                    echo '<tr style="border:1px solid #000;">';
                    echo '<tr><td width="50%">';

                    echo $form->labelEx($model, $attName, array('style' => 'font-style: italic; font-size: 1.1em;'));


                    foreach ($model->$attName->attributeNames() as $emAtt) {
                        $partialCount++;
                        if ($partialCount % 2 == 0)
                            echo' <td>';
                        else
                            echo'<tr><td width="50%">';
                        ?>

                        <?php echo $form->labelEx($model->$attName, $emAtt); ?>
                        <?php
                        if ($emAtt == "country") {
                            echo $form->dropDownList($model->$attName, $emAtt, CommonTools::getArrayCountriesSorted(), ($model->isNewRecord ? array('options' => array('fr' => array('selected' => true))) : ""));
                        } elseif ($emAtt == "civility") {
                            echo $form->dropDownList($model->$attName, $emAtt, array('mister' => Yii::t('responsible', 'mister'), 'miss' => Yii::t('responsible', 'miss')), array('prompt' => '----'));
                        } else {
                            echo $form->textField($model->$attName, $emAtt);
                        }
                        ?>
                        <?php
                        echo $form->error($model->$attName, $emAtt);
                    }
                    echo '<tr style="border:1px solid #000;">';
                } else {
                    if ($attName == 'collection_id') {
                        $this->renderPartial('/site/_help_message', array('title' => 'Référence MIABIS', 'content' => ' Sample Collection ID that also links the sample collection to the hosting biobank or study.<br>'
                            . CHtml::link('Data-describing-Sample-Collection', 'https://github.com/MIABIS/miabis/wiki/Data-describing-Sample-Collection')
                        ));
                    }
                    if ($attName == 'collection_name') {
                        $this->renderPartial('/site/_help_message', array('title' => 'Référence MIABIS', 'content' => 'The name of the sample collection in english.<br><br>'
                            . CHtml::link('Data-describing-Sample-Collection', 'https://github.com/MIABIS/miabis/wiki/Data-describing-Sample-Collection', array('target' => 'blank'))
                        ));
                    }
                    ?>

                    <?php echo $form->labelEx($model, $attName); ?>
                    <?php echo $form->textField($model, $attName); ?>
                    <?php
                    echo $form->error($model, $attName);
                }
            } elseif (is_array($attName)) {
                if (!isset($model->$attName['attributeName']))
                    $model->initSoftAttribute($attName['attributeName']);
                ?>
                <?php echo $form->labelEx($model, $attName['attributeName']); ?>
                <?php echo $form->dropDownList($model, $attName['attributeName'], $attName['value'], array('prompt' => '----', 'style' => 'width:280px')); ?>
                <?php
                echo $form->error($model, $attName['attributeName']);
            }
            if ($count % 2 == 0)
                echo' </td></tr>';
            else
                echo'</td>';
        }
        ?></table>
    <?php
    /**
     * Création du menu à onglets
     */
    ?>
    <div id="menu">
        <ul id="onglets" style="left: auto">
            <?php
            $active = 'active';
            foreach ($listOnglets as $id => $attributes) {
                echo "<li class = 'menuTab $active' id = '$id'>";
                $active = '';
                echo CHtml::link(Yii::t('tabs', 'biobank_' . $id));
                echo '</li>';
            }
            ?>
        </ul>
    </div>


    <?php
    /**
     * Création du contenu des onglets
     */
    $display = true;
    foreach ($listOnglets as $id => $attributes) {
        if (!$display)
            $displayDisable = ' style="display: none"';
        else
            $displayDisable = '';
        $display = false;
        echo "<div class = 'TabForm' id = 'form_$id' $displayDisable >";
        echo '<table>';
        $count = 0;
        if ($id != 'codes_cim') {
            foreach ($attributes as $attName) {

                $count++;
                if ($count % 2 == 0)
                    echo' <td>';
                else
                    echo'<tr><td width="50%">';

                if (is_string($attName)) {

                    if (!isset($model->$attName))
                        $model->initSoftAttribute($attName);

                    echo $form->labelEx($model, $attName);


                    echo $form->textField($model, $attName);
                    echo $form->error($model, $attName);
                } elseif (is_array($attName)) {
                    if (!isset($model->$attName['attributeName']))
                        $model->initSoftAttribute($attName['attributeName']);
                    echo $form->labelEx($model, $attName['attributeName']);
                    echo $form->dropDownList($model, $attName['attributeName'], $attName['value'], array('prompt' => '----'));
                    echo $form->error($model, $attName['attributeName']);
                }
                if ($count % 2 == 0)
                    echo' </td></tr>';
                else
                    echo'</td>';
            }
        }else {
            if (!isset($model->cims)) {
                $model->initSoftAttribute('cims');
                $model->cims = array();
            } else if ($model->cims != [] && $model->cims != null) {
                // $model->cims = array('A22', 'C52', 'B12');
                foreach ($model->cims as $idCim => $cim) {
                    $count++;
                    if ($count % 2 == 0)
                        echo' <td>';
                    else
                        echo'<tr><td width="50%">';
                    echo $form->textField($model, "cims[$idCim][code]", array('readonly' => true, 'style' => 'width:150px;margin-right : 15px'));

                    echo CHtml::submitButton('Suppr.', array('id' => 'delcim_' . $idCim, 'name' => 'delcim_' . $idCim, 'class' => 'delCimButton', 'onclick' => 'return false;'));
                    if ($count % 2 == 0)
                        echo' </td></tr>';
                    else
                        echo'</td>';
                }
            }
        }

        echo '</table>';
        if ($id == 'codes_cim') {
            if ($this->action->id == 'update')
                echo CHtml::submitButton('Ajouter un code Cim', array('submit' => $this->createUrl("biobank/addCim", array('id' => $model->_id)), 'onclick' => '$("#addCimPopup").dialog("open");return false;', 'name' => 'addCim',));
            if ($this->action->id == 'create')
                $this->renderPartial('/site/_help_message', array('title' => 'Ajout de code CIM non disponible', 'content' => 'L\'ajout de codes CIM ne peut sse faire que si la biobanque a déjà été créée. La fonctionnalité est disponible dans la vue de mise à jour.'));
        }
        if ($id == 'other') {
            echo CHtml::Button('Add field', array('id' => 'addButton', 'onclick' => '$("#addFieldPopup").dialog("open");return false;'));
        }
        echo '</div>';
    }
    ?>
    <div class="row buttons">

        <?php echo '<hr style="height: 5px;
border-style: solid;
border-color: black;
border-width: 1px 0 0 0;
border-radius: 5px;">'; ?>
        <?php echo CHtml::resetButton('Cancel', array('id' => 'resetButton')); ?>
        <?php //save is disabled echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php
    $this->endWidget();
    ?>
</div><!-- form -->

