<?php
/* @var $this BiobankController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Biobanks',
);

$this->menu=array(
	array('label'=>'Create Biobank', 'url'=>array('create')),
	array('label'=>'Manage Biobank', 'url'=>array('admin')),
);
?>

<h1>Biobanks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
