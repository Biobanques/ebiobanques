<?php
/*
 * $this = mainController
 * $model = BiocapForm
 */



Yii::app()->clientScript->registerScript('search', "

$('.search-form form').submit(function(){



	$('#result-grid').yiiGridView('update', {
       // type : 'post',
	data: $(this).serialize()
	});
$('.test').load('" . Yii::app()->createUrl('main/getSummarySearch') . "',
     $(this).serialize(),
     function(data) {
          $('.test').html(data);
          return false;
     }

   );
	return false;
});

");
?>

<div class="search-form">
    <?php
    $this->renderPartial('_searchForm', array('model' => $model));
    ?>
</div>
<div class='test'>
    Vos critères de recherche :
    <ul>
        <?php
//        if (!empty($_SESSION['criteria']->getConditions()))
//            foreach ($_SESSION['criteria']->getConditions()as $condition) {
//                echo '<li>';
//                //print_r($condition);
//                echo 'cond1';
//                echo '</li>';
//            }
        ?>
    </ul>

</div>

<?php
$this->renderPartial('_display', array('dataProvider' => $dataProvider));
/*
$conn = Yii::app()->mongodb->getConnection();
$db = $conn->biocap;
$db->sampleCollected->createIndex(array('$**' => 'text'));
$result = $db->command(
        array(
            'text' => 'sampleCollected', //this is the name of the collection where we are searching
            'search' => 'vivant Ostéosarcome', //the string to search
            'limit' => 155, //the number of results, by default is 1000
//            'project' => Array(//the fields to retrieve from db
//                'Sexe' => 1,
//                'Type_echant' => 0,
//                'Date_prlvt' => 0,
//                'Statut_vital' => 0,
//            )
        )
);
print_r($result);
*/