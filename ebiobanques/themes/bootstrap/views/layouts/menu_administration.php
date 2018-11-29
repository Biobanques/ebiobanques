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
                array('label' => Yii::t('common','Biobanks'), 'url' => array('/biobank/admin')),
                array('label' => Yii::t('common','Users'), 'url' => array('/user/admin'))
                    ,);
            if ($this->getAction()->getId() == 'update') {
                $items[] = array('label' => Yii::t('common','old_update'), 'url' => array('/biobank/oldUpdate', 'id' => $this->getActionParams()['id']));
            }
            if ($this->getAction()->getId() == 'oldUpdate') {
                $items[] = array('label' => Yii::t('common','update'), 'url' => array('/biobank/update', 'id' => $this->getActionParams()['id']));
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
                'title' => Yii::t('common', 'Technical Operations'),
//            'htmlOptions' => array(
//                'style' => 'height:280px'
//            )
            ));
            $items = array(
                array('label' => Yii::t('common',  'Files '), 'url' => array('/fileImported/admin')),
                array('label' =>  Yii::t('common','Samples'), 'url' => array('/echantillon/admin')),
                //array('label' => 'Contacts', 'url' => array('/contact/admin')),
                //array('label' => 'Export des contacts', 'url' => array('/contact/exportContact')),
                array('label' => Yii::t('common','system_log'), 'url' => array('/auditTrail/admin')),
                array('label' => Yii::t('common', 'userLog'), 'icon'=>'play', 'url' => array('/administration/userLog')),
                array('label' => 'Exporter toutes les biobanques', 'icon'=>'play', 'url' => array('/administration/exportAllBiobanks')),
                array('label' => 'Exporter tous les utilisateurs', 'icon'=>'play', 'url' => array('/administration/exportAllUsers'))
                );
            if ($this->getAction()->getId() == 'update') {
                $items[] = array('label' => Yii::t('common','old_update'), 'url' => array('/biobank/oldUpdate', 'id' => $this->getActionParams()['id']));
            }
            if ($this->getAction()->getId() == 'oldUpdate') {
                $items[] = array('label' =>Yii::t('common','update'), 'url' => array('/biobank/update', 'id' => $this->getActionParams()['id']));
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