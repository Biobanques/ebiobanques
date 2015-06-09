<?php
//recuperation des preferences d dattributs affiches du user
$prefs = Preferences::model()->findByAttributes(array(
    'id_user' => Yii::app()->user->id
        ));
if ($prefs == null) {
    $prefs = new Preferences ();
    $prefs->id_user = Yii::app()->user->id;
    $prefs->save();
} else {
    echo "Vous n'avez pas encore enregistré vos préférences de tableau.";
}
//recuperation des noms des attributs affichables des colonnes du grid
$prefsNames = Preferences::model()->attributeNames();
$scriptCB = '';
foreach ($prefsNames as $property) {
    if ($property != 'id_user') {
        $scriptCB = $scriptCB . '$(\'#Preferences_' . $property . '\').change(function(){
$(\'.col_' . $property . '\').toggle();
$(\'.prefs-form form\').submit();
return false;
});
'
        ;
    }
}
// recharge le tableau d'affichage des échantillons après envoi du formulaire de recherche avancée
Yii::app()->clientScript->registerScript('search', "
 $('.search-button').click(function(){
 	$('.search-form').toggle();
 	return false;
 });

$('.prefs-button').click(function(){
	$('.prefs-form').toggle();
	return false;
});

$('.search-form form').submit(function(){
	$('#sample-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
$('.prefs-form form').submit(function(){
	$('#sample-grid').yiiGridView('update', {
		data: $(this).serialize()
	});

	return false;
});
$scriptCB;
");
//
?>
<h1><?php echo Yii::t('common', 'searchsamples'); ?></h1>
<div style="margin: 5px;"><?php echo Yii::t('common', 'totalnumbersamples'); ?> : <b><?php echo $model->count(); ?></b>.<br>
    <?php
    $imageSelect = CHtml::image(Yii::app()->baseUrl . '/images/table-icone.png', Yii::t('common', 'prefsSelect'));
    ?>
    <script type="text/javascript">
        function addEchToDemand(id) {
            jQuery.ajax({
                'url': '<?php echo Yii::app()->createUrl("site/changerDemandeEchantillon") ?>',
                'data': {'id': id},
                'type': 'post',
                'cache': false,
                'success': printNbEchantillon
            });
        }
        function addAllEchToDemand() {
            var selectall = document.getElementsByName('selectionCB_all')[0];
            alert(selectall.checked);
            if (selectall.checked) {
                var obj = document.getElementsByName('selectionCB[]');
                for (var i = 0; i < obj.length; i++) {
                    jQuery.ajax({
                        'url': '<?php echo Yii::app()->createUrl("site/addDemandeAllEchantillon") ?>',
                        'data': {'id': obj[i].value},
                        'type': 'post',
                        'cache': false,
                        'success': printNbEchantillon
                    });
                }
            } else {
                var obj = document.getElementsByName('selectionCB[]');
                for (var i = 0; i < obj.length; i++) {
                    jQuery.ajax({
                        'url': '<?php echo Yii::app()->createUrl("site/removeDemandeAllEchantillon") ?>',
                        'data': {'id': obj[i].value},
                        'type': 'post',
                        'cache': false,
                        'success': printNbEchantillon
                    });
                }
            }
            alert(selectall.checked);
        }
        function createNewDemand() {
            jQuery.ajax({
                'url': '<?php echo Yii::app()->createUrl("site/newDemand") ?>',
                //'data':{'newDemand':'newDemand'},
                'type': 'post',
                'cache': false,
                'success': changeMessage,
                // 	 		'error': changeMessage(false)
            });
            $('#echantillon-grid').yiiGridView('update', {
                data: $(this).serialize()
            });


        }
        function printNbEchantillon(data) {
            $('.demandeMessage').html(data);
            //alert(data);
        }
    </script>
</div>
<br>
<div style="border:1px solid blueviolet;padding:3px;">
    <!--<img src=Yii::app()->baseUrl."/images/basket.png" alt="mon panier"/>-->
    <?php
    echo CHtml::image(yii::app()->baseUrl . "/images/basket.png", "mon panier");
    echo CHtml::link(Yii::t('common', 'choseDemand'), Yii::app()->createUrl('demande/chose', array_merge(array('id_user' => Yii::app()->user->id), isset($_GET['layout']) ? array('layout' => $_GET['layout']) : array())));
    ?>
<!--    <img src=Yii::app()->baseUrl."/images/basket_go.png" alt="finaliser mon panier" style="padding-left:10px;"/>-->
    <?php
    echo CHtml::image(yii::app()->baseUrl . "/images/basket_go.png", "finaliser mon panier");
    echo CHtml::link(Yii::t('common', 'proceedApplication'), Yii::app()->createUrl('demande/updateAndSend', array_merge(array('id' => Yii::app()->session['activeDemand'][0]->_id), isset($_GET['layout']) ? array('layout' => $_GET['layout']) : array())));
    ?>
    <?php
    $this->widget('application.widgets.HelpDivWidget', array(
        'id' => 'helpdDivPanier',
        'text' => Yii::t('help', 'remplirPanier'),
    ));
    ?>
</div>
<br>
<div>
    <?php
    $this->renderPartial('_search_smart_samples', array(
        'smartForm' => $smartForm
    ));
    ?>
</div>
<?php
$this->widget('application.widgets.menu.CMenuBarLineWidget', array(
    'links' => array(),
    'controllerName' => 'searchSamples',
    'searchable' => true,
));
?>
<div class="search-form" style="display: none">
    <?php
    $this->renderPartial('_search_samples', array(
        'model' => $model
    ));
    ?>
</div>
<!-- search-form -->

<?php
//widget de selection des colonnes à afficher
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'selectPopup',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Choix des colonnes ',
        'autoOpen' => false,
        'width' => '220px'
    ),
        // 'htmlOptions' => array('style' => 'display:none')
));
?>
<div class="prefs-form" >
    <?php
    $this->renderPartial('_prefs_settings', array(
        'model' => $prefs
    ));
    ?>
</div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');

$columns = array();
$columns [] = array(
    'class' => 'CCheckBoxColumn',
    'id' => 'selectionCB',
    'headerHtmlOptions' => array(
        'onchange' => 'addAllEchToDemand()'
    ),
    'checkBoxHtmlOptions' => array(
        'onchange' => 'addEchToDemand(this.value)'
    ),
    'selectableRows' => 2,
    'checked' => '$data->isInDemand()'
);
//columns count displayed. if <1 then display a minimum
$countDisplayedColumns;

/**
 * fonction pour preparer une colonne a ajouter dans le grid des colonnes
 */
function addColumn($property, $header, $value, $visibility) {
    return array(
        'class' => 'DataColumn',
        'name' => $property,
        'id' => 'col_' . $property,
        'value' => $value,
        'header' => $header,
        'htmlOptions' => array(
            'class' => "col_$property",
            'style' => $visibility
        ),
        'headerHtmlOptions' => array(
            'class' => "col_$property",
            'style' => $visibility
        )
    );
}

$countDisplayedColumns = 0;
foreach ($prefsNames as $property) {
    if ($property != 'id_user' && $property != '_id') {
        if ($prefs->$property) {
            $visibility = "table_cell";
            $countDisplayedColumns++;
        } else {
            $visibility = 'display:none';
        }
        if ($property == 'notes') {
            $columns [] = addColumn($property, $model->getAttributeLabel($property), '$data->getShortNotes()', $visibility);
        } elseif ($property == 'biobank_id') {
            $columns [] = addColumn('biobank_id', $model->getAttributeLabel('biobank_id'), '$data->getBiobankName()', $visibility);
        } elseif ($property == 'collection_name') {
            $columns [] = addColumn('collection_name', Biobank::model()->getAttributeLabel('collection_name'), '$data->biobank->collection_name', $visibility);
        } elseif ($property == 'collection_id') {
            $columns [] = addColumn('collection_id', Biobank::model()->getAttributeLabel('collection_id'), '$data->biobank->collection_id', $visibility);
        } elseif ($property == 'collect_date') {
            $columns [] = addColumn('collect_date', $model->getAttributeLabel('collect_date'), '$data->collect_date', $visibility);
            //TODO normaliser les dates de collecte avant d activer cette feature
            // $columns [] = getArrayColumn('collect_date', $model->getAttributeLabel('collect_date'), 'CommonTools::toShortDateFR($data->collect_date)', $visibility);
        } elseif ($property == 'storage_conditions') {
            $columns [] = addColumn('storage_conditions', $model->getAttributeLabel('storage_conditions'), '$data->getLiteralStorageCondition()', $visibility);
        } else {
            $columns [] = addColumn($property, $model->getAttributeLabel($property), '$data->' . $property, $visibility);
        }
    }
}

//popup de choix des colonnes à afficher


$columns [] = array('class' => 'CButtonColumn',
    'header' => CHtml::link($imageSelect, '#', array(
        'onclick' => '$("#selectPopup").dialog("open");return false;'
    )), // lien d'affichage de la popup
    'template' => '{view}',
    'buttons' => array(
        'view' => array(
            'url' => 'Yii::app()->createUrl("site/view",array("id"=>"$data->_id", "asDialog"=>1))',
            'click' => 'function(){window.open(this.href,"_blank","left=100,top=100,width=760,height=650,toolbar=0,resizable=1, location=no");return false;}'
        ),
    ),
);

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'sample-grid',
    'dataProvider' => $model->searchWithNotes(),
    'columns' => $columns,
));
?>