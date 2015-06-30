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
    echo $totalResult > 0 ? "Au total, $totalResult échantillons ont été trouvés avec les critères de recherche suivants : " : "Aucun échantillon trouvé avec ces critères, merci de les modifier : " . "<br>";
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
                default:
                    echo "<li>" . $model->getAttributeLabel($attributeName) . " : " . $attributeValue, ",</li>";
                    break;
            }
        }elseif (is_array($attributeValue)) {
            echo "<li>" . $model->getAttributeLabel($attributeName) . " : <ul>";
            foreach ($attributeValue as $arrName => $arrVal) {

                echo "<li>" . $model->getAttributeLabel($attributeName . "[" . $arrName . "]") . " : " . ($arrVal == null ? '' : 'Oui'), ",</li>";
            }
            echo '</ul></li>';
        }
    }

    echo '</ul>';
    ?>
</div>

<?php
$this->renderPartial('_display', array('dataProvider' => $dataProvider));
