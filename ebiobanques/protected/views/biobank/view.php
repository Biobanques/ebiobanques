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
 $('#cims').click(function(){
  $('.testonglets').removeClass('active');
 $(this).addClass('active');
 $('.biobank_details').toggle(false);
 	$('#biobank_cims').toggle(true);
 	return false;
 });
 $('#sampling').click(function(){
  $('.testonglets').removeClass('active');
 $(this).addClass('active');
 $('.biobank_details').toggle(false);
 	$('#biobank_sampling').toggle(true);
 	return false;
 });
 $('#informatique').click(function(){
  $('.testonglets').removeClass('active');
 $(this).addClass('active');
 $('.biobank_details').toggle(false);
 	$('#biobank_info').toggle(true);
 	return false;
 });
  $('#partenaires').click(function(){
  $('.testonglets').removeClass('active');
 $(this).addClass('active');
 $('.biobank_details').toggle(false);
 	$('#biobank_partners').toggle(true);
 	return false;
 });
 $('#materiel').click(function(){
  $('.testonglets').removeClass('active');
 $(this).addClass('active');
 $('.biobank_details').toggle(false);
 	$('#biobank_material').toggle(true);
 	return false;
 });

 $('#reseau').click(function(){
  $('.testonglets').removeClass('active');
 $(this).addClass('active');
 $('.biobank_details').toggle(false);
 	$('#biobank_network').toggle(true);
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
    //array('name' => 'contact', 'value' => $model->getShortContact()),
    'diagnosis_available',
    array('name' => 'address', 'value' => nl2br($model->getAddress()), 'type' => 'raw',),
    array('name' => 'contact_resp', 'value' => nl2br($model->getContactResp()), 'type' => 'raw',),
    array('name' => 'responsable_op', 'value' => nl2br($model->getResponsableOp()), 'type' => 'raw',),
    array('name' => 'responsable_qual', 'value' => nl2br($model->getResponsableQual()), 'type' => 'raw',),
    array('name' => 'responsable_adj', 'value' => nl2br($model->getResponsableAdj()), 'type' => 'raw',),
        // 'responsible'
);

$attributes_facult = array(
    array('name' => 'website', 'value' => $model->getFormattedWebsite(), 'type' => 'raw',),
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
$cims = array('name' => 'cims', 'value' => nl2br(print_r($model->cims, true)), 'type' => 'raw',);

$attributes_sampling = array(
    'sampling_practice',
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


$attributes_info = array(
    'gest_software',
    'other_software',
    'connector_installed',
    'connector_version',
);
$attributes_network = [
    'networkAcronym',
    'NetworkCommonCharter',
    'NetworkCommonCollectionFocus',
    'NetworkCommonDataAccessPolicy',
    'NetworkCommonMTA',
    'NetworkCommonRepresentation',
    'NetworkCommonSampleAccessPolicy',
    'NetworkCommonSOPs',
    'NetworkCommonURL',
    'NetworkDescription',
    'NetworkJuridicalPerson',
    'NetworkName',
    'NetworkURL',
];




$attributes_partners = [

    'PartnerCharterSigned',
    'collaborationPartnersCommercial',
    'collaborationPartnersNonforprofit',
];


$attributes_material = [

    'materialStoredDNA',
    'materialStoredPlasma',
    'materialStoredSerum',
    'materialStoredTissueFFPE',
    'materialStoredTissueFrozen',
];
$attributes_other = array(
);
$definedAttributes = array_merge($attributes_oblig, $attributes_facult, $attributes_qualite, $cims, $attributes_info, $attributes_network, $attributes_partners, $attributes_material, array('_id', 'contact_id', 'address', 'website', 'contact_resp','responsable_op', 'responsable_qual', 'responsable_adj', 'vitrine', 'location', 'qualite', 'qualite_en'));
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
        <li class="testonglets" id="cims"><a href="#"> Codes CIM </a></li>
        <li class="testonglets" id="sampling"><a href="#"> Sampling </a></li>
        <li class="testonglets" id="informatique"><a href="#"> Informatique </a></li>
        <li class="testonglets" id="reseau"><a href="#"> Reseau </a></li>
        <li class="testonglets" id="partenaires"><a href="#"> Partenaires </a></li>
        <li class="testonglets" id="materiel"><a href="#"> Materiel </a></li>
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
<div class="biobank_details" id="biobank_cims" style="display: none">

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => new CArrayDataProvider($model->cims, array('keyField' => 'code',
                //  'pagination' => false
                )),
        'columns' => array('code'
        )
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
<div class="biobank_details" id="biobank_sampling" style="display: none">

    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes_sampling
    ));
    ?>
</div>
<div class="biobank_details" id="biobank_partners" style="display: none">

    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes_partners
    ));
    ?>
</div>
<div class="biobank_details" id="biobank_material" style="display: none">

    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes_material
    ));
    ?>
</div>
<div class="biobank_details" id="biobank_network" style="display: none">

    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes_network
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