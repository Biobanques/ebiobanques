<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);
?>

<h1>Create User</h1>
<div style="float:left;width:700px;">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>