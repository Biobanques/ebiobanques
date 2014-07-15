<?php

/*

 * Page de test
 *
 * find(array('$text' => array('$search' => "pulmonaire")));
 */
/*
  $datas = Yii::app()->mongodb->getDBInstance()->echantillon->find(array('$text' => array('$search' => 'tissu')));
  $i = 0;
  echo count($datas);
  while ($datas->hasNext()) {
  $datas->next();
  $i++;
  if ($i % 1000 == 0)
  echo $i . '<br>';
  }
  $criteria = new EMongoCriteria;

  $criteria->addCond('$text', '==', array('$search' => 'pulmonaire'));
  //$dataProvider = new EMongoDocumentDataProvider('Sample', array('$text' => array('$search' => 'tissu')));
  $dataProvider = new EMongoDocumentDataProvider('Sample', array('criteria' => $criteria));
  $this->widget('zii.widgets.grid.CGridView', array(
  'id' => 'biobanks-grid',
  'dataProvider' => $dataProvider,
  'columns' => array(
  'gender',
  'age',
  'id_sample'
  )
  // 	'filter'=>$model,
  )); */
$this->widget('application.extensions.editMe.widgets.ExtEditMe', array('name' => 'test', 'filebrowserImageUploadUrl' => '/ebiobanques/index.php?r=site/dashboard'));
?>