<?php
/* @var $this BiobankController */
/* @var $model Biobank */

Yii::app()->clientScript->registerScript('test', "

 $('#facult').click(function(){
 $('.testonglets').removeClass('active');
 $(this).addClass('active');
 $('.biobank_details').toggle(false);
 	$('#biobank_facult').toggle(true);
 	return false;
 });
 $('#qualite').click(function(){
  $('.testonglets').removeClass('active');
 $(this).addClass('active');
 $('.biobank_details').toggle(false);
 	$('#biobank_qualite').toggle(true);
 	return false;
 });
 $('#informatique').click(function(){
  $('.testonglets').removeClass('active');
 $(this).addClass('active');
 $('.biobank_details').toggle(false);
 	$('#biobank_info').toggle(true);
 	return false;
 });
 $('#other').click(function(){
  $('.testonglets').removeClass('active');
 $(this).addClass('active');
 $('.biobank_details').toggle(false);
 	$('#biobank_other').toggle(true);
 	return false;
 });

");
try {
    $logo = isset($model->activeLogo) && $model->activeLogo != null && $model->activeLogo != "" ? Logo::model()->findByPk(new MongoId($model->activeLogo)) : null;
} catch (Exception $ex) {
    $logo = null;
    Yii::app()->user->setFlash('error', 'An error occured with logo, unable to display it');
}
?>
<div class="logoHeader">
    <h1>View Biobank #<?php echo $model->id; ?></h1>
    <div class="logo">
        <?php
        if ($logo != null) {
            echo $logo->toHtml();
        }
        ?>
    </div>
</div>

<?php
$attributes_oblig = array(
    'identifier',
    'name',
    'collection_name',
    'collection_id',
    'biobank_class',
    array('name' => 'contact', 'value' => $model->getShortContact()),
    'diagnosis_available',
    array('name' => 'address', 'value' => nl2br($model->getAddress()), 'type' => 'raw',)
);

$attributes_facult = array(
    'website',
    //'vitrine',
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
    'gest_software',
    'other_software',
    'connector_installed',
    'connector_version',
);

$attributes_other = array(
);
$definedAttributes = array_merge($attributes_oblig, $attributes_facult, $attributes_qualite, $attributes_info, array('_id', 'contact_id', 'address', 'vitrine'));
$attributes = $model->getAttributes();
foreach ($attributes as $attributeName => $attributeValue)
    if (!in_array($attributeName, $definedAttributes)) {

        $attributes_other[] = array('name' => $attributeName, 'value' => $attributeValue);
    }
?>
<div id="biobank_oblig" >
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes_oblig
    ));
    ?>
</div>
<div id="menu">
    <ul id="onglets">
        <li class="testonglets active" id="facult"><?php echo CHtml::link('Facultatif', '#', array('class' => 'testonglets')); ?></li>
        <li class="testonglets" id="qualite"><a href="#"> Qualité </a></li>
        <li class="testonglets" id="informatique"><a href="#"> Informatique </a></li>
        <li class="testonglets" id="other"><a href="#"> Autres </a></li>
    </ul>
</div>
<div class="biobank_details" id="biobank_facult" >
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes_facult
    ));
    ?>
</div>
<div class="biobank_details" id="biobank_qualite" style="display: none">

    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes_qualite
    ));
    ?>
</div>
<div class="biobank_details" id="biobank_info" style="display: none">

    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes_info
    ));
    ?>
</div>
<div class="biobank_details" id="biobank_other" style="display: none">

    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes_other
    ));
    ?>
</div>