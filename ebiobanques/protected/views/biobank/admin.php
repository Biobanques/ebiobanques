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

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

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
        array('name' => 'collection_id', 'header' => $model->getAttributeLabel('collection_id')),
        array('name' => 'contact', 'value' => '$data->getShortContact()', 'header' => $model->getAttributeLabel('contact_id')),
        array('name' => 'collection_name', 'header' => $model->getAttributeLabel('collection_name')),
        array(
            'class' => 'CButtonColumn',
        ),
        array(
            'class' => 'CLinkColumn',
            'label' => 'Voir comme administrateur',
            'urlExpression' => 'Yii::app()->createUrl("mybiobank/indexAdmin",array("id"=>$data->id))',
            'header' => 'Vue admin'
        ),
        array('name' => '',)
    ),
));
?>
