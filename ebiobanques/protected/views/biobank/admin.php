<?php
/* @var $this BiobankController */
/* @var $model Biobank */
$flashRoute = Yii::app()->createAbsoluteUrl('biobank/deleteFlashMsg');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#biobank-grid').yiiGridView('update', {
		data: $(this).serialize(),
	});
	return false;
});

$('#XLSExport').click(function(){
$('#dialog').dialog('open');
	return false;

});
");
?>
<h1>Gestion des Biobanques</h1>
<div class="row">
    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">
        Choix des champs à exporter
    </button>
    <!--modal window to select items-->
    <div id="myModal"  class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Choix des champs à exporter </h4>
                </div>
                <div class="modal-body">
                    <div class="prefs-form" >
                        <?php
                        $this->renderPartial('_exportedFieldsForm'
                        );
                        ?>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<div class="row">
    <div class="col-md-3"> 
        <?php echo CHtml::link('Biobanks global stats', 'globalStats'); ?>
    </div>
    <div class="col-md-3">
        <?php echo CHtml::link('Create biobank', 'create'); ?>
    </div>
    <div class="col-md-3">
        <?php echo CHtml::link('Manage fields of biobanks directory', array('/uploadForm/uploadAll')); ?>
    </div>
</div>
<?php
$this->widget('application.widgets.menu.CMenuBarLineWidget', array('links' => array(), 'controllerName' => 'biobank', 'searchable' => true));
?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'biobank-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array('name' => 'name', 'header' => $model->getAttributeLabel('name')),
        array('name' => 'identifier', 'header' => $model->getAttributeLabel('identifier')),
        array('name' => 'collection_name', 'header' => $model->getAttributeLabel('collection_name'), 'value' => '$data->getShortValue("collection_name")'),
        array('name' => 'contact_search', 'value' => '$data->getShortContact()', 'header' => $model->getAttributeLabel('contact_id')),
        array(
            'class' => 'CLinkColumn',
            'labelExpression' => '$data->getRoundedTauxCompletude()."%"',
            'urlExpression' => 'Yii::app()->createUrl("biobank/detailledStats",array("id"=>$data->_id))',
            'htmlOptions' => array('style' => "text-align:center"),
            'header' => $model->getAttributeLabel('TauxCompletude')
        ),
        array(
            'class' => 'CLinkColumn',
            'label' => Yii::t('myBiobank', 'seeAsAdmin'),
            'urlExpression' => 'Yii::app()->createUrl("mybiobank/index",array("id"=>$data->_id))',
            'htmlOptions' => array('style' => "text-align:center"),
            'header' => Yii::t('myBiobank', 'seeAsAdminHeader')
        ),
        array(
            'class' => 'CLinkColumn',
            'label' => Yii::t('myBiobank', 'uploadConnector'),
            'urlExpression' => 'Yii::app()->createUrl("connecteur/upload",array("biobank_id"=>$data->_id))',
            'htmlOptions' => array('style' => "text-align:center"),
            'header' => Yii::t('myBiobank', 'uploadConnectorHeader')
        ),
        array(
            'class' => 'CButtonColumn',
            'afterDelete' => 'function(link,success,data){$("#flashMessages").html(data)}',
        ),
    ),
));
?>
