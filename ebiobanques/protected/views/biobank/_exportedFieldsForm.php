<?php
Yii::app()->clientScript->registerCss('mycss', '
   #fields>li{
   float: left;
   width: 400px;
   padding: 3px 0;
   }
');
$listFields = CommonTools::getAllFieldsarray('biobank');
echo CHtml::beginForm(Yii::app()->createUrl('biobank/exportselectedxls'), 'POST');
echo CHtml::checkBoxList('fields', $listFields, $listFields, ['separator' => ''
    , 'template' => '<li>{input} {label}</li>',]);
?><div style="padding-top: 25px;float: left;width: 95%">
    <?php
    echo CHtml::submitButton('Exporter ces champs', ['style' => 'margin-right:10px']);
    echo CHtml::resetButton();
    ?>
</div><?php
echo CHtml::endForm();
?>