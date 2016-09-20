<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
    <div class="col-md-3">
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
                array('label' => 'Users', 'url' => array('/user/admin'))
                    ,);
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

            <br>

            <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title' => 'Technical Operations',
//            'htmlOptions' => array(
//                'style' => 'height:280px'
//            )
            ));
            $items = array(
                array('label' => 'Files ', 'url' => array('/fileImported/admin')),
                array('label' => 'Samples', 'url' => array('/echantillon/admin')),
                //array('label' => 'Contacts', 'url' => array('/contact/admin')),
                //array('label' => 'Export des contacts', 'url' => array('/contact/exportContact')),
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
    </div>
    <div id="content" class="col-md-9">
        <?php echo $content; ?>
    </div><!-- content -->
</div>
<?php $this->endContent(); ?>