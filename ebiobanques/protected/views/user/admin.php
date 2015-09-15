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
<div class='help'>
    <div class="help-title">
        Gestion des utilisateurs de l'application
    </div>
    <div class="help-content">
        <p> Vous pouvez ici ajouter, modifier ou supprimer les utilisateurs de l'application, ainsi que les activer ou les désactiver. </p>
        <p>Vous pouvez faire une recherche précise sur les utilisateurs, ou filtrer et trier directement dans le tableau de résultats.
        </p>
    </div>
</div>

<?php echo CHtml::link(Yii::t('common', 'advancedsearch'), '#', array('class' => 'search-button')); ?>
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
    'filter' => $model,
    'columns' => array(
        'prenom',
        'nom',
        'login',
//        array('header' => Yii::t('sample', 'biobank_id'),
//            'value' => '$data->getBiobankName()'),
        'email',
        array('header' => "Profil",
            'value' => '$data->getProfil()'),
        array('class' => 'CButtonColumn',
            'template' => '{valider}{desactiver}',
            'buttons' => array(
                'valider' => array(
                    'label' => 'Valider',
                    'url' => 'Yii::app()->createUrl("user/validate",array("userId"=>"$data->_id"))',
                    'visible' => '$data->inactif==1'
                ),
                'desactiver' => array(
                    'label' => 'Désactiver',
                    'url' => 'Yii::app()->createUrl("user/desactivate",array("userId"=>"$data->_id"))',
                    'visible' => '$data->inactif==0'
                )
            )),
        $columns [] = array('class' => 'CButtonColumn',
    'template' => '{view}{update}{delete}',
    'buttons' => array(
        'view' => array(
            'url' => 'Yii::app()->createUrl("user/view",array("userId"=>"$data->_id"))',
        //'click'=>'function(){window.open(this.href,"_blank","left=100,top=100,width=760,height=650,toolbar=0,resizable=1, location=no");return false;}'
        ),
        'update' => array(
            'url' => 'Yii::app()->createUrl("user/update",array("userId"=>"$data->_id"))',
        //'click'=>'function(){window.open(this.href,"_blank","left=100,top=100,width=760,height=650,toolbar=0,resizable=1, location=no");return false;}'
        ),
        'delete' => array(
            'url' => 'Yii::app()->createUrl("user/delete",array("userId"=>"$data->_id"))',
// 				'click'=>'function(){window.open(this.href,"_blank","left=100,top=100,width=760,height=650,toolbar=0,resizable=1, location=no");return false;}'
        ),
    ),
        )
    ))
);
?>
