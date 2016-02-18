<?php
/* @var $this BiobankController */
/* @var $model Biobank */

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
    'diagnosis_available',
    array('name' => 'address', 'value' => nl2br($model->getAddress()), 'type' => 'raw',)
);


$attributes_facult = array(
    array('name' => 'website', 'value' => $model->getFormattedWebsite(), 'type' => 'raw',),
);
$attributes_qualite = array(
    'cert_ISO9001',
    'cert_NFS96900',
    'cert_autres',
    'observations',
);

$attributes_diagnostic = array(
    'A00-B99',
    'C00-D48',
    'D50-D89',
    'E00-E90',
    'F00-G99',
    'H00-H59',
    'H60-H95',
    'I00-I99',
    'J00-J99',
    'K00-K93',
    'L00-L99',
    'M00-M99',
    'N00-N99',
    'O00-O99',
    'P00-P96',
    'Q00-Q99',
    'R00-Z99'
);
$attributes_samples = array('sampling_disease_group', 'sampling_disease_group_code', 'keywords_MeSH');
$attributes_samples_nbs = array('nbs_dna_samples_affected',
    'nbs_dna_samples_relatives',
    'nbs_cdna_samples_affected',
    'nbs_cdna_samples_relatives', 'nbs_wholeblood_samples_affected'
    , 'nbs_wholeblood_samples_relatives', 'nbs_bloodcellisolates_samples_affected', 'nbs_bloodcellisolates_samples_relatives'
    , 'nbs_serum_samples_affected', 'nbs_serum_samples_relatives'
    , 'nbs_plasma_samples_affected', 'nbs_plasma_samples_relatives', 'nbs_fluids_samples_affected'
    , 'nbs_fluids_samples_relatives', 'nbs_tissuescryopreserved_samples_affected', 'nbs_tissuescryopreserved_samples_relatives'
    , 'nbs_tissuesparaffinembedded_samples_affected', 'nbs_tissuesparaffinembedded_samples_relatives'
    , 'nbs_celllines_samples_affected', 'nbs_celllines_samples_relatives', 'nbs_other_samples_affected'
    , 'nbs_other_samples_relatives');
$attributes_diagnostic_availables = array();
$attributes_samples_availables = array();
$attributes = $model->getAttributes();
foreach ($attributes as $attributeName => $attributeValue) {
    if (in_array($attributeName, $attributes_diagnostic)) {
        $attributes_diagnostic_availables[] = array('name' => $attributeName, 'value' => $attributeValue);
    }
    if (in_array($attributeName, $attributes_samples)) {
        $attributes_samples_availables[] = array('name' => $attributeName, 'value' => $attributeValue);
    }
    if (in_array($attributeName, $attributes_samples_nbs)) {
        $attributes_samples_nbs_availables[] = array('name' => $attributeName, 'value' => $attributeValue);
    }
}
?>
<div id="biobank_oblig" style="width:550px;float:left;">
    <h3>Informations de la biobanque</h3>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes_oblig
    ));
    ?>
</div>
<div id="contact" style="padding-left:20px;width:330px;float:left;">
    <h3>Informations de contact</h3>
    <?php
    $contact = $model->getContact();
    if (isset($contact)) {
        $attributes_contact = array(
            array('name' => 'last_name', 'value' => $contact->last_name),
            array('name' => 'first_name', 'value' => $contact->first_name),
            array('name' => 'phone', 'value' => $contact->phone),
            array('name' => 'email', 'value' => $contact->email),
            array('name' => 'address', 'value' => $contact->adresse),
            array('name' => 'postal_code', 'value' => $contact->code_postal),
            array('name' => 'city', 'value' => $contact->ville),
        );
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => $attributes_contact
        ));
    } else {
        echo "No contact as been defined for this biobank";
    }
    ?>
</div>
<div style="clear:both;"></div>
<div id="biobank_facult" >
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes_facult
    ));
    ?>
</div>
<div  id="biobank_qualite">
    <h3>Informations qualité</h3>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes_qualite
    ));
    ?>
</div>
<div id="biobank_other">
    <h3>Pathologies disponibles ( Codification CIM)</h3>
    <?php
    $imageTick = CHtml::image(Yii::app()->baseUrl . '/images/tick.png', "available");
    $cut = 9;
    //affichage des pathaologies en ligne
    echo "<table><tr>";
    $i = 0;
    foreach ($attributes_diagnostic_availables as $attDiag) {
        echo "<div style=\"width:60px;height:35px;border:1px solid black;padding-left:3px;margin-right:2px;margin-top:2px;padding-top:3px;float:left;\"><b>" . $attDiag['name'] . "</b>";
        echo "<div style=”display:table-cell; vertical-align:middle; text-align:center”><center>";
        if (isset($attDiag['value']) && $attDiag['value'] != "/") {
            echo $imageTick;
        }
        echo "</center></div>";
        echo"</div>";
        $i++;
        if ($i == $cut)
            echo "<div style=\"clear:both;\"></div>";
    }
    echo "<div style=\"clear:both;\"></div>";
    ?>
</div>
<div id="biobank_other">
    <h3>Résumé des échantillons biologiques</h3>
    <h4>Généralités</h4>
    <?php
    $attributes_samples_availables[] = array('name' => 'sampling_practice', 'value' => $model->getSamplingPractice());
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => $attributes_samples_availables
    ));
    ?>
    <div><br></div>
    <h4>Nombre d'échantillons collectés</h4>
    <div class="grid-nbs"><b>Types</b></div><div class="grid-nbs-nb"><b>Affected</b></div><div class="grid-nbs-nb"><b>Relatives</b></div>
    <div style="clear:both;"></div>
    <?php
    foreach ($attributes_samples_nbs_availables as $attNbs) {
        //si suffixe = affected on ecrit sur la ligne de titre sinon on skip
        if (!strpos($attNbs['name'], "affected") == false) {
            $ar = $model->attributeLabels();
            $name = str_replace("affected", "", $ar[$attNbs['name']]);
            echo "<div class=\"grid-nbs\"><b>" .
            $name . "</b></div>";
        }
        echo "<div class=\"grid-nbs-nb\">";
        if (isset($attNbs['value']) && $attNbs != "") {
            echo number_format(intval($attNbs['value']), 0, ',', ' ');
        } else {
            echo "-";
        }
        echo "</div>";
        if (strpos($attNbs['name'], "affected") == false) {
            echo "<div style=\"clear:both;\"></div>";
        }
    }
    ?>
</div>