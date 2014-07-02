<?php
/* @var $this ConnecteurController */
/* @var $dataProvider CArrayDataProvider */
?>

<h1>Mes connecteurs</h1>
<div style="min-width: 450px;min-height: 140px;display: inline-block">
    <?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
    ));
    ?>
</div>