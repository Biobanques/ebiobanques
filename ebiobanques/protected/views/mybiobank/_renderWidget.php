

<?php

$this->widget('application.widgets.charting.CLinesChartWidget', array(
//    $this->beginWidget('application.widgets.charting.CLinesChartWidget', array(
    'id' => 'attributeChart_' . $attributeName,
    'title' => 'Taux de complétude détaillé : ' . $attributeName,
    'data' => $datas,
    'width' => 550,
    'height' => 230,
    'enableCompare' => true,
    'theme' => $theme,
));
?>


