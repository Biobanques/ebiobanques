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

<div class='help'>
    <div class="help-title">
        Suivi des actions effectuées par les utilisateurs sur la base de données
    </div>
    <div class="help-content">
        <p> Vous pourrez ici suivre les actions effectuées par les utilisateurs sur la base de données. </p>
        <p>Vous pouvez faire une recherche précise sur les logs, ou filtrer et trier directement dans le tableau de résultats.
        </p>
    </div>
</div>

<?php echo CHtml::link(Yii::t('common', 'advancedsearch'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'audit-trail-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'action',
        'model',
        'field',
        'stamp',
        'user_id',
    ),
));
?>
