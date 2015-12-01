
<div>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'prefs-form',
    ));
    $prefModel = new Preferences();
    $prefModel->attributes = $model;
    foreach ($model as $field => $fieldValue) {
        if ($field != 'id_user' && $field != '_id' && $field != 'id') {
            if ($fieldValue == 1)
                $checked = true;
            else
                $checked = false;
            ?>
            <div style="float:left;width:200px;font-size:8pt">
                <?php
                echo $form->checkBox($prefModel, $field, array('checked' => $checked));
                ?>
                <span >
                    <?php echo $form->label($prefModel, $field); ?>
                </span>
            </div>

            <?php
        }
    }
    ?>



    <?php $this->endWidget(); ?>
</div>