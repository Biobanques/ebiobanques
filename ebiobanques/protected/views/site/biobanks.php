<?php
//recharge le tableau d'affichage des biobanques après envoi du formulaire de recherche avancée
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#mapButton').click(function(){
	$('#mapContainer').toggle();
        if('#mapContainer:visible'){
        initMap();
        }
	return false;
});
$('.search-form form').submit(function(){
$('#biobanks-grid').yiiGridView('update', {
		data: $(this).serialize()
	});

	return false;
});
");
?>

<div class="page-header">
    <h1><?php echo Yii::t('common', 'biobanks') ?></h1>
</div>

<?php
$dataProvider = $model->search();
if (isset(CommonProperties::$GMAPS_KEY) && CommonProperties::$GMAPS_KEY != '') {
    echo CHtml::button(Yii::t('common', 'show map'), array('id' => 'mapButton'));
    ?>
    <div id='mapContainer' style='display: none'><?php
        $this->renderPartial('_map');
        ?>
    </div>
    <?php
}else
{
    echo "No Map available. Contact admin to solve this problem.";
}
$this->widget('application.widgets.menu.CMenuBarLineWidget', array('links' => array(), 'controllerName' => 'searchBiobank', 'searchable' => true));
?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->Widget('zii.widgets.grid.CGridView', array(
    'id' => 'biobanks-grid',
    'dataProvider' => $dataProvider,
// 	'filter'=>$model,
    'columns' => array(
        array('name' => 'identifier', 'header' => $model->getAttributeLabel('identifier')),
        array('name' => 'name', 'header' => $model->getAttributeLabel('name')),
        array('name' => 'city', 'header' => $model->address->getAttributeLabel('city'), 'value' => '$data->address->city'),
        array('name' => 'collection_id', 'header' => $model->getAttributeLabel('collection_id')),
        array('name' => 'contact', 'value' => '$data->getShortContact()', 'header' => $model->getAttributeLabel('contact_id')),
        array(
            'class' => 'CLinkColumn',
            'labelExpression' => 'isset($data->vitrine)&&$data->vitrine!=null?"Voir le site vitrine":null',
            'urlExpression' => '$data->getVitrineLink()',
            'htmlOptions' => array('style' => "text-align:center",),
            'linkHtmlOptions' => array('target' => 'blank'),
            'header' => 'Site vitrine'
        )
    )
));
?>
