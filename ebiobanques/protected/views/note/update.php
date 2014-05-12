<?php
/* @var $this NoteController */
/* @var $model Note */

$this->breadcrumbs=array(
	'Notes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Note', 'url'=>array('index')),
	array('label'=>'Create Note', 'url'=>array('create')),
	array('label'=>'View Note', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Note', 'url'=>array('admin')),
);
?>

<h1>Update Note <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>