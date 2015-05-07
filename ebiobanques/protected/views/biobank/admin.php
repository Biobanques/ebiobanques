<?php
/* @var $this BiobankController */
/* @var $model Biobank */

$this->breadcrumbs = array(
    'Biobanks' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Biobank', 'url' => array('index')),
    array('label' => 'Create Biobank', 'url' => array('create')),
);

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


<?php echo CHtml::link('Create biobank', 'create'); ?>
<br>
<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
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
        'id',
        array('name' => 'identifier', 'header' => $model->getAttributeLabel('identifier')),
        array('name' => 'name', 'header' => $model->getAttributeLabel('name')),
        array('name' => 'collection_id', 'header' => $model->getAttributeLabel('collection_id'), 'value' => '$data->getShortValue("collection_id")'),
        array('name' => 'contact', 'value' => '$data->getShortContact()', 'header' => $model->getAttributeLabel('contact_id')),
        array('name' => 'collection_name', 'header' => $model->getAttributeLabel('collection_name'), 'value' => '$data->getShortValue("collection_name")'), array(
            'class' => 'CLinkColumn',
            'label' => Yii::t('myBiobank', 'seeAsAdmin'),
            'urlExpression' => 'Yii::app()->createUrl("mybiobank/index",array("id"=>$data->id))',
            'htmlOptions' => array('style' => "text-align:center"),
            'header' => Yii::t('myBiobank', 'seeAsAdminHeader')
        ),
        array(
            'class' => 'CLinkColumn',
            'label' => Yii::t('myBiobank', 'uploadConnector'),
            'urlExpression' => 'Yii::app()->createUrl("connecteur/upload",array("biobank_id"=>$data->id))',
            'htmlOptions' => array('style' => "text-align:center"),
            'header' => Yii::t('myBiobank', 'seeAsAdminHeader')
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
