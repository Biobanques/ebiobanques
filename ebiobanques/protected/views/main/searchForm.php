<?php
/*
 * $this = mainController
 * $model = BiocapForm
 */



Yii::app()->clientScript->registerScript('search', "


$('#SwitchLinkLF').click(function(){

$('#light_form').toggle();
$('#detailled_form').toggle();

});
$('#SwitchLinkAF').click(function(){

$('#light_form').toggle();
$('#detailled_form').toggle();
});

$('#LSFSubmit').click(function(){
$('#light_search-form').submit();
return false;
});
$('#SFSubmit').click(function(){
$('#search-form').submit();
return false;
});
$('#light_form form').submit(function(){

	$('#result-grid').yiiGridView('update', {
       // type : 'post',
	data: $('#light_search-form').serialize()+'&type=light'
	});
$('#summary').load('" . Yii::app()->createUrl('main/search') . " #summary',
     $('#light_search-form').serialize()+'&type=light'
   );
	return false;
});
$('#detailled_form form').submit(function(){

	$('#result-grid').yiiGridView('update', {
       // type : 'post',
	data: $('#search-form').serialize()+'&type=advanced'
	});
$('#summary').load('" . Yii::app()->createUrl('main/search') . " #summary',
     $('#search-form').serialize()+'&type=advanced'
   );
	return false;
});

");
?>

<div class="search-form"  id="light_form">
    <?php
    echo "<p>" . CHtml::link("Utiliser le formulaire de recherche avancé", "#", array('id' => 'SwitchLinkLF')) . "<p>";

    $this->renderPartial('_lightSearchForm', array('model' => $lightModel));
    ?>
</div>
<div class="search-form" id="detailled_form" style="display: none ">
    <?php
    echo "<p>" . CHtml::link("Utiliser le formulaire de recherche simplifié", "#", array('id' => 'SwitchLinkAF')) . "<p>";
    $this->renderPartial('_searchForm', array('model' => $model));
    ?>
</div>

<div id='summary'>

    <?php
    echo $totalPatientSelected > 0 ?
            "Au total, $totalPatientSelected patients ont été trouvés avec les critères de recherche suivants, sur les $totalPatient présents en base : " : "Aucun patient trouvé avec ces critères, merci de les modifier : " . "<br>";
    echo '<ul>';
    if ($flag == 0)
        $summaryModel = $model;
    if ($flag == 1)
        $summaryModel = $lightModel;
    foreach ($summaryModel->attributes as $attributeName => $attributeValue) {
        if (is_string($attributeValue) && $attributeValue != "" && $attributeValue != 'inconnu') {
            switch ($attributeName) {

                case 'mode_request':
                    echo "<li>" . $summaryModel->getAttributeLabel($attributeName) . " : " . RequestTools::getModesList()[$attributeValue] . ",</li>";
                    break;
                case 'topoOrganeType':
                    if ($summaryModel->topoOrganeField1 != null && $summaryModel->topoOrganeField1 != "")
                        echo "<li>" . $summaryModel->getAttributeLabel($attributeName) . " : " . $attributeValue, ",</li>";
                    break;
                case 'topoOrganeField':
                    break;
                case 'topoOrganeField1':
                    $value = $summaryModel->topoOrganeField1;
                    if ($summaryModel->topoOrganeField2 != null && $summaryModel->topoOrganeField2 != "")
                        $value.=" ou $summaryModel->topoOrganeField2";
                    if ($summaryModel->topoOrganeField3 != null && $summaryModel->topoOrganeField3 != "")
                        $value.=" ou $summaryModel->topoOrganeField3";
                    echo "<li>" . $summaryModel->getAttributeLabel($attributeName) . " : " . $value, ",</li>";
                    break;
                case 'topoOrganeField2':
                    break;
                case 'topoOrganeField3':
                    break;

                case 'morphoHistoType':
                    if ($summaryModel->morphoHistoField1 != null && $summaryModel->morphoHistoField1 != "")
                        echo "<li>" . $summaryModel->getAttributeLabel($attributeName) . " : " . $attributeValue, ",</li>";
                    break;
                case 'morphoHistoField':
                    break;
                case 'morphoHistoField1':
                    $value = $summaryModel->morphoHistoField1;
                    if ($summaryModel->morphoHistoField2 != null && $summaryModel->morphoHistoField2 != "")
                        $value.=" ou $summaryModel->morphoHistoField2";
                    if ($summaryModel->morphoHistoField3 != null && $summaryModel->morphoHistoField3 != "")
                        $value.=" ou $summaryModel->morphoHistoField3";
                    echo "<li>" . $summaryModel->getAttributeLabel($attributeName) . " : " . $value, ",</li>";
                    break;
                case 'morphoHistoField2':
                    break;
                case 'morphoHistoField3':
                    break;

                case 'iccc_group1':
                    echo "<li>" . $summaryModel->getAttributeLabel($attributeName) . " : " . $attributeValue . ", " . $summaryModel->getAttributeLabel('iccc_sousgroup1') . " : " . $summaryModel->iccc_sousgroup1 . ",</li>";
                    break;
                case 'iccc_group2':
                    echo "<li>" . $summaryModel->getAttributeLabel($attributeName) . " : " . $attributeValue . ", " . $summaryModel->getAttributeLabel('iccc_sousgroup2') . " : " . $summaryModel->iccc_sousgroup2 . ",</li>";
                    break;
                case 'iccc_group3':
                    echo "<li>" . $summaryModel->getAttributeLabel($attributeName) . " : " . $attributeValue . ", " . $summaryModel->getAttributeLabel('iccc_sousgroup3') . " : " . $summaryModel->iccc_sousgroup3 . ",</li>";
                    break;
                case 'iccc_group':
                    break;
                case 'iccc_sousgroup':
                    break;
                case 'iccc_sousgroup1':
                    break;
                case 'iccc_sousgroup2':
                    break;
                case 'iccc_sousgroup3':
                    break;

                default:
                    echo "<li>" . $summaryModel->getAttributeLabel($attributeName) . " : " . $attributeValue, ",</li>";
                    break;
            }
        }elseif (is_array($attributeValue)) {
            switch ($attributeName) {
                case 'evenement':
                    echo "<li>" . $summaryModel->getAttributeLabel($attributeName) . " : " . implode(' ou ', $summaryModel->evenement), ",</li>";
                    break;
                case 'mode_prelev':
                    echo "<li>" . $summaryModel->getAttributeLabel($attributeName) . " : " . implode(' ou ', $summaryModel->mode_prelev), ",</li>";
                    break;
                case 'type_prelev':
                    echo "<li>" . $summaryModel->getAttributeLabel($attributeName) . " : " . implode(' ou ', $summaryModel->type_prelev), ",</li>";

                    break;
                default:
                    echo "<li>" . $summaryModel->getAttributeLabel($attributeName) . " : <ul>";
                    foreach ($attributeValue as $arrName => $arrVal) {

                        echo "<li>" . $summaryModel->getAttributeLabel($attributeName . "[" . $arrName . "]") . " : " . ($arrVal == null ? '' : 'Oui'), ",</li>";
                    }
                    echo '</ul></li>';
            }
        }
    }

    echo '</ul>';
    ?>
</div>

<?php
$this->renderPartial('_display', array('dataProvider' => $dataProvider));
