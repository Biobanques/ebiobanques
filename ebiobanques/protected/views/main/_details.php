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
        array('name' => 'ident_pat_biocap', 'header' => "Identifiant BIOCAP"),
        array('name' => 'age', 'header' => "Age"),
        array('name' => 'Sexe', 'header' => "Sexe"),
        array('name' => 'diagPpal', 'header' => "Diagnostic principal"),
        array('name' => 'Type_prlvt', 'header' => "Type de prélèvement", 'value' => '$data["Type_prlvt"]!=""?$data["Type_prlvt"]:"Inconnu"'),
        array('name' => 'Mode_prlvt', 'header' => "Mode de prélèvement"),
        array('name' => 'Type_echant', 'header' => "Type d'échantillon"),
    )
        )
);
?>