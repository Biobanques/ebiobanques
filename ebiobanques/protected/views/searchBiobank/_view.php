<?php
/* @var $this SearchBiobankController */
/* @var $data Biobank */
?>
<div class='view'>
    <?php
    foreach (Biobank::Model()->attributeExportedLabels() as $attribute => $value) {
        if (isset($data->$attribute)) {
            ?>
            <b><?php echo CHtml::encode($data->getAttributeLabel($attribute)); ?>:</b>
            <?php
            switch ($attribute) {
                case 'contact_id':
                    echo $data->contact_id != null && !empty($data->contact_id) ? CHtml::encode($data->getShortContact()) . '<br>' . CHtml::encode($data->getEmailContact()) . '<br>' . CHtml::encode($data->getPhoneContact()) : "";
                    break;

                case 'address':
                    echo nl2br($data->getAddress());
                    break;
                case 'responsable_op':
                    echo nl2br($data->getResponsableOp());
                    break;
                case 'responsable_qual':
                    echo nl2br($data->getResponsableQual());
                    break;
                case 'responsable_adj':
                    echo nl2br($data->getResponsableAdj());
                    break;
                case 'website':
                    echo CHtml::link($data->website, 'http://' . $data->website, array('target' => 'blank'));
                    break;

                default:
                    echo CHtml::encode($data->$attribute);
                    break;
            }
            ?>
            <br />
            <?php
        }
    }
    ?>
    <br />
    <br />
</div>