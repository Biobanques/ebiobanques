<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'result-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        array('header' => 'groupe ICCC', 'value' => '$data["Type_lesionnel1_litteral"] != null ? $data["Type_lesionnel1_litteral"] : "Inconnu"')
        ,
        'total',
        'CR',
        'IE',
        array(
            'class' => 'CButtonColumn',
            'template' => '{details}',
            'buttons' => array
                (
                'details' => array
                    (
                    'label' => 'View',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/zoom.png',
                    'url' => 'Yii::app()->createUrl("main/details", array("iccc"=>$data["Type_lesionnel1_litteral"]))',
                    'click' => 'function(){window.open(this.href,"_blank","left=100,top=100,width=960px,height=650,toolbar=0,resizable=1, location=no");return false;}'
                )
            )
        )
    )
        )
);
?>


