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
		data: $(this).serialize(),
                  type : 'post'

	});
	return false;
});
");
?>

<h1>Export des contacts</h1>



<?php echo CHtml::link('Recherche avancée', '#', array('class' => 'search-button')); ?>


<!-- search-form -->
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_searchForExport', array(
        'model' => $form,
        'cities' => $cities,
        'countries' => $countries,
        'biobanks' => $biobanks
    ));
    ?>
</div>

<br><br><?php
echo CHtml::button('export contacts', array('submit' => Yii::app()->createUrl('contact/exportXLS')));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'contact-grid',
    'dataProvider' => $dataProvider,
    'columns' => array(
        array('name' => 'last_name', 'header' => $model->getAttributelabel('last_name')),
        array('name' => 'first_name', 'header' => $model->getAttributelabel('first_name')),
        array('name' => 'email', 'header' => $model->getAttributelabel('email')),
        array('name' => 'phone', 'header' => $model->getAttributelabel('phone')),
        array('name' => 'adresse', 'header' => $model->getAttributelabel('adresse')),
        array('name' => 'code_postal', 'header' => $model->getAttributelabel('code_postal')),
        array('name' => 'ville', 'header' => $model->getAttributelabel('ville')),
        array('name' => 'pays', 'header' => $model->getAttributelabel('pays')),
    ),
));
?>
