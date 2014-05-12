<?php
/* @var $this EchantillonController */
/* @var $model Echantillon */

$this->breadcrumbs=array(
	'Echantillons'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Echantillon', 'url'=>array('index')),
	array('label'=>'Create Echantillon', 'url'=>array('create')),
	array('label'=>'View Echantillon', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Echantillon', 'url'=>array('admin')),
);
?>

<h1>Update Echantillon <?php echo $model->biobank_id.'_'.$model->id_sample; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>