<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'result-grid',
    'dataProvider' => $model,
    //'filter' => $model,
    'columns' => array(
        '_id',
        'Sexe',
        'DDN'
    )
));
