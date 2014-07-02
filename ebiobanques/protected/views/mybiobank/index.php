<?php
Yii::app()->clientScript->registerScript('search', "
$('.detail-button').click(function(){
	$('.detail_tab').toggle();
	return false;
});
");
?>
<div style="float: left; width: 700px;" >
    <div style="float: left; width: 330px; padding-top: 10px">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "<i class='icon-share'></i>" . Yii::t('myBiobank', 'samplesReceptionActivity') . " -  $model->identifier"
        ));
        $this->widget('application.widgets.charting.CBarsChartWidget', array(
            'id' => 'columnchart-count-month',
            'theme' => 'Distinctive',
            'title' => '',
            'data' => StatTools::getCountReceptionByMonthAndBiobank($model->id),
            'width' => 310,
            'heigth' => 230,
            'xAxisRotation' => 0
        ));
        $this->endWidget();
        ?>
    </div>

    <div
        style="float: left;
        width: 330px;
        padding-left: 10px;
        padding-top: 10px">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "<i class = 'icon-share'></i>" . Yii::t('myBiobank', 'filesReceptionActivity') . " - $model->identifier"
        ));
        $this->widget('application.widgets.charting.CBarsChartWidget', array(
            'id' => 'columnchart-filescount-month',
            'theme' => 'Distinctive',
            'title' => '',
            'data' => StatTools::getCountFilesReceptionByMonthAndBiobank($model->id),
            'width' => 310,
            'heigth' => 230,
            'xAxisRotation' => 0
        ));
        $this->endWidget();
        ?>


    </div>

    <div style="float:left;
         width:330px;
         padding-top: 10px;
         ">

        <?php
        $stats = BiobankStats::model()->findByAttributes(array('biobank_id' => $model->id), array('$sort' => array('date' => -1)));
        if ($stats != null)
            $complete = $stats->globalRate;
        else
            $complete = 0;
        $roundcomplete = round($complete);
        $data = array(
            array(
                'Complet : ' . $roundcomplete . '%',
                $roundcomplete
            ),
            array(
                'Incomplet',
                100 - $roundcomplete
            )
        );
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "<i class = 'icon-adjust'></i> " . Yii::t('myBiobank', 'samplesCompletionRate') . " -  $model->identifier"
        ));
// affichage du graphe de completude des echantillons
        $this->widget('application.widgets.charting.CPieChartWidget', array(
            'id' => 'piechart-collab',
            'theme' => 'WatersEdge',
            'width' => 380,
            'height' => 250,
            'data' => $data,
            'title' => '<a class="detail-button" href="#">détails</a>'
        ));
        $this->endWidget();
        ?>
    </div>

    <!-- affichage du tableau de stats detaillées -->
    <div style="float: left; width: 330px; padding-left: 10px; padding-top: 10px; display: none" class="detail_tab">
        <h4><b>Détails des taux de complétude.</b></h4>
        <?php
        if ($stats != null) {


            foreach ($stats->values as $valueName => $value) {
                $attributes[] = array('label ' => Sample::model()->getAttributeLabel($valueName), 'value' => $value . '%');
            }

            $this->widget('zii.widgets.CDetailView', array(
                // 'data' => $detailsStats,
                'data' => $stats->values,
                'attributes' => $attributes
                    )
            );
            ?>
        </div>
    </div>
    <div style="clear: both;" />

    <?php
}
?>
