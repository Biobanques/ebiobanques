<?php
/* @var $this UserController */
/* @var $model User */



$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1><?php echo  Yii::t('common','user_view')." ".$model->nom." ".$model->prenom; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'_id',
		'prenom',
		'nom',
		'login',
		'password',
		'email',
		'telephone',
		'gsm',
                 array('name'=>'profil','value'=>$model->getProfil()),
		array('name'=>'statut','value'=>$model->getInactif()),
	),
)); ?>
