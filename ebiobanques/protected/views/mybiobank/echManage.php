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
<h1><?php echo Yii::t('common','echManage')?></h1>
</div>
<p><?php echo Yii::t('common','msgAnnulModif');?></p>
<div style="clear:both;"/>
<?php 
$this->widget('application.widgets.menu.CMenuBarLineWidget', array('links'=>array(),'controllerName'=>'searchEchantillon','searchable'=>true));
?>

<div class="search-form" style="display:none">
<style>select{width: 10em}</style>
<?php $this->renderPartial('_search_samples',array(
		'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'echantillon-grid',
	'dataProvider'=>$model->searchByBiobank(Yii::app()->user->biobank_id),
//	'filter'=>$model,
	'columns'=>array(
		'id_depositor',
		'id_sample',
		'consent_ethical',
		'gender',
		'age',
		'collect_date',
		'storage_conditions',
		'consent',
		//'supply',
		//'max_delay_delivery',
		'detail_treatment',
		'disease_outcome',
		//'authentication_method',
		'patient_birth_date',
		//'tumor_diagnosis',
		//'biobank_id',
		//'file_imported_id',
		array('header'=>'notes','value'=>'$data->getShortNotes()'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
