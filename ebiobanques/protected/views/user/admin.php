<?php
/* @var $this UserController */
/* @var $model User */



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Gestion des utilisateurs</h1>


<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<br>
<?php
echo CHtml::link('Créer un utilisateur', Yii::app()->createUrl('user/create'));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'ajaxUpdate' => false,
    'columns' => array(
        array('name' => 'prenom', 'header' => Yii::t('common', 'firstname'), 'value' => '$data->getPrenom()'),
        'nom',
        array(
            'name' => 'inscription_date',
            'header' => Yii::t('common', 'inscription_date'),
            'value' => '$data->getInscription_date()',
            //search on date not available yet
            'filter' => false
        ),
        array('header' => Yii::t('sample', 'biobank_id'),
            'name' => 'biobank_id',
            'value' => '$data->getBiobankName()',
            //search on biobank name not available yet
            'filter' => false
        ),
        'email',
        array('header' => "Profil",
            'name' => 'profil',
            'value' => '$data->getProfil()'),
        array(
            'name' => 'inactif',
            'type' => 'raw',
            'value' => 'CHtml::link($data->getActifLink()["label"],$data->getActifLink()["url"])'
        ),
//        array('class' => 'CButtonColumn',
//            'header' => 'actif',
//            'template' => '{valider}{desactiver}',
//            'buttons' => array(
//                'valider' => array(
//                    'label' => 'Valider',
//                    'url' => 'Yii::app()->createUrl("user/validate",array("id"=>"$data->_id"))',
//                    'visible' => '$data->inactif==1'
//                ),
//                'desactiver' => array(
//                    'label' => 'Désactiver',
//                    'url' => 'Yii::app()->createUrl("user/desactivate",array("id"=>"$data->_id"))',
//                    'visible' => '$data->inactif==0'
//                )
//            )),
        array('class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => array(
                'view' => array(
                    'url' => 'Yii::app()->createUrl("user/view",array("id"=>"$data->_id", "asDialog"=>1))',
                //'click'=>'function(){window.open(this.href,"_blank","left=100,top=100,width=760,height=650,toolbar=0,resizable=1, location=no");return false;}'
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("user/update",array("id"=>"$data->_id", "asDialog"=>1))',
                //'click'=>'function(){window.open(this.href,"_blank","left=100,top=100,width=760,height=650,toolbar=0,resizable=1, location=no");return false;}'
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("user/delete",array("id"=>"$data->_id"))',
// 				'click'=>'function(){window.open(this.href,"_blank","left=100,top=100,width=760,height=650,toolbar=0,resizable=1, location=no");return false;}'
                ),
            ),
        )
    ),
        )
);
?>
