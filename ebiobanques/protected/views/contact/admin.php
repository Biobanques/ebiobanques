<?php
/* @var $this ContactController */
/* @var $model Contact */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#contact-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Gestion des contacts</h1>



<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div>
<!-- search-form -->
<br><?php echo CHtml::link('Create new contact', Yii::app()->createUrl('contact/create')) ?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'contact-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array('name' => 'first_name', 'header' => $model->getAttributelabel('first_name')),
        array('name' => 'last_name', 'header' => $model->getAttributelabel('last_name')),
        array('name' => 'email', 'header' => $model->getAttributelabel('email')),
        array('name' => 'phone', 'header' => $model->getAttributelabel('phone')),
        array('name' => 'ville', 'header' => $model->getAttributelabel('ville')),
        array('name' => 'pays', 'header' => $model->getAttributelabel('pays')),
        array('name' => 'inactive', 'header' => $model->getAttributelabel('inactive')),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
