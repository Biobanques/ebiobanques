
<?php $this->beginContent('//layouts/main'); ?>
<div style="float:left;width:200px;padding-left:5px;padding-right:5px;padding-top:10px;">
    <div class="span-5 last">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => Yii::t('common', 'bbadmin'),
            'htmlOptions' => array(
                'style' => 'height:280px'
            )
        ));
        $this->widget('zii.widgets.CMenu', array(
            /* 'type'=>'list', */
            'encodeLabel' => false,
            'items' => array(
                array('label' => Yii::t("common", "accueil"), 'url' => array('/mybiobank/index')),
                array('label' => Yii::t("common", "bbManage"), 'url' => array('/mybiobank/bbManage')),
                array('label' => Yii::t("common", "echManage"), 'url' => array('/mybiobank/echManage')),
                array('label' => Yii::t("common", "benchmarking"), 'url' => array('/mybiobank/benchmark')),
            ),
        ));
        $this->endWidget();
        ?>
    </div>
</div>
<!-- Include content pages -->


<?php echo $content; ?>
<?php $this->endContent(); ?>
