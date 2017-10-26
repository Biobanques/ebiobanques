<?php
/*
 * page d accueil pour présenter le projet
 */

?>
<div>
    <h3><?php echo Yii::t('common', 'indexTitle') ?></h3>
    <div class="row">
        <div class="col-lg-6" style=";font-size: 1.2em;text-align:justify;">&emsp;&emsp;<?php echo Yii::t('common', 'indexContent_p1') ?>
        </div>
        <div class="col-lg-6" >
            <?php
            echo CHtml::image(Yii::app()->baseUrl . "/images/picture_researcher.jpg", "picture researcher", array("width" => "500", "height" => "300"));
            ?>
        </div>
    </div>
    <div style="clear:both;"/>
</div>

