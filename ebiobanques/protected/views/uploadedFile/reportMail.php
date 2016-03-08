<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<h3><?php echo yii::t('myBiobank', 'thanks') ?></h3>


<h5><?php echo yii::t('myBiobank', 'summaryTitle') ?></h5>
<ul>
    <li><?php echo yii::t('myBiobank', 'importFileName') ?> : <?php echo $model->filename ?></li>
    <li><?php echo yii::t('myBiobank', 'importFileDate') ?> : <?php echo $model->uploadDate->toDateTime()->format('d/m/Y, H:i:s') ?></li>
    <li><?php echo yii::t('myBiobank', 'importFileSize') ?> : <?php echo CommonTools::FileSizeConvert($model->length) ?></li>
</ul>
<table style="border: solid 2px #000000; ">
    <tr style='background-color: #c76dff'>

        <td><?php echo yii::t('myBiobank', 'samplesNumber') ?></td>
        <td><?php echo $model->metadata['samplesAdded'] ?></td>
    </tr>
    <?php if (!isset($model->metadata['errors']) || count($model->metadata['errors']) == 0) { ?>
        <tr style='background-color: #9ad717'>
            <td><?php echo yii::t('myBiobank', 'samplesNumber') ?></td>
            <td>0</td>
        </tr>
    </table>
<?php } else { ?>
    <tr style='background-color: #FFA54E'>

        <td><?php echo yii::t('myBiobank', 'errorSamplesNumber') ?></td>
        <td><?php echo isset($model->metadata['errors']) ? count($model->metadata['errors']) : 0 ?></td>
    </tr>

    </table>
    <?php if ($forMail) { ?>
        <h5><?php echo yii::t('myBiobank', 'mailDetail') ?></h5>

    <?php } else { ?>
        <h5><?php echo yii::t('myBiobank', 'downloadDetail') ?></h5>

        <?php
////        echo CHtml::su('Télécharger ', Yii::app()->createUrl('uploadedFile/constructAttachment', array('id' => $model->_id)));
//        echo '<form method="post" action="' . Yii::app()->createUrl('uploadedFile/constructAttachment', array('id' => $model->_id)) . '">';
//
//        echo '<input type="submit" value="Exporter vers Excel" name="excel" />';
//
//        echo '</form>';
//
//        echo CHtml::ajaxSubmitButton('Télécharger le rapport', Yii::app()->createUrl('uploadedFile/constructAttachment', array('id' => $model->_id)), array('success' => 'js:function(data){'
//            . 'div_content = $(data).find("#questionnaire-form");'
//            . '$("#flashMessages").html("OK")'
//            . '}',));
//    }


        $form = $this->beginWidget('ext.bootstrap.widgets.TbActiveForm', array(
            'id' => 'technicalForm',
            'action' => Yii::app()->createUrl('uploadedFile/constructAttachment', array('id' => $model->_id)),
//        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>


        <div class="row">
            <?php echo CHtml::submitButton(Yii::t('myBiobank', 'downloadReport')); ?>


        </div>
        </div>
        <?php
        $this->endWidget();
    }
}
?>

