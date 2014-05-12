<?php
/* @var $this FileImportedController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'File Importeds',
);

$this->menu=array(
	array('label'=>'Create FileImported', 'url'=>array('create')),
	array('label'=>'Manage FileImported', 'url'=>array('admin')),
);
?>

<h1>File Importeds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
