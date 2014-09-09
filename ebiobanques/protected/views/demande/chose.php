<script type="text/javascript">

    window.onfocus = function() {
        $('#demande-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    };

</script>
<?php
/* @var $this DemandeController */
/* @var $model Demande */



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#demande-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});

");
?>
<script type="text/javascript">
    function setActiveDemand(id) {
        jQuery.ajax({
            'url': '<?php echo Yii::app()->createUrl("demande/setActiveDemand") ?>',
            'data': {'id': id},
            'type': 'post',
            'cache': false,
            'success': function(data) {
                $('.demandeActiveMsg').html(data);
            }
        });
        $('#demande-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
    }
    function createNewDemand() {
        jQuery.ajax({
            'url': '<?php echo Yii::app()->createUrl("demande/createNewDemand") ?>',
            'type': 'post',
            'cache': false,
            'success': function(data) {
                $('.demandeActiveMsg').html(data);
            }

        });
        $('#demande-grid').yiiGridView('update', {
            data: $(this).serialize()
        });


    }


</script>
<h1><?php echo Yii::t('demande', 'gererDemandes'); ?></h1>
<p>
    <span class="demandeActiveMsg"> 
<?php //echo Yii::t('common','activeDemandMsg').Yii::app()->session['activeDemand'][0]->_id ?></span>
</p>
        <?php echo CHtml::link(Yii::t('demande', 'creerDemande'), '#', array(
            'onclick' => 'createNewDemand()'));
        ?>
<div class="search-form" style="display: none">
<?php
$this->renderPartial('_search', array(
    'model' => $model
));
?>
</div>
<!-- search-form -->

<?php
$imageSampleDetail = Yii::app()->baseUrl.'/images/zoom.png';
$this->widget('application.extensions.selgridview.SelGridView', array(
    'id' => 'demande-grid',
    'dataProvider' => $model->searchForCurrentUser(),
    // 'filter' => $model,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'id' => 'selectionCB',
            'header' => Yii::t('demande', 'activeDemande'),
            'checkBoxHtmlOptions' => array(
                'onchange' => 'setActiveDemand(this.value)'
            ),
            'selectableRows' => 1,
            'checked' => '$data->isActive()',
            'disabled' => '$data->isActive()||$data->envoi==1'
        ),
        array(
            'class' => 'DataColumn',
            'header' => $model->getAttributeLabel('titre'),
            'value' => '$data->titre'
        ),
        array(
            'class' => 'DataColumn',
            'header' => $model->getAttributeLabel('date_demande'),
            'value' => '$data->dateDemande'
        ),
        array(
            'class' => 'DataColumn',
            'header' => $model->getAttributeLabel('detail'),
            'value' => '$data->getShortContent()'
        ),
        array(
            'class' => 'DataColumn',
            'header' => $model->getAttributeLabel('nbEch'),
            'value' => '$data->countSamples()',
        ),
        // liens pour details des demandes en popup
        array(
            'header' => $model->getAttributeLabel('details'), // lien d'affichage de la popup
            'class' => 'CLinkColumn',
            'labelExpression' => '$data->_id',
            'urlExpression' => 'Yii::app()->createUrl("demande/update",array("id"=>"$data->_id"))',
            'htmlOptions' => array(
                'style' => 'text-align:center'
            ),
            'imageUrl' => $imageSampleDetail
        ),
        array(
            'header' => Yii::t("demande", "del"),
            'class' => 'CButtonColumn',
            'template' => '{delete}',
            'buttons' => array(
                'delete' => array('visible' => '!$data->isactive()'))
        ),
    ),
    'selectableRows' => 0,
    'enableHistory' => true
));
?>
