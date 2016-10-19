
<?php $this->beginContent('//layouts/main'); ?>
<div class="left_menu_container">
    <div id ='menu' class='col-md-3'>

        <?php
//        $this->beginWidget('zii.widgets.CPortlet', array(
//            'title' => Yii::t('common', 'bbadmin'),
//
//        ));
        $items = array(
            array('label' => Yii::t("common", "bbManage"), 'url' => array('/mybiobank/index')),
            // array('label' => Yii::t("common", "bbManage"), 'url' => array('/mybiobank/bbManage')),
            array('label' => Yii::t("common", "echManage"), 'url' => array('/mybiobank/echManage')),
//            array('label' => Yii::t("common", "benchmarking"), 'url' => array('/mybiobank/benchmark'),),
//            array('label' => Yii::t("myBiobank", "connector"), 'url' => array('/connecteur/index')),
        );
//        if (Yii::app()->user->isAdmin()) {
//            $items[] = array('label' => Yii::t("myBiobank", "uploadConnector"), 'url' => array('/connecteur/upload'),);
//        }
//        $items[] = array('label' => Yii::t("myBiobank", "vitrine"), 'url' => array('/vitrine/admin'), 'template' => '<hr> {menu}');
        if (isset(Yii::app()->params['biobank']) && Yii::app()->params['biobank'] != null) {
            $biobank = Yii::app()->params['biobank'];
            if (isset($biobank->vitrine) && $biobank->vitrine != null)
                $items[] = array('label' => 'Aperçu du site vitrine', 'url' => array('/vitrine/view'));
        }
        $items[] = array('label' => 'Importer un fichier d\'échantillons', 'url' => array('/uploadedFile/admin'));
        $items[] = array('label' => 'Historique des imports', 'url' => array('/mybiobank/logImports'));
        $this->widget('zii.widgets.CMenu', array(
            'htmlOptions' => array('class' => 'nav nav-pills nav-stacked'),
            'encodeLabel' => false,
            'items' => $items
        ));
//        $this->endWidget();
        ?>
    </div>

    <div id="content" class='col-md-9'>
        <?php echo $content; ?>
    </div>
</div>
<?php $this->endContent(); ?>
