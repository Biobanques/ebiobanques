<?php
/* @var $this BiobankController */
/* @var $model Biobank */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerScript('create', "

 $('#facult').click(function(){
 $('.testonglets').removeClass('active');
 $(this).addClass('active');
 $('.form_menu').toggle(false);
 	$('#form_facult').toggle(true);
 	return false;
 });
 $('#qualite').click(function(){
  $('.testonglets').removeClass('active');
 $(this).addClass('active');
 $('.form_menu').toggle(false);
 	$('#form_qualite').toggle(true);
 	return false;
 });
 $('#informatique').click(function(){
  $('.testonglets').removeClass('active');
 $(this).addClass('active');
  $('.form_menu').toggle(false);
 	$('#form_info').toggle(true);
 	return false;
 });
 $('#other').click(function(){
  $('.testonglets').removeClass('active');
 $(this).addClass('active');
  $('.form_menu').toggle(false);
 	$('#form_other').toggle(true);
 	return false;
 });
 $('#addField').submit(function(){
var wrapper = $('#form_other');

                //AJOUTER LES VALIDATIONS DE CHAMPS + REMPLACEMENT DE CARACTERES SPECIAUX DANS LE CONTENU


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
        <select id="newFieldType" type="" name="fieldType" >
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
?>

<?php
/**
 * Mettre les listes d'attributs dans le modele
 */
$attributes_oblig = array(
    'identifier',
    'name',
    'collection_name',
    'collection_id',
    'biobank_class',
    'diagnosis_available',
    array('attributeName' => 'contact_id', 'value' => Contact::model()->getArrayContacts()),
);

$attributes_facult = array(
    'website',
    'vitrine',
    'folder_reception',
    'folder_done',
    'date_entry',
    'passphrase',
    'longitude',
    'latitude',
);
$attributes_qualite = array(
    'cert_ISO9001',
    'cert_NFS96900',
    'cert_autres',
    'observations',
);
$attributes_info = array(
    array('attributeName' => 'gest_software', 'value' => CommonTools::getSoftwareList()),
    'other_software',
    array('attributeName' => 'connector_installed', 'value' => array('Oui' => 'Oui', 'Non' => 'Non')),
    'connector_version',
);

$attributes_other = array();
$definedAttributes = array_merge($attributes_oblig, $attributes_facult, $attributes_qualite, $attributes_info, array('_id', 'contact_id', 'gest_software', 'connector_installed'));
$att = $model->getAttributes();

foreach ($att as $attributeName => $attributeValue)
    if (!in_array($attributeName, $definedAttributes)) {
        $attributes_other[] = $attributeName;
    }
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'biobank-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note"><?php echo Yii::t('common', 'ChampsObligatoires'); ?></p>

    <?php
    echo $form->errorSummary($model);
    ?>
    <table>
        <?php
        $count = 0;
        foreach ($attributes_oblig as $attName) {

            $count++;
            if ($count % 2 == 0)
                echo' <td>';
            else
                echo'<tr><td width="400px">';

            if (is_string($attName)) {
                ?>

                <?php echo $form->labelEx($model, $attName); ?>
                <?php echo $form->textField($model, $attName); ?>
                <?php
                echo $form->error($model, $attName);
            } elseif (is_array($attName)) {
                if (!isset($model->$attName['attributeName']))
                    $model->initSoftAttribute($attName['attributeName']);
                ?>
                <?php echo $form->labelEx($model, $attName['attributeName']); ?>
                <?php echo $form->dropDownList($model, $attName['attributeName'], $attName['value'], array('prompt' => '----')); ?>
                <?php
                echo $form->error($model, $attName['attributeName']);
            }
            if ($count % 2 == 0)
                echo' </td></tr>';
            else
                echo'</td>';
        }
        ?></table>

    <div id="menu">
        <ul id="onglets">
            <li class="testonglets active" id="facult"><?php echo CHtml::link('Facultatif', '#', array('class' => 'testonglets')); ?></li>
            <li class="testonglets" id="qualite"><a href="#"> Qualité </a></li>
            <li class="testonglets" id="informatique"><a href="#"> Informatique </a></li>
            <li class="testonglets" id="other"><a href="#"> Autres </a></li>
        </ul>
    </div>
    <div class="form form_menu" id="form_facult" >
        <table>
            <?php
            $count = 0;
            foreach ($attributes_facult as $attName) {

                $count++;
                if ($count % 2 == 0)
                    echo' <td>';
                else
                    echo'<tr><td width="400px">';

                if (is_string($attName)) {
                    if (!isset($model->$attName))
                        $model->initSoftAttribute($attName);
                    ?>

                    <?php echo $form->labelEx($model, $attName); ?>
                    <?php echo $form->textField($model, $attName); ?>
                    <?php
                    echo $form->error($model, $attName);
                } elseif (is_array($attName)) {
                    if (!isset($model->$attName['attributeName']))
                        $model->initSoftAttribute($attName['attributeName']);
                    ?>
                    <?php echo $form->labelEx($model, $attName['attributeName']); ?>
                    <?php echo $form->dropDownList($model, $attName['attributeName'], $attName['value'], array('prompt' => '----')); ?>
                    <?php
                    echo $form->error($model, $attName['attributeName']);
                }
                if ($count % 2 == 0)
                    echo' </td></tr>';
                else
                    echo'</td>';
            }
            ?></table>
    </div>
    <div class="form form_menu" id="form_qualite" style="display: none">
        <table>
            <?php
            $count = 0;
            foreach ($attributes_qualite as $attName) {

                $count++;
                if ($count % 2 == 0)
                    echo' <td>';
                else
                    echo'<tr><td width="400px">';

                if (is_string($attName)) {
                    if (!isset($model->$attName))
                        $model->initSoftAttribute($attName);
                    ?>

                    <?php echo $form->labelEx($model, $attName); ?>
                    <?php echo $form->textField($model, $attName); ?>
                    <?php
                    echo $form->error($model, $attName);
                } elseif (is_array($attName)) {
                    if (!isset($model->$attName['attributeName']))
                        $model->initSoftAttribute($attName['attributeName']);
                    ?>
                    <?php echo $form->labelEx($model, $attName['attributeName']); ?>
                    <?php echo $form->dropDownList($model, $attName['attributeName'], $attName['value'], array('prompt' => '----')); ?>
                    <?php
                    echo $form->error($model, $attName['attributeName']);
                }
                if ($count % 2 == 0)
                    echo' </td></tr>';
                else
                    echo'</td>';
            }
            ?></table>
    </div>
    <div class="form form_menu" id="form_info" style="display: none">
        <table>
            <?php
            $count = 0;
            foreach ($attributes_info as $attName) {

                $count++;
                if ($count % 2 == 0)
                    echo' <td>';
                else
                    echo'<tr><td width="400px">';

                if (is_string($attName)) {
                    if (!isset($model->$attName))
                        $model->initSoftAttribute($attName);
                    ?>

                    <?php echo $form->labelEx($model, $attName); ?>
                    <?php echo $form->textField($model, $attName); ?>
                    <?php
                    echo $form->error($model, $attName);
                }
                elseif (is_array($attName)) {
                    if (!isset($model->$attName['attributeName']))
                        $model->initSoftAttribute($attName['attributeName']);
                    ?>
                    <?php echo $form->labelEx($model, $attName['attributeName']); ?>
                    <?php echo $form->dropDownList($model, $attName['attributeName'], $attName['value'], array('prompt' => '----')); ?>
                    <?php
                    echo $form->error($model, $attName['attributeName']);
                }

                if ($count % 2 == 0)
                    echo' </td></tr>';
                else
                    echo'</td>';
            }
            ?></table>
    </div>

    <div class="form form_menu" id="form_other" style="display: none">
        <table>
            <?php
            $count = 0;
            foreach ($attributes_other as $attName) {

                $count++;
                if ($count % 2 == 0)
                    echo' <td>';
                else
                    echo'<tr><td width="400px">';

                if (is_string($attName)) {
                    if (!isset($model->$attName))
                        $model->initSoftAttribute($attName);
                    ?>

                    <?php echo $form->labelEx($model, $attName); ?>
                    <?php echo $form->textField($model, $attName); ?>
                    <?php
                    echo $form->error($model, $attName);
                } elseif (is_array($attName)) {
                    if (!isset($model->$attName['attributeName']))
                        $model->initSoftAttribute($attName['attributeName']);
                    ?>
                    <?php echo $form->labelEx($model, $attName['attributeName']); ?>
                    <?php echo $form->dropDownList($model, $attName['attributeName'], $attName['value'], array('prompt' => '----')); ?>
                    <?php
                    echo $form->error($model, $attName['attributeName']);
                }
                if ($count % 2 == 0)
                    echo' </td></tr>';
                else
                    echo'</td>';
            }
            ?></table>
        <?php echo CHtml::Button('Add field', array('id' => 'addButton', 'onclick' => '$("#addFieldPopup").dialog("open");return false;')); ?>
    </div>
    <div class="row buttons">

        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>

    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
