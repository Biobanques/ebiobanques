<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
  $this->widget('ext.highcharts.HighchartsWidget', array(
  'scripts' => array(
  'modules/exporting',
  'themes/grid-light',
  ),
  'options' => array(
  'chart' => array(
  'type' => 'bar'
  ),
  'title' => array(
  'text' => 'Stacked bar chart'
  ),
  'xAxis' => array(
  'categories' => ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
  ),
  'yAxis' => array(
  'min' => 0,
  'title' => array(
  'text' => 'Total fruit consumption'
  )
  ),
  'legend' => array(
  'reversed' => true
  ),
  'plotOptions' => array(
  'series' => array(
  'stacking' => 'normal'
  )
  ),
  'series' => [array(
  'name' => 'John',
  'data' => [5, 3, 4, 7, 2]
  ), array(
  'name' => 'Jane',
  'data' => [2, 2, 3, 2, 1]
  ), array(
  'name' => 'Joe',
  'data' => [3, 4, 4, 2, 5]
  )],
  )
  ));

 */
$this->widget('ext.highcharts.HighchartsWidget', array(
    'scripts' => array(
        // 'modules/exporting',
        'themes/grid-light',
    ),
    'options' => array(
        'chart' => array(
            'type' => 'bar'
        ),
        'plotOptions' => array(
            'series' => array(
                'stacking' => 'percent'
            )
        ),
        'title' => array(
            'text' => 'Combination chart',
        ),
        'xAxis' => array(
            'categories' => array('Statistiques de la biobanque ', 'Statistiques globales'),
        ),
//        'labels' => array(
//            'items' => array(
//                array(
//                    'html' => 'Total fruits consumption',
//                    'style' => array(
//                        'left' => '50px',
//                        'top' => '18px',
//                        'color' => 'js:(Highcharts.theme && Highcharts.theme.textColor) || \'black\'',
//                    ),
//                ),
//            ),
//        ),
        'series' => array(
            array(
                'type' => 'column',
                'name' => 'Champs manquants',
                'data' => array(round($stats['fieldsMissing']['totalRate'] * 100, 2), round((1 - $statsGlobales['avgGCR']) * 100, 2)),
                'color' => 'js:Highcharts.getOptions().colors[1]',
            ),
            array(
                'type' => 'column',
                'name' => 'Champs présents',
                'data' => array(round($stats['fieldsPresent']['totalRate'] * 100, 2), round($statsGlobales['avgGCR'] * 100, 2)),
                'color' => 'js:Highcharts.getOptions().colors[2]',
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
/*
$this->widget('ext.highcharts.HighchartsWidget', array(
    'scripts' => array(
        'modules/exporting',
        'themes/grid-light',
    ),
    'options' => array(
        'chart' => array(
            'type' => 'bar'
        ),
        'title' => array(
            'text' => 'Stacked bar chart'
        ),
        'xAxis' => array(
            'categories' => ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
        ),
        'yAxis' => array(
            'min' => 0,
            'title' => array(
                'text' => 'Total fruit consumption'
            )
        ),
        'legend' => array(
            'reversed' => true
        ),
        'plotOptions' => array(
            'series' => array(
                'stacking' => 'normal'
            )
        ),
        'series' => [array(
        'name' => 'John',
        'data' => [5, 3, 4, 7, 2]
            ), array(
                'name' => 'Jane',
                'data' => [2, 2, 3, 2, 1]
            ), array(
                'name' => 'Joe',
                'data' => [3, 4, 4, 2, 5]
            )],)));
*/