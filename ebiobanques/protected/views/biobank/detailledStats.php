<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h1><?php echo "Statistiques détaillées de la biobanque $model->name" ?></h1>

<?php $this->renderPartial('_detailledCharts', array('stats' => $stats, 'statsGlobales' => $statsGlobales)) ?>
<h3 style="margin-top: 25px;margin-bottom: 5px">Taux de completude de la biobanque : </h3>

<?php echo round($stats['fieldsPresent']['totalRate'] * 100, 2) . "% des champs sont complétés. La moyenne des biobanques est de " . round($statsGlobales['avgGCR'] * 100, 2) . '%' ?>

<h3 style="margin-top: 25px;margin-bottom: 5px">Liste des champs manquants :</h3>
<ul>
    <?php
    // print_r($statsGlobales);
    foreach ($stats['fieldsMissing']['fields'] as $fieldMissing) {
        ?><li><?php
            echo $fieldMissing . ' - Statistiques globales des biobanques sur ce champ : ' . round($statsGlobales[$fieldMissing]['GCR'] * 100, 2) . '%';
            ?></li><?php
    }
    ?>
</ul>
<h3 style="margin-top: 25px;margin-bottom: 5px">Liste des champs renseignés :</h3>
<ul>
    <?php
    // print_r($statsGlobales);
    foreach ($stats['fieldsPresent']['fields'] as $fieldPresent) {
        ?><li><?php
            echo '' . $fieldPresent . ' - Statistiques globales des biobanques sur ce champ : ' . round($statsGlobales[$fieldPresent]['GCR'] * 100, 2) . '%';
            ?></li><?php
    }
    ?>
</ul>



<?php ?>
