<?php
/* @var $this UserController */
/* @var $model User */
?>

<h1><?php echo Yii::t('common','userUpdate')." ".$model->getShortName(); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>