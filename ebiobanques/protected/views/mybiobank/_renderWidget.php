

<?php

$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => 'Taux de complétude détaillé : ' . $attributeName,
    'htmlOptions' => array(
        'style' => 'height:280px'
    )
));
$this->widget('application.widgets.charting.CLinesChartWidget', array(
//    $this->beginWidget('application.widgets.charting.CLinesChartWidget', array(
    'id' => 'attributeChart_' . $attributeName,
    'title' => '',
    'data' => $datas,
    'width' => 550,
    'height' => 230,
    'enableCompare' => true,
    'theme' => $theme,
));
$this->endWidget();
?>


