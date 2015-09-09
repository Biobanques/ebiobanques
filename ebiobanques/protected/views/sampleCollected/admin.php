<?php
/* @var $this EchantillonController */
/* @var $model Echantillon */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#echantillon-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administration des échantillons</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'echantillon-grid',
    'htmlOptions' => array(
        'style' => 'overflow-x:auto;width:98%;'
    ),
    'filter' => $model,
    // 'sort' => $model,
    'dataProvider' => $model->search(),
    'columns' => array(
        array('name' => 'ident_pat_biocap', 'header' => "Identifiant BIOCAP"),
        'RNCE_Lib_GroupeICCC',
        'RNCE_Lib_SousGroupeICCC',
        'RNCE_Type_Evnmt2',
        'Statut_juridique',
        'RNCE_StatutVital',
        'Inclusion_protoc_therap',
        'Inclusion_protoc_rech',
        'Date_prlvt',
        'RNCE_DateNaissance',
        'Type_echant',
        'Type_prlvt',
        'Echant_tumoral',
        'Nature_echant',
        'Mode_preparation',
        'ADN_derive',
        'ARN_derive',
        'Serum',
        'Plasma',
        'Sang_total', array('class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => array(
                'view' => array(
                    'url' => 'Yii::app()->createUrl("sampleCollected/view",array("sampleId"=>"$data->_id"))',
                //'click'=>'function(){window.open(this.href,"_blank","left=100,top=100,width=760,height=650,toolbar=0,resizable=1, location=no");return false;}'
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("sampleCollected/update",array("sampleId"=>"$data->_id"))',
                //'click'=>'function(){window.open(this.href,"_blank","left=100,top=100,width=760,height=650,toolbar=0,resizable=1, location=no");return false;}'
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("sampleCollected/delete",array("sampleId"=>"$data->_id"))',
// 				'click'=>'function(){window.open(this.href,"_blank","left=100,top=100,width=760,height=650,toolbar=0,resizable=1, location=no");return false;}'
                ),
            ),
))));
?>
