<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div style="float:left;width:200px;padding-left:5px;padding-right:5px;padding-top:10px;">
    <div class="span-5 last">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => Yii::t('common', 'administration'),
//            'htmlOptions' => array(
//                'style' => 'height:280px'
//            )
        ));
        $this->widget('zii.widgets.CMenu', array(
            'encodeLabel' => false,
            'items' => array(
                array('label' => 'Biobanks', 'url' => array('/biobank/admin')),
                array('label' => 'Files ', 'url' => array('/fileImported/admin')),
                array('label' => 'Samples', 'url' => array('/echantillon/admin')),
                array('label' => 'Users', 'url' => array('/user/admin')),
                array('label' => 'Contacts', 'url' => array('/contact/admin')),
                array('label' => 'Log système', 'url' => array('/auditTrail/admin')),
            ),
        ));
        $this->endWidget();
        ?>
    </div>
</div>
<div id="content" style="background-color: white;float:left;width:700px;">
    <?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>