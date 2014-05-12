<?php
/* @var $this UserController */
/* @var $model User */
?>

<h1><?php echo Yii::t('common','subscribe');?></h1>

<?php echo $this->renderPartial('_subscribeForm', array('model'=>$model)); ?>