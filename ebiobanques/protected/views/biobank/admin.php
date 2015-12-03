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
		data: $(this).serialize()
	});
	return false;
});


");
?>

<h1>Gestion des Biobanques</h1>
<?php
?>


<?php echo CHtml::link('Biobanks global stats', 'globalStats'); ?>
<br>
<?php echo CHtml::link('Create biobank', 'create'); ?>
<br>
<?php echo CHtml::link('Manage fields of biobanks directory', array('/uploadForm/uploadAll')); ?>
<br>
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
    // 'ajaxUpdate' => false,
    'columns' => array(
        array('name' => 'name', 'header' => $model->getAttributeLabel('name')),
        array('name' => 'identifier', 'header' => $model->getAttributeLabel('identifier')),
//        array('name' => 'collection_id', 'header' => $model->getAttributeLabel('collection_id'), 'value' => '$data->getShortValue("collection_id")'),
        array('name' => 'collection_name', 'header' => $model->getAttributeLabel('collection_name'), 'value' => '$data->getShortValue("collection_name")'),
        array('name' => 'diagnosis_available', 'header' => $model->getAttributeLabel('diagnosis_available')),
        array('name' => 'contact', 'value' => '$data->getShortContact()', 'header' => $model->getAttributeLabel('contact_id')),
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
