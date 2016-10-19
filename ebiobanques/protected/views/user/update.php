<?php
/* @var $this UserController */
/* @var $model User */
?>

<h1>Mise à jour de l'utilisateur <?php echo $model->getShortName(); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>