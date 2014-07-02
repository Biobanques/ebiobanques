<?php
/* @var $this EchantillonController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Echantillons',
);

$this->menu=array(
	array('label'=>'Create Echantillon', 'url'=>array('create')),
	array('label'=>'Manage Echantillon', 'url'=>array('admin')),
);
?>

<h1>Echantillons</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
