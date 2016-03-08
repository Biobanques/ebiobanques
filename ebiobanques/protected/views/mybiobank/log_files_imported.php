<h1>Historique des fichiers importés</h1>
<div style="float: left; width: 700px;" >
    <?php
    $this->widget('zii.widgets.grid.CGridView', ['id' => 'file-imported-grid',
        'dataProvider' => $model->search(),
        'columns' => array(
            '_id',
            'extraction_id',
            'given_name',
            'date_import', array(
                'class' => 'CButtonColumn',
                'template' => '{report}',
                'buttons' => array(
                    'report' => array
                        (
                        'label' => 'Get xls import report',
                        'imageUrl' => Yii::app()->request->baseUrl . '/images/printer.png',
                        'url' => 'Yii::app()->createUrl("uploadedFile/viewReport", array("id"=>$data->_id))',
                        'visible' => '$data->getFromXls()',
                    ),
                )
            )
        ),
    ]);
    ?>
</div>