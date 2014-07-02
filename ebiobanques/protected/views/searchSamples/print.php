<?php
/* @var $this EchantillonController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Echantillons',
);
?>

<h1>Echantillons</h1>

<?php
//$this->widget('zii.widgets.CListView', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
//));


$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'sample-grid',
    'dataProvider' => $dataProvider,
    'enablePagination' => false,
    'columns' => $columns,
));
?>
