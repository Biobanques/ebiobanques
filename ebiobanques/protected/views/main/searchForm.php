<?php
/*
 * $this = mainController
 * $model = BiocapForm
 */



Yii::app()->clientScript->registerScript('search', "

$('.search-form form').submit(function(){



	$('#result-grid').yiiGridView('update', {
       // type : 'post',
	data: $(this).serialize()
	});
$('#summary').load('" . Yii::app()->createUrl('main/search') . " #summary',
     $(this).serialize()
   );
	return false;
});

");
?>

<div class="search-form">
    <?php
    $this->renderPartial('_searchForm', array('model' => $model));
    ?>
</div>

<div id='summary'>

    <?php
    echo $totalPatientSelected > 0 ?
            "Au total, $totalPatientSelected patients ont été trouvés avec les critères de recherche suivants, sur les $totalPatient présents en base : " : "Aucun patient trouvé avec ces critères, merci de les modifier : " . "<br>";
    echo '<ul>';

    foreach ($model->attributes as $attributeName => $attributeValue) {
        if (is_string($attributeValue) && $attributeValue != "" && $attributeValue != 'inconnu') {
            switch ($attributeName) {
                case 'topoOrganeType':
                    if ($model->topoOrganeField1 != null && $model->topoOrganeField1 != "")
                        echo "<li>" . $model->getAttributeLabel($attributeName) . " : " . $attributeValue, ",</li>";
                    break;
                case 'topoOrganeField1':
                    $value = $model->topoOrganeField1;
                    if ($model->topoOrganeField2 != null && $model->topoOrganeField2 != "")
                        $value.=" ou $model->topoOrganeField2";
                    if ($model->topoOrganeField3 != null && $model->topoOrganeField3 != "")
                        $value.=" ou $model->topoOrganeField3";
                    echo "<li>" . $model->getAttributeLabel($attributeName) . " : " . $value, ",</li>";
                    break;
                case 'topoOrganeField2':
                    break;
                case 'topoOrganeField3':
                    break;

                case 'morphoHistoType':
                    if ($model->morphoHistoField1 != null && $model->morphoHistoField1 != "")
                        echo "<li>" . $model->getAttributeLabel($attributeName) . " : " . $attributeValue, ",</li>";
                    break;
                case 'morphoHistoField1':
                    $value = $model->morphoHistoField1;
                    if ($model->morphoHistoField2 != null && $model->morphoHistoField2 != "")
                        $value.=" ou $model->morphoHistoField2";
                    if ($model->morphoHistoField3 != null && $model->morphoHistoField3 != "")
                        $value.=" ou $model->morphoHistoField3";
                    echo "<li>" . $model->getAttributeLabel($attributeName) . " : " . $value, ",</li>";
                    break;
                case 'morphoHistoField2':
                    break;
                case 'morphoHistoField3':
                    break;

                case 'iccc_group1':
                    echo "<li>" . $model->getAttributeLabel($attributeName) . " : " . $attributeValue . ", " . $model->getAttributeLabel('iccc_sousgroup1') . " : " . $model->iccc_sousgroup1 . ",</li>";
                    break;
                case 'iccc_group2':
                    echo "<li>" . $model->getAttributeLabel($attributeName) . " : " . $attributeValue . ", " . $model->getAttributeLabel('iccc_sousgroup2') . " : " . $model->iccc_sousgroup2 . ",</li>";
                    break;
                case 'iccc_group3':
                    echo "<li>" . $model->getAttributeLabel($attributeName) . " : " . $attributeValue . ", " . $model->getAttributeLabel('iccc_sousgroup3') . " : " . $model->iccc_sousgroup3 . ",</li>";
                    break;
                case 'iccc_group':
                    break;
                case 'iccc_sousgroup1':
                    break;
                case 'iccc_sousgroup2':
                    break;
                case 'iccc_sousgroup3':
                    break;

                default:
                    echo "<li>" . $model->getAttributeLabel($attributeName) . " : " . $attributeValue, ",</li>";
                    break;
            }
        }elseif (is_array($attributeValue)) {
            switch ($attributeName) {
                case 'evenement':
                    echo "<li>" . $model->getAttributeLabel($attributeName) . " : " . implode(' ou ', $model->evenement), ",</li>";
                    break;
                case 'mode_prelev':
                    echo "<li>" . $model->getAttributeLabel($attributeName) . " : " . implode(' ou ', $model->mode_prelev), ",</li>";
                    break;
                case 'type_prelev':
                    echo "<li>" . $model->getAttributeLabel($attributeName) . " : " . implode(' ou ', $model->type_prelev), ",</li>";

                    break;
                default:
                    echo "<li>" . $model->getAttributeLabel($attributeName) . " : <ul>";
                    foreach ($attributeValue as $arrName => $arrVal) {

                        echo "<li>" . $model->getAttributeLabel($attributeName . "[" . $arrName . "]") . " : " . ($arrVal == null ? '' : 'Oui'), ",</li>";
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
