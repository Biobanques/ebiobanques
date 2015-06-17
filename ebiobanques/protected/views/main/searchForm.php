<?php
/*
 * $this = mainController
 * $model = BiocapForm
 */
Yii::app()->clientScript->registerScript('search', "

$('.search-form form').submit(function(){
	$('#result-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="search-form">
    <?php
    $this->renderPartial('_searchForm', array('model' => $model));
    ?>
</div>
<?php
$this->renderPartial('_display', array('model' => $data));
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