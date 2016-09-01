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

<div>
    <?php echo Yii::t('common', 'catalog_intro') ?>
</div>
<br>
<?php
$this->widget('application.widgets.menu.CMenuBarLineWidget', array('links' => array(), 'controllerName' => 'searchCatalog', 'searchable' => true));
?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search_catalog_easymode', array(
        'modelForm' => $smartForm,
    ));
    ?>
</div><!-- search-form -->

<?php

$imageSelect = CHtml::image(Yii::app()->baseUrl . '/images/table-icone.png', Yii::t('common', 'prefsSelect'));
//if lang = en display pathologies_en, otherwise pathologies
$pathosName = "pathologies";
if(Yii::app()->language=="en"){
    $pathosName = "pathologies_en";
}
$this->Widget('bootstrap.widgets.TbGridView', array(
    'id' => 'biobanks-grid',
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->searchCatalogue($smartForm->keywords),
    'columns' => array(
        array('name' => 'identifier','htmlOptions'=>array('width'=>'40'),
 'header' => $model->getAttributeLabel('identifier')),
        array('name' => 'name','htmlOptions'=>array('width'=>'150'), 'header' => $model->getAttributeLabel('name')),
        array('name' => 'city','htmlOptions'=>array('width'=>'20'), 'header' => $model->address->getAttributeLabel('city'), 'value' => '$data->address->city'),
        array('name' => $pathosName,'htmlOptions'=>array('width'=>'120'), 'header' => $model->getAttributeLabel($pathosName)),
        array('name' => 'contact', 'value' => '$data->getShortContact()', 'header' => $model->getAttributeLabel('contact_id')),
        array('name'=>'diagnosis_available','htmlOptions'=>array('width'=>'150'),'header' => $model->getAttributeLabel('diagnosis_available')),
        array('name'=>'keywords_MeSH','header' => $model->getAttributeLabel('keywords_MeSH')),
               
//button to view biobank infos
        array('class' => 'CButtonColumn',
            'template' => '{view}',
            'buttons' => array(
                'view' => array(
                    'url' => 'Yii::app()->createUrl("catalog/view",array("id"=>"$data->_id", "asDialog"=>1))',
                    'click' => 'function(){window.open(this.href,"_blank","left=100,top=100,width=1024,height=768,toolbar=yes, scrollbars=yes, resizable=yes, location=no");return false;}'
                ),
            ),
        ))
));
?>


