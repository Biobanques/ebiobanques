<?php
/* @var $this BiobankController */
/* @var $model Biobank */

$this->breadcrumbs = array(
    'Biobanks' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Biobank', 'url' => array('index')),
    array('label' => 'Manage Biobank', 'url' => array('admin')),
);
?>

<h1>Create Biobank</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>