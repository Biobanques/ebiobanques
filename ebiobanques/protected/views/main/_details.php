<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'details-grid',
    'dataProvider' => $dataProvider,
    'htmlOptions' => array(
        'style' => 'overflow-x:auto;width:98%;'
    ),
    'columns' => array(
        array('name' => 'ident_pat_biocap', 'header' => "Identifiant BIOCAP"),
        'RNCE_Lib_GroupeICCC',
        'RNCE_Lib_SousGroupeICCC',
        'RNCE_Type_Evnmt2',
        'Statut_juridique',
        'RNCE_StatutVital',
        'Inclusion_protoc_therap',
        'Inclusion_protoc_rech',
        'Date_prlvt',
        'RNCE_DateNaissance',
        'Type_echant',
        'Type_prlvt',
        'Echant_tumoral',
        'Nature_echant',
        'Mode_preparation',
        'ADN_derive',
        'ARN_derive',
        'Serum',
        'Plasma',
        'Sang_total',
//        array('name' => 'age', 'header' => "Age"),
//        array('name' => 'Sexe', 'header' => "Sexe"),
//        array('name' => 'diagPpal', 'header' => "Diagnostic principal"),
//        array('name' => 'Type_prlvt', 'header' => "Type de prélèvement", 'value' => '$data["Type_prlvt"]!=""?$data["Type_prlvt"]:"Inconnu"'),
//        array('name' => 'Mode_prlvt', 'header' => "Mode de prélèvement"),
//        array('name' => 'Type_echant', 'header' => "Type d'échantillon"),
    )
        )
);
?>