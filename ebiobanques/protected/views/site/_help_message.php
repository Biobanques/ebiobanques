<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="help">
    <div class="help-title"><img src="<?php echo Yii::app()->request->baseUrl . '/images/'; ?>information.gif"/><?php echo $title ?></div>
    <div class="help-content">
        <?php
        echo $content;
        ?>
    </div>
</div>
