<?php

$this->widget('ext.highcharts.HighmapsWidget', array(
    'options' => array(
        'title' => array(
            'text' => 'Highmaps basic demo',
        ),
        'mapNavigation' => array(
            'enabled' => true,
            'buttonOptions' => array(
                'verticalAlign' => 'bottom',
            )
        ),
        'colorAxis' => array(
            'min' => 0,
        ),
        'series' => array(
            array(
                'data' => array(
                    array(
                        "hc-key" => "fr-t",
                        "value" => 0
                    ),
                    array(
                        "hc-key" => "fr-h",
                        "value" => 1
                    ),
                    array(
                        "hc-key" => "fr-e",
                        "value" => 2
                    ),
                    array(
                        "hc-key" => "fr-r",
                        "value" => 3
                    ),
                    array(
                        "hc-key" => "fr-u",
                        "value" => 4
                    ),
                    array(
                        "hc-key" => "fr-n",
                        "value" => 5
                    ),
                    array(
                        "hc-key" => "fr-p",
                        "value" => 6
                    ),
                    array(
                        "hc-key" => "fr-o",
                        "value" => 7
                    ),
                    array(
                        "hc-key" => "fr-v",
                        "value" => 8
                    ),
                    array(
                        "hc-key" => "fr-s",
                        "value" => 9
                    ),
                    array(
                        "hc-key" => "fr-g",
                        "value" => 10
                    ),
                    array(
                        "hc-key" => "fr-k",
                        "value" => 11
                    ),
                    array(
                        "hc-key" => "fr-a",
                        "value" => 12
                    ),
                    array(
                        "hc-key" => "fr-c",
                        "value" => 13
                    ),
                    array(
                        "hc-key" => "fr-f",
                        "value" => 14
                    ),
                    array(
                        "hc-key" => "fr-l",
                        "value" => 15
                    ),
                    array(
                        "hc-key" => "fr-d",
                        "value" => 16
                    ),
                    array(
                        "hc-key" => "fr-b",
                        "value" => 17
                    ),
                    array(
                        "hc-key" => "fr-i",
                        "value" => 18
                    ),
                    array(
                        "hc-key" => "fr-q",
                        "value" => 19
                    ),
                    array(
                        "hc-key" => "fr-j",
                        "value" => 20
                    ),
                    array(
                        "hc-key" => "fr-m",
                        "value" => 21
                    ),
                    array(
                        "hc-key" => "fr-re",
                        "value" => 22
                    ),
                    array(
                        "hc-key" => "fr-yt",
                        "value" => 23
                    ),
                    array(
                        "hc-key" => "fr-gf",
                        "value" => 24
                    ),
                    array(
                        "hc-key" => "fr-mq",
                        "value" => 25
                    ),
                    array(
                        "hc-key" => "fr-gp",
                        "value" => 26
                    ),
                    array(
                        "value" => 27
                    )
                )
                ,
                'mapData' => 'js:Highcharts.maps["countries/fr/fr-all"]',
                'joinBy' => 'hc-key',
                'name' => 'Random data',
                'states' => array(
                    'hover' => array(
                        'color' => '#BADA55',
                    )
                ),
                'dataLabels' => array(
                    'enabled' => true,
                    'format' => '{point.name}',
                )
            )
        )
    )
        )
);


Yii :: app()->clientScript->registerScriptFile('//code.highcharts.com/mapdata/countries/fr/fr-all.js');
