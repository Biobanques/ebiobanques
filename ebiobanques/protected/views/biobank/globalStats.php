<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h1><?php echo Yii::t('common', 'global_stats'); ?></h1><?php
echo count(Biobank::model()->findAll())." ". Yii::t('common', 'biobank_ base'). ".";
echo '<br>';
echo '<br>';
echo $counts->nbFields ." ". Yii::t('common', 'fields_biobank');
echo '<br>';
echo '<br>';

echo Yii::t('common', 'average_rate_completeness') ." ". round($counts->avgGCR * 100, 2) . "%.";
echo '<br>';
//foreach ($dataProvider as $key => $value) {
//
?>
<!--<div style='display: inline-block;width: 40%;padding: 4px;margin: 2px;'>-->
        <!--<span style='font-weight: bold;display: inline;'>Nom du champ :-->
<?php
//            echo $key;
?>
<!--</span>-->
<!--<div style='text-align: right'>Renseigné dans //-->
<?php
//            echo $value['nbIds'];
?>
<!--biobanques, soit-->
<?php
//            echo round($value['GCR'] * 100, 2) . "%";
?>
<!--        </div>

    </div>-->
<?php
//}
$this->widget('ext.highcharts.HighchartsWidget', array(
    'scripts' => array(
        // 'modules/exporting',
        'themes/grid-light',
    ),
    'options' => array(
        'chart' => array(
            'type' => 'bar',
            'height' => '1500'
        ),
        'plotOptions' => array(
            'series' => array(
                'stacking' => 'percent'
            )
        ),
        'title' => array(
            'text' =>  Yii::t('common', 'rate_completeness') ,
        ),
        'xAxis' => array(
            'categories' => $datas['categories'],
        ),
        'series' => array(
            array(
                'type' => 'column',
                'name' => Yii::t('common', 'missing_fields'),
                'data' => $datas['missingFields'],
                'color' => 'js:Highcharts.getOptions().colors[4]',
            ),
            array(
                'type' => 'column',
                'name' => Yii::t('common', 'present_fields'),
                'data' => $datas['presentFields'],
                'color' => 'js:Highcharts.getOptions().colors[6]',
            ),
//            array(
//                'type' => 'spline',
//                'name' => 'Average',
//                'data' => array(3, 2.67, 3, 6.33, 3.33),
//                'marker' => array(
//                    'lineWidth' => 2,
//                    'lineColor' => 'js:Highcharts.getOptions().colors[3]',
//                    'fillColor' => 'white',
//                ),
//            ),
//            array(
//                'type' => 'pie',
//                'name' => 'Total consumption',
//                'data' => array(
//                    array(
//                        'name' => 'Jane',
//                        'y' => 13,
//                        'color' => 'js:Highcharts.getOptions().colors[0]', // Jane's color
//                    ),
//                    array(
//                        'name' => 'John',
//                        'y' => 23,
//                        'color' => 'js:Highcharts.getOptions().colors[1]', // John's color
//                    ),
//                    array(
//                        'name' => 'Joe',
//                        'y' => 19,
//                        'color' => 'js:Highcharts.getOptions().colors[2]', // Joe's color
//                    ),
//                ),
//                'center' => array(120, 80),
//                'size' => 100,
//            'showInLegend' => false,
//            'dataLabels' => array(
//                'enabled' => false,
//            ),
//            ),
        ),
    )
        )
);
