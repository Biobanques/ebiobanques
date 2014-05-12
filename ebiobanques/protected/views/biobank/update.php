<?php
/* @var $this BiobankController */
/* @var $model Biobank */

$this->breadcrumbs=array(
	'Biobanks'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Biobank', 'url'=>array('index')),
	array('label'=>'Create Biobank', 'url'=>array('create')),
	array('label'=>'View Biobank', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Biobank', 'url'=>array('admin')),
);
?>

<h1>Update Biobank <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>