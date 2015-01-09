
<?php $this->beginContent('//layouts/main'); ?>
<div style="float:left;width:200px;padding-left:5px;padding-right:5px;padding-top:10px;background-color: white;">
    <div class="span-5 last">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => Yii::t('common', 'bbadmin'),
//            'htmlOptions' => array(
//                'style' => 'height:280px'
//            )
        ));
        $items = array(
            array('label' => Yii::t("common", "accueil"), 'url' => array('/mybiobank/index')),
            array('label' => Yii::t("common", "bbManage"), 'url' => array('/mybiobank/bbManage')),
            array('label' => Yii::t("common", "echManage"), 'url' => array('/mybiobank/echManage')),
            array('label' => Yii::t("common", "benchmarking"), 'url' => array('/mybiobank/benchmark'),),
            array('label' => Yii::t("myBiobank", "connector"), 'url' => array('/connecteur/index'), 'template' => '<hr> {menu}'),
        );
        if (Yii::app()->user->isAdmin()) {
            $items[] = array('label' => Yii::t("myBiobank", "uploadConnector"), 'url' => array('/connecteur/upload'),);
        }
        $items[] = array('label' => Yii::t("myBiobank", "vitrine"), 'url' => array('/vitrine/admin'), 'template' => '<hr> {menu}');
        $items[] = array('label' => 'Aperçu du site vitrine', 'url' => array('/vitrine/view'), 'template' => '<hr> {menu}');
        $items[] = array('label' => 'Importer un fichier d\'échantillons', 'url' => array('/uploadedFile/admin'), 'template' => '<hr> {menu}');

        $this->widget('zii.widgets.CMenu', array(
            /* 'type'=>'list', */
            'encodeLabel' => false,
            'items' => $items
        ));
        $this->endWidget();
        ?>
    </div>
</div>
<!-- Include content pages -->

<div id="content" style="padding-top:10px;background-color: white; width: 100%;min-height: 280px;">
    <?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>
