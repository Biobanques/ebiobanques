<?php
//echo Yii::app()->request->urlReferrer;
//Chargement des preferen,ces d'affichage de colonnes
$prefs = CommonTools::getPreferences();

$imageSampleDetail = Yii::app()->baseUrl . '/images/zoom.png';
$columns = array();

foreach ($prefs as $property => $propertyValue) {
//
    if ($property != 'id_user' && $property != "_id") {
        if ($propertyValue)
            $visibility = "table_cell";
        else
            $visibility = 'display:none';
        if ($property == 'notes') {
            $columns [] = array(
                'class' => 'DataColumn',
                'name' => $property,
                'id' => 'col_' . $property,
                'header' => Sample::model()->getAttributeLabel($property),
                'value' => '$data->getShortNotes()',
                'htmlOptions' => array(
                    'class' => "col_$property",
                    'style' => $visibility
                ),
                'headerHtmlOptions' => array(
                    'class' => "col_$property",
                    'style' => $visibility
                )
            );
        } elseif ($property == 'biobank_id') {
            $columns [] = array(
                'class' => 'DataColumn',
                'name' => Yii::t('sample', 'biobank_id'),
                'id' => 'col_' . $property,
                'header' => Sample::model()->getAttributeLabel($property),
                'value' => 'Biobank::model()->findByPk(new MongoId($data->biobank_id))->name',
                'htmlOptions' => array(
                    'class' => "col_$property",
                    'style' => $visibility
                ),
                'headerHtmlOptions' => array(
                    'class' => "col_$property",
                    'style' => $visibility
                )
            );
        } elseif ($property == 'collect_date') {
            $columns [] = array(
                'class' => 'DataColumn',
                'name' => $property,
                'id' => 'col_' . $property,
                'header' => Sample::model()->getAttributeLabel($property),
                'value' => 'CommonTools::toShortDateFR($data->collect_date)',
                'htmlOptions' => array(
                    'class' => "col_$property",
                    'style' => $visibility
                ),
                'headerHtmlOptions' => array(
                    'class' => "col_$property",
                    'style' => $visibility
                )
            );
        } elseif ($property == 'storage_conditions') {
            $columns [] = array(
                'class' => 'DataColumn',
                'name' => $property,
                'id' => 'col_' . $property,
                'header' => Sample::model()->getAttributeLabel($property),
                'value' => '$data->getLiteralStorageCondition()',
                'htmlOptions' => array(
                    'class' => "col_$property",
                    'style' => $visibility
                ),
                'headerHtmlOptions' => array(
                    'class' => "col_$property",
                    'style' => $visibility
                )
            );
        } elseif ($property == 'collection_name') {
            $columns [] = addColumn('collection_name', Biobank::model()->getAttributeLabel('collection_name'), '$data->biobank->collection_name', $visibility);
        } elseif ($property == 'collection_id') {
            $columns [] = addColumn('collection_id', Biobank::model()->getAttributeLabel('collection_id'), '$data->biobank->collection_id', $visibility);
        } else {
            $columns [] = array(
                'class' => 'DataColumn',
                'name' => $property,
                'id' => 'col_' . $property,
                'value' => '$data->' . $property,
                'header' => Sample::model()->getAttributeLabel($property),
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
    }
}
//
$columns [] = array(
    'header' => Yii::t('demande', 'sampleDetail'),
    'class' => 'CLinkColumn',
    'labelExpression' => '$data->_id',
    'urlExpression' => 'Yii::app()->createUrl("site/view",array("id"=>"$data->_id"))',
    'linkHtmlOptions' => array(
        'onclick' => 'window.open(this.href,"SampleDetail","left=100,top=100,width=760,height=650,toolbar=0,resizable=0, location=no");return false;'
    ),
    'htmlOptions' => array('style' => 'text-align:center'),
    'imageUrl' => $imageSampleDetail
);
?>

<h1><?php echo Yii::t('common', 'demande') . ' ' . $model->titre; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model));
?>
<div style="margin:10px">
    <?php
    $this->widget('application.extensions.selgridview.SelGridView', array(
        'id' => 'echSelected-grid',
        'dataProvider' => $model->getSamples(),
//        'dataProvider' => $model->search(),
        'columns' => $columns,
        'selectableRows' => 0,
        'enableHistory' => true,
    ));
    ?>
</div>
<?php

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
?>