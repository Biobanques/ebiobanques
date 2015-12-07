<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*


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
        ),
    )
        )
);
