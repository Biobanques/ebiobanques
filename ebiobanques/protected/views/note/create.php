<?php
/* @var $this NoteController */
/* @var $model Note */

$this->breadcrumbs=array(
	'Notes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Note', 'url'=>array('index')),
	array('label'=>'Manage Note', 'url'=>array('admin')),
);
?>

<h1>Create Note</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>