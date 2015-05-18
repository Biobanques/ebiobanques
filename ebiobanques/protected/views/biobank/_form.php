<?php
/* @var $this BiobankController */
/* @var $model Biobank */
/* @var $form CActiveForm */
$cancelRoute = Yii::app()->createAbsoluteUrl('biobank/admin');
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
 * Création des listes d'attributs à affciher dans les différentes parties
 * La liste $attributes_oblig représente la liste des attributs obligatoire, et doit être présente.
 * Elle ne doit pas être ajoutée à la liste d'onglets
 *
 * La liste $attributes_other regroupe tous les attributs non présents dans les autres listes. Elle doit être ajoutée en dernière à la liste d'onglets
 */
$attributes_oblig = array(
    'identifier',
    'name',
    'collection_name',
    'collection_id',
    'biobank_class',
    'diagnosis_available',
    array('attributeName' => 'contact_id', 'value' => Contact::model()->getArrayContacts()),
    'address'
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
$listOnglets['facultatif'] = $attributes_facult;

$attributes_qualite = array(
    'cert_ISO9001',
    'cert_NFS96900',
    'cert_autres',
    'observations',
);
$listOnglets['qualite'] = $attributes_qualite;

$attributes_info = array(
    array('attributeName' => 'gest_software', 'value' => CommonTools::getSoftwareList()),
    'other_software',
    array('attributeName' => 'connector_installed', 'value' => array('Oui' => 'Oui', 'Non' => 'Non')),
    'connector_version',
);
$listOnglets['info'] = $attributes_info;



$attributes_other = array();
$definedAttributes = array_merge($attributes_oblig, $attributes_facult, $attributes_qualite, $attributes_info, array('_id', 'contact_id', 'gest_software', 'connector_installed'));
$att = $model->getAttributes();

foreach ($att as $attributeName => $attributeValue)
    if (!in_array($attributeName, $definedAttributes)) {
        $attributes_other[] = $attributeName;
    }
$listOnglets['other'] = $attributes_other;
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
    /**
     * Affichage des attributs obligatoires
     */
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
                if (is_object($model->$attName)) {

                    foreach ($model->$attName->attributeNames() as $emAtt) {
                        $count++;
                        if ($count % 2 == 0)
                            echo' <td>';
                        else
                            echo'<tr><td width="400px">';
                        ?>

                        <?php echo $form->labelEx($model->$attName, $emAtt); ?>
                        <?php echo $form->textField($model->$attName, $emAtt); ?>
                        <?php
                        echo $form->error($model->$attName, $emAtt);
                    }
                } else {
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
    <?php
    /**
     * Création du menu à onglets
     */
    ?>
    <div id="menu">
        <ul id="onglets">
            <?php
            $active = 'active';
            foreach ($listOnglets as $id => $attributes) {
                echo "<li class='menuTab $active' id='$id'>";
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
        echo "<div class='TabForm' id='form_$id' $displayDisable >";
        echo '<table>';
        $count = 0;
        foreach ($attributes as $attName) {

            $count++;
            if ($count % 2 == 0)
                echo' <td>';
            else
                echo'<tr><td width="400px">';

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
        echo '</table>';
        if ($id == 'other') {
            echo CHtml::Button('Add field', array('id' => 'addButton', 'onclick' => '$("#addFieldPopup").dialog("open");return false;'));
        }
        echo '</div>';
    }
    ?>
    <div class="row buttons">
        <?php echo CHtml::resetButton('Cancel', array('id' => 'resetButton')); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php
    $this->endWidget();
    ?>
</div><!-- form -->

