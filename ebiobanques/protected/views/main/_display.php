<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::app()->clientScript->registerScript('popupdetails', "
function popupdetails(){
window.open(this.href,
'_blank',
'left=100,top=100,width=1024px,height=768,toolbar=0,resizable=1,location=no'
);
return false;

}
");


$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'result-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        array('header' => 'Groupe ICCC', 'name' => 'group_iccc', 'value' => '$data["_id"]["' . CommonTools::AGGREGATEDFIELD1 . '"] != null ? $data["_id"]["' . CommonTools::AGGREGATEDFIELD1 . '"] : "Inconnu"'),
        array('header' => 'Sous groupe ICCC', 'name' => 'sous_group_iccc', 'value' => '$data["_id"]["' . CommonTools::AGGREGATEDFIELD2 . '"] != null ? $data["_id"]["' . CommonTools::AGGREGATEDFIELD2 . '"] : "Inconnu"')
        ,
        array('name' => 'patientPartialTotal', 'header' => 'Nombre de tumeurs', 'value' => '$data["value"]["patientPartialTotal"]'),
        array('name' => 'CR', 'header' => 'Consentement recherche', 'value' => '$data["value"]["CR"]'),
        array('name' => 'IE', 'header' => 'Inclus dans une étude', 'value' => '$data["value"]["IE"]'),
        array(
            'header' => 'Détails',
            'class' => 'CButtonColumn',
            'template' => '{details}',
            'buttons' => array
                (
                'details' => array
                    (
                    'label' => 'View',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/zoom.png',
                    'url' => 'Yii::app()->createUrl("main/details", array("group_iccc"=>$data["_id"]["' . CommonTools::AGGREGATEDFIELD1 . '"],"sous_group_iccc"=>$data["_id"]["' . CommonTools::AGGREGATEDFIELD2 . '"]))',
                    'click' => 'popupdetails',
                )
            ),
            'visible' => Yii::app()->user->isAdmin()
        )
    )
        )
);
?>


