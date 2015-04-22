<?php
//recharge le tableau d'affichage des contacts après envoi du formulaire de recherche avancée

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

<h1>Contacts</h1>


<?php
// echo CHtml::link(Yii::t('common','advancedsearch'),'#',array('class'=>'search-button'));
$this->widget('application.widgets.menu.CMenuBarLineWidget', array('links' => array(), 'controllerName' => 'searchContact', 'searchable' => true));
?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search_contacts', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'contact-grid',
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'columns' => array(
        array('header' => 'biobanque', 'value' => '$data->getBiobankName()'),
        array('name' => 'last_name', 'header' => $model->getAttributelabel('last_name')),
        array('name' => 'first_name', 'header' => $model->getAttributelabel('first_name')),
        array('name' => 'email', 'header' => $model->getAttributelabel('email')),
        array('name' => 'phone', 'header' => $model->getAttributelabel('phone')),
        array('name' => 'ville', 'header' => $model->getAttributelabel('ville')),
        array('name' => 'pays', 'header' => $model->getAttributelabel('pays')),
    ),
));
?>
