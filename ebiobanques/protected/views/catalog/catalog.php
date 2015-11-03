<?php
//recharge le tableau d'affichage des biobanques après envoi du formulaire de recherche avancée
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
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
    <h1><?php echo Yii::t('common', 'catalog') ?></h1>
</div>

<?php
$this->widget('application.widgets.menu.CMenuBarLineWidget', array('links' => array(), 'controllerName' => 'searchCatalog', 'searchable' => true));
?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search_catalog', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php

$imageSelect = CHtml::image(Yii::app()->baseUrl . '/images/table-icone.png', Yii::t('common', 'prefsSelect'));
    
$this->Widget('zii.widgets.grid.CGridView', array(
    'id' => 'biobanks-grid',
    'dataProvider' => $model->search(),
// 	'filter'=>$model,
    'columns' => array(
        array('name' => 'identifier', 'header' => $model->getAttributeLabel('identifier')),
        array('name' => 'name', 'header' => $model->getAttributeLabel('name')),
        array('name' => 'city', 'header' => $model->address->getAttributeLabel('city'), 'value' => '$data->address->city'),
        array('name' => 'collection_id', 'header' => $model->getAttributeLabel('collection_id')),
        array('name' => 'contact', 'value' => '$data->getShortContact()', 'header' => $model->getAttributeLabel('contact_id')),
        array('name'=>'diagnosis_available','header' => $model->getAttributeLabel('diagnosis_available')),
        array('name'=>'keywords_MeSH','header' => $model->getAttributeLabel('keywords_MeSH')),
               
//button to view biobank infos
        array('class' => 'CButtonColumn',
            'header' => CHtml::link($imageSelect, '#', array(
                'onclick' => '$("#selectPopup").dialog("open");return false;'
            )), // lien d'affichage de la popup
            'template' => '{view}',
            'buttons' => array(
                'view' => array(
                    'url' => 'Yii::app()->createUrl("catalog/view",array("id"=>"$data->_id", "asDialog"=>1))',
                    'click' => 'function(){window.open(this.href,"_blank","left=100,top=100,width=760,height=650,toolbar=yes, scrollbars=yes, resizable=yes, location=no");return false;}'
                ),
            ),
        ))
));
?>


