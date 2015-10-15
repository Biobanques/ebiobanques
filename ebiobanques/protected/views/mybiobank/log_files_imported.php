<h1>Historique des fichiers importés</h1>
<div style="float: left; width: 700px;" >
<?php
$this->widget('zii.widgets.grid.CGridView', ['id' => 'file-imported-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        'id',
        'extraction_id',
        'given_name',
        'date_import',
    ),
   ]);
?>
</div>