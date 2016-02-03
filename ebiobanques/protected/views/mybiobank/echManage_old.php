<?php
//recharge le tableau d'affichage des échantillons après envoi du formulaire de recherche avancée
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#echantillon-grid').yiiGridView('update', {
		data: $(this).serialize()
	});

	return false;
});

");
?>

<div style="float:left;width:700px;padding-left:5px;padding-right:5px;padding-top:10px">
    <h1><?php echo Yii::t('common', 'echManage') ?></h1>
</div>
<p><?php echo Yii::t('common', 'msgAnnulModif'); ?></p>
<div style="clear:both;"/>
<?php
$this->widget('application.widgets.menu.CMenuBarLineWidget', array('links' => array(), 'controllerName' => 'searchEchantillon', 'searchable' => true));
?>

<div class="search-form" style="display:none">
    <style>select{width: 10em}</style>
    <?php
    $this->renderPartial('_search_samples', array(
        'model' => $model,
        'biobank_id' => $biobank_id
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'echantillon-grid',
    'htmlOptions' => array('style' => 'overflow: auto;width:720px',),
    'dataProvider' => $model->searchByBiobank($biobank_id),
//	'filter'=>$model,
    'columns' => array(
        array('header' => $model->getAttributeLabel('id_sample'), 'value' => '$data->id_sample'),
        array('header' => $model->getAttributeLabel('id_depositor'), 'value' => '$data->id_depositor'),
        array('header' => $model->getAttributeLabel('consent_ethical'), 'value' => '$data->consent_ethical'),
        array('header' => $model->getAttributeLabel('gender'), 'value' => '$data->gender'),
        array('header' => $model->getAttributeLabel('age'), 'value' => '$data->age'),
        array('header' => $model->getAttributeLabel('collect_date'), 'value' => '$data->collect_date'),
        array('header' => $model->getAttributeLabel('storage_conditions'), 'value' => '$data->storage_conditions'),
        array('header' => $model->getAttributeLabel('consent'), 'value' => '$data->consent'),
        array('header' => $model->getAttributeLabel('supply'), 'value' => '$data->supply'),
        array('header' => $model->getAttributeLabel('max_delay_delivery'), 'value' => '$data->max_delay_delivery'),
        array('header' => $model->getAttributeLabel('detail_treatment'), 'value' => '$data->detail_treatment'),
        array('header' => $model->getAttributeLabel('disease_outcome'), 'value' => '$data->disease_outcome'),
        array('header' => $model->getAttributeLabel('authentication_method'), 'value' => '$data->authentication_method'),
        array('header' => $model->getAttributeLabel('patient_birth_date'), 'value' => '$data->patient_birth_date'),
        array('header' => $model->getAttributeLabel('tumor_diagnosis'), 'value' => '$data->tumor_diagnosis'),
//        array('header' => $model->getAttributeLabel('biobank_id'), 'value' => '$data->biobank_id'),
//        array('header' => $model->getAttributeLabel('file_imported_id'), 'value' => '$data->file_imported_id'),
        array('header' => $model->getAttributeLabel('notes'), 'value' => '$data->getShortNotes() '),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
