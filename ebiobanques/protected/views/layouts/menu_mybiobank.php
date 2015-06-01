
<?php $this->beginContent('//layouts/main'); ?>
<div class="left_menu_container">
    <div id ='menu' class='menu'>

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
        if (isset(Yii::app()->params['biobank']) && Yii::app()->params['biobank'] != null) {
            $biobank = Yii::app()->params['biobank'];
            if (isset($biobank->vitrine) && $biobank->vitrine != null)
                $items[] = array('label' => 'Aperçu du site vitrine', 'url' => array('/vitrine/view'));
        }
        $items[] = array('label' => 'Importer un fichier d\'échantillons', 'url' => array('/uploadedFile/admin'), 'template' => '<hr> {menu}');
        $items[] = array('label' => 'Historique des imports', 'url' => array('/mybiobank/logImports'));
        $this->widget('zii.widgets.CMenu', array(
            /* 'type'=>'list', */
            'encodeLabel' => false,
            'items' => $items
        ));
        $this->endWidget();
        ?>
    </div>

    <!-- Include content pages -->

    <div id="content" class='content'style="padding : 0px 5px 5px 5px;">
        <?php echo $content; ?>
    </div><!-- content -->
</div>
<?php $this->endContent(); ?>
