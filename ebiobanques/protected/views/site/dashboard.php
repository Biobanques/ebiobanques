<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<div class="row-fluid">
    <div style="float:left;width:430px;">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "<i class='icon-share'></i>" . Yii::t('common', 'FiReAct'),
        ));
        $this->widget('application.widgets.charting.CBarsChartWidget', array('id' => 'columnchart-count-files-month',
            'theme' => 'Distinctive',
            'title' => '',
            'data' => StatTools::getCountFilesReceptionByMonth(),
            'width' => 380,
            'heigth' => 250,
            'xAxisRotation' => 0
        ));
        $this->endWidget();
        ?>
    </div>
    <div style="float:left;width:430px;padding-left:10px;">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "<i class='icon-adjust'></i>" . Yii::t('common', 'LoSaCh'),
        ));
        //affichage du graphe de repartition par ville des echantillons
        $this->widget('application.widgets.charting.CPieChartWidget', array(
            'id' => 'piechart-collab',
            'theme' => 'WatersEdge',
            'width' => 380,
            'height' => 250,
            'data' => StatTools::getRepartitionSamplesByTown(),
            'title' => 'Location by biobank',));
        $this->endWidget();
        ?>
    </div>
</div>
<div style="clear:both;">
    <div style="float:left;width:430px;">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array('title' => "<i class='icon-adjust'></i>" . Yii::t('common', 'BioBkReg')));
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'echantillon-grid',
            'dataProvider' => Biobank::model()->search(),
            'columns' => array(
                'identifier',
                'name',
                array(
                    'header' => 'collection name',
                    'value' => 'CommonTools::getShortValue($data->collection_name)'
                ),
                array(
                    'header' => 'Main contact',
                    'value' => '$data->getShortContact()'
                ,),
            ),
        ));
        $this->endWidget();
        ?>
    </div>
    <div style="float:left;width:430px;padding-left:10px;">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "<i class='icon-share'></i>" . Yii::t('common', 'SaReAct'),
        ));
        $this->widget('application.widgets.charting.CBarsChartWidget', array('id' => 'columnchart-count-month',
            'theme' => 'Distinctive',
            'title' => '',
            'data' => StatTools::getCountReceptionByMonth(),
            'width' => 380,
            'heigth' => 250,
            'xAxisRotation' => 0
        ));
        $this->endWidget();
        ?>
    </div>
</div>
<div style="clear:both;"/>
