<?php
/*
 * page d accueil pour présenter le projet
 */
?>
<div>
    <h3><?php echo Yii::t('common', 'indexTitle') ?></h3>
    <div style="float:left;width:400px;font-size: 1.2em;text-align:justify;">&emsp;&emsp;<?php echo Yii::t('common', 'indexContent_p1') ?>
    </div>
    <div style="float:right;width:500px;">
        <?php
        echo CHtml::image(Yii::app()->baseUrl . "/images/picture_researcher.jpg", "picture researcher", array("width" => "500", "height" => "300"));
        ?>
    </div>
    <div style="clear:both;"/>
</div>

