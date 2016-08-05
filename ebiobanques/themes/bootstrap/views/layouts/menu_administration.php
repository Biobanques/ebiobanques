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
        $items = array(
            array('label' => 'Biobanks', 'url' => array('/biobank/admin')),
            array('label' => 'Files ', 'url' => array('/fileImported/admin')),
            array('label' => 'Samples', 'url' => array('/echantillon/admin')),
            array('label' => 'Users', 'url' => array('/user/admin')),
            array('label' => 'Contacts', 'url' => array('/contact/admin')),
            array('label' => 'Export des contacts', 'url' => array('/contact/exportContact')),
            array('label' => 'Log système', 'url' => array('/auditTrail/admin')),);
        if ($this->getAction()->getId() == 'update') {
            $items[] = array('label' => 'old update', 'url' => array('/biobank/oldUpdate', 'id' => $this->getActionParams()['id']));
        }
        if ($this->getAction()->getId() == 'oldUpdate') {
            $items[] = array('label' => 'update', 'url' => array('/biobank/update', 'id' => $this->getActionParams()['id']));
        }

        $this->widget('zii.widgets.CMenu', array(
            'encodeLabel' => false,
            'items' => $items
        ));
        $this->endWidget();
        ?>
    </div>

    <div id="content" class='content'style="padding : 0px 5px 5px 5px;">
        <?php echo $content; ?>
    </div><!-- content -->
</div>
<?php $this->endContent(); ?>