<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="left_menu_container">
    <div id ='menu' class='menu'>
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
                // array('label' => 'Biobanks', 'url' => array('/biobank/admin')),
                // array('label' => 'Files ', 'url' => array('/fileImported/admin')),
                array('label' => 'Echantillons', 'url' => array('/sampleCollected/admin')),
                array('label' => 'Utilisateurs', 'url' => array('/user/admin')),
                //  array('label' => 'Contacts', 'url' => array('/contact/admin')),
                array('label' => 'Logs système', 'url' => array('/auditTrail/admin')),
            ),
        ));
        $this->endWidget();
        ?>
    </div>

    <div id="content" class='content' style="padding : 0px 5px 5px 5px;">
        <?php echo $content; ?>
    </div><!-- content -->
</div>
<?php $this->endContent(); ?>
