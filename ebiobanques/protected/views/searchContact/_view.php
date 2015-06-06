<?php
/* @var $this SearchContactController */
/* @var $data Contact */
?>
<div class='view'>
    <?php
    foreach (Contact::Model()->attributeExportedLabels() as $attribute => $value) {
        ?>
        <b><?php echo CHtml::encode($data->getAttributeLabel($attribute)); ?>:</b>
        <?php
        if ($attribute == 'adresse') {
            echo $data->fullAddress;
            ?>

            <?php
        } elseif ($attribute == 'biobank') {
            echo $data->biobankName;
        } else
            echo CHtml::encode($data->$attribute);
        ?>
        <br />
    <?php } ?>
    <br />
    <br />
</div>
