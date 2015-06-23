<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'details-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        '_id'
    )
        )
);
?>