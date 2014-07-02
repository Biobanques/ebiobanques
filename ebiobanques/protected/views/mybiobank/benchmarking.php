<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 */
?>
<?php
//theme dojo utilisé pour tous les widgets de la page.
$theme = 'Claro';


if (count($biobankStats) > 1) {
    $max = max(array(count($globalStats), count($biobankStats))) - 1;
    $globalDatas = array();
    for ($i = 0; $i <= $max; $i++) {
        if (isset($biobankStats[$max - $i]))
            $globalDatas['biobanque'][] = $biobankStats[$max - $i]->globalRate;
        else {
            $globalDatas['biobanque'][] = null;
        }
        if (isset($globalStats[$max - $i]))
            $globalDatas['global'][] = $globalStats[$max - $i]->globalRate;
        else
            $globalDatas['global'][] = null;
    }
    ?>
    <div style="padding:10px;">

        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => 'Taux de complétude global',
            'htmlOptions' => array(
                'style' =>
                'height:280px;display:inline-block',
            )
        ));

        $this->widget('application.widgets.charting.CLinesChartWidget', array(
            'id' => 'attributeChart_global',
            'title' => '',
            'data' => $globalDatas,
            'width' => 550,
            'height' => 230,
            'enableCompare' => true,
            'theme' => $theme
        ));
        $this->endWidget();
        ?>

    </div>


    <?php
    $listWidgets = array();
    $tabCount = 0;
    foreach ($globalStats[0]->values as $attributeName => $attribute) {
        $datas = array();
        for ($i = 0; $i <= $max; $i++) {
            if (isset($biobankStats[$max - $i]))
                $datas['biobanque'][] = $biobankStats[$max - $i]->values[$attributeName];
            else {
                $datas['biobanque'][] = null;
            }
            if (isset($globalStats[$max - $i]))
                $datas['global'][] = $globalStats[$max - $i]->values[$attributeName];
            else
                $datas['global'][] = null;
        }
        $listWidgets[$attributeName] = array('label' => $attributeName, 'url' => Yii::app()->createUrl('mybiobank/detailGraph'), 'ajax' => array('type' => 'POST', 'update' => '#detailData', 'data' => array('datas' => $datas,
                    'attributeName' => $attributeName,
                    'theme' => $theme)));
    }
    ?>

    <div style="overflow: hidden;display: inline-block">
        <div id="detailsMenu" style="float:left;width:200px;padding-left:5px;padding-right:5px;padding-top:5px;">
            <div class="span-5 last">
                <?php
                $this->beginWidget('zii.widgets.CPortlet', array(
                    'title' => 'Détails',
                ));
                $this->widget('ext.AjaxMenu', array(
                    'items' => $listWidgets,));
                $this->endWidget();
                ?>

            </div></div>



        <div id='detailData' style="padding: 5px;display: inline-block">
            <?php
            $this->renderPartial('_renderWidget', array('datas' => $listWidgets['id_depositor']['ajax']['data']['datas'], 'attributeName' => $listWidgets['id_depositor']['ajax']['data']['attributeName'], 'theme' => $theme));
            ?>
        </div></div>


    <?php
}
elseif (count($biobankStats == 1)) {

    foreach ($biobankStats[0]->values as $name => $value)
        $datas[] = array($name, str_replace(',', '.', $value));
    ?>
    <div
        style="float: left; width: 95%;text-align: center; padding-left: 10px; padding-top: 10px">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => "<i class='icon-share'></i>Taux de complétude de la biobanque"
        ));
        $this->widget('application.widgets.charting.CBarsChartWidget', array(
            'id' => 'columnchart-filescount-month',
            'theme' => 'Distinctive',
            'title' => '',
            'data' => $datas,
            'width' => 500,
            'heigth' => 400,
            'xAxisRotation' => 0
        ));
        $this->endWidget();
    }
    ?>
</div>
<?php
//foreach ($globalStats[0]->values as $name => $value)
//    $globalDatas[] = array($name, str_replace(',', '.', $value));
?>
