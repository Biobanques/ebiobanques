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
'left=100,top=100,width=960px,height=650,toolbar=0,resizable=1,location=no'
);
return false;

}
");


$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'result-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        array('header' => 'groupe ICCC', 'value' => '$data["Type_lesionnel1_litteral"] != null ? $data["Type_lesionnel1_litteral"] : "Inconnu"')
        ,
        array('name' => 'total', 'header' => 'Total'),
        array('name' => 'CR', 'header' => 'Consentement recheche', 'value' => '$data["CR"].", soit ".round($data["CR"]/$data["total"]*100,2) ."%"'),
        array('name' => 'IE', 'header' => 'Inclus dans une étude', 'value' => '$data["IE"].", soit ".round($data["IE"]/$data["total"]*100,2) ."%"'),
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
                    'url' => 'Yii::app()->createUrl("main/details", array("iccc"=>$data["Type_lesionnel1_litteral"]))',
                    'click' => 'popupdetails',
                )
            ),
        //  'visible' => Yii::app()->user->isAdmin()
        )
    )
        )
);
?>


