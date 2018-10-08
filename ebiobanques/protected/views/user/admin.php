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

<h1><?php echo Yii::t('common', 'manage_users') ?></h1>



<?php
echo CHtml::link(Yii::t('common', 'create_user'), Yii::app()->createUrl('user/create'));
?>
<br>
<?php echo CHtml::link(Yii::t('common', 'advancedsearch'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'ajaxUpdate' => false,
    'columns' => array(
        array('name' => 'prenom', 'header' => Yii::t('common', 'firstname'), 'value' => '$data->getPrenom()'),
        array('name' => 'nom', 'header' => Yii::t('common', 'lastname')),
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
        array('name' => 'email', 'header' => Yii::t('common', 'email')),
        array('header' => Yii::t('common', 'profil'),
            'name' => 'profil',
            'value' => '$data->getProfil()'),
        array(
            'name' => Yii::t('common', 'inactive'),
            'type' => 'raw',
            'value' => 'CHtml::link($data->getActifLink()["label"],$data->getActifLink()["url"])'
        ),
        array('class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => array(
                'view' => array(
                    'url' => 'Yii::app()->createUrl("user/view",array("id"=>"$data->_id", "asDialog"=>1))'
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("user/update",array("id"=>"$data->_id", "asDialog"=>1))'
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("user/delete",array("id"=>"$data->_id"))'
                ),
            ),
        )
    ),
        )
);
?>

<h3 align="center">Profils utilisateurs</h3>
<?php
$this->widget(
        'chartjs.widgets.ChPie', array(
    'width' => 850,
    'height' => 300,
    'htmlOptions' => array(),
    'drawLabels' => true,
    'datasets' => array(
        array(
            "value" => $nbAdminSystUsers,
            "color" => "rgba(220,30, 70,1)",
            "label" => $nbAdminSystUsers . " " . Yii::t('common', 'system_admin')
        ),
        array(
            "value" => $nbAdminBbqUsers,
            "color" => "rgba(100,100,220,1)",
            "label" => $nbAdminBbqUsers . " " . Yii::t('common', 'biobank_admin')
        ),
        array(
            "value" => $nbStandardUsers,
            "color" => "rgba(20,120,120,1)",
            "label" => $nbStandardUsers . " " . Yii::t('common', 'standard_user')
        ),
        array(
            "value" => $nbInactifUsers,
            "color" => "rgba(66,66,66,1)",
            "label" => $nbInactifUsers . " utilisateurs non validés"
        ),
    ),
    'options' => array()
        )
);

