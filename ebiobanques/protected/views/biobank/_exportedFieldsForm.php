<div class="row">
    <?php
    Yii::app()->clientScript->registerCss('mycss', '
   #fields>li{
   float: left;
   padding: 3px 0;
   }
');
    $listFields = CommonTools::getAllFieldsarray('biobank');
    echo CHtml::beginForm(Yii::app()->createUrl('biobank/exportselectedxls'), 'POST');
    echo CHtml::checkBoxList('fields', ['identifier', 'name'], $listFields, ['separator' => ''
        , 'template' => '<div class="col-md-6">{input} {label}</div>',]);
    ?><div class="row">
        <div class="col-md-6">
            <?php
            echo CHtml::submitButton(Yii::t('common','export_field'), ['class' => 'btn-primary']);
            ?>
        </div>
        <div class="col-md-6">
            <?php
            echo CHtml::resetButton(Yii::t('common','resetBtn'));
            ?>
        </div>
    </div><?php
    echo CHtml::endForm();
    ?>
</div>