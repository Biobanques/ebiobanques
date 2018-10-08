<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('audit-trail-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Suivi des actions sur la base</h1>

<?php echo CHtml::link(Yii::t('buttons', 'advancedSearch'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'audit-trail-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		array('header' => $model->attributeLabels()["action"], 'name' => 'action'),
		array('header' => $model->attributeLabels()["model"], 'name' => 'model'),
                array('header' => $model->attributeLabels()["field"], 'name' => 'field'),
                array('header' => $model->attributeLabels()["old_value"], 'name' => 'old_value'),
                array('header' => $model->attributeLabels()["new_value"], 'name' => 'new_value', 'value' => '$data->getNewValue()'),
		array('header' => $model->attributeLabels()["stamp"], 'name' => 'stamp', 'value' => '$data->getTimestamp()'),
		array('header' => $model->attributeLabels()["user_id"], 'name' => 'user_id', 'value' => 'Yii::app()->user->getNomPrenomById($data->user_id)')
	),
)); ?>
