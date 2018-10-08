<?php
/* @var $this AdministrationController */
/* @var $model UserLog */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('userLog-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1><?php echo Yii::t('common', 'userLog'); ?></h1>

<?php
$imagesearch = CHtml::image(Yii::app()->baseUrl . '/images/zoom.png', Yii::t('administration', 'advancedsearch'));
echo CHtml::link($imagesearch . Yii::t('common', 'advancedsearch'), '#', array('class' => 'search-button'));
?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'userLog-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array('header' => $model->attributeLabels()["username"], 'name' => 'username'),
        array('header' => $model->attributeLabels()["email"], 'name' => 'email'),
        array('header' => $model->attributeLabels()["profil"], 'name' => 'profil', 'value' => '$data->getProfil($data->profil)'),
        array('header' => $model->attributeLabels()["biobank_name"], 'name' => 'biobank_name'),
        array('header' => $model->attributeLabels()["biobank_id"], 'name' => 'biobank_id'),
        array('header' => $model->attributeLabels()["connectionDate"], 'name' => 'connectionDate', 'value' => '$data->getConnectionDate()'),
    ),
));
?>

<h3 align="center">Utilisateurs actifs mensuels pour l'année <?php echo date("Y"); ?></h3>
<?php
$this->widget(
    'chartjs.widgets.ChBars', array(
        'width' => 850,
        'height' => 300,
        'htmlOptions' => array(),
        'labels' => CommonTools::frenchDates(),
        'datasets' => array(
            array(
                "fillColor" => "#ff00ff",
                "strokeColor" => "rgba(220,220,220,1)",
                "data" => $data
            ),
            array(
                "fillColor" => "#00ff00",
                "strokeColor" => "rgba(220,220,220,1)",
                "data" => $dataAdminBbq
            )
        ),
        'options' => array()
    )
);
?>