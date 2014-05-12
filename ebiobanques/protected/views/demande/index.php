<?php
/* @var $this DemandeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Demandes',
);

$this->menu=array(
	array('label'=>'Create Demande', 'url'=>array('create')),
	array('label'=>'Manage Demande', 'url'=>array('admin')),
);
?>

<h1>Demandes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
