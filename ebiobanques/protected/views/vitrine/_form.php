<?php
/* @var $this BiobankController */
/* @var $model Biobank */
/* @var $form CActiveForm */
/**
 * todo internationalzation
 */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'vitrine-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <p class="note"><?php echo Yii::t('common', 'requiredField'); ?></p>

    <?php echo $form->errorSummary($model); ?>
    <div style="float:left;width:750px;padding-left:5px;padding-right:5px;padding-top:10px">


        <div class="row">
            <div style="float:left;">
            <?php echo $form->labelEx($model, 'vitrine[logo]'); ?>
            <?php echo $form->fileField($model, 'vitrine[logo]'); ?>
            <?php echo $form->error($model, 'logo'); ?>
                </div>
            <div style="float:left;">
                <?php
    CommonTools::getBiobankInfo();
    $splitStringArray = split(".", $_SESSION['vitrine']['biobankLogo']->filename);
    $extention = end($splitStringArray);
    ?>
                <img src="<?php 
                $logo = Logo::model()->findByPk(new MongoId($model->vitrine['logo']));
                echo CommonTools::data_uri($logo->getBytes(), "image/$extention"); ?>" alt="1 photo" style="height:120px;"/>
            </div>
            <div style="clear:both;"/>
        </div>
        <?php
        echo $form->labelEx($model, 'vitrine[fr]');
        $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'model' => $model,
            'attribute' => 'vitrine[fr]',
            'width' => '700px',
            'advancedTabs' => false,
            'resizeMode' => 'vertical',
            'toolbar' => array(
                array(
                    'Source',
                    '-',
//                    'Save',
//                    'NewPage',
                    'Preview',
//                    'Print',
//                    '-',
//                    'Templates',
                ),
                array(
                    'Cut',
                    'Copy',
                    'Paste',
//                    'PasteText',
//                    'PasteFromWord',
                    '-',
                    'Undo',
                    'Redo',
                    '-',
                    'Find',
                    'Replace',
                    '-',
                    'SelectAll',
                    '-',
                    'Scayt'
                ),
                array(
//                    'Image',
//                    'Flash',
                    'Table',
                    'HorizontalRule',
//                    'Smiley',
                    'SpecialChar',
//                    'PageBreak',
//                    'Iframe'
                ),
                array(
                    'Maximize',
                    'ShowBlocks',
                ),
//                array(
//                    'Form',
//                    'Checkbox',
//                    'Radio',
//                    'TextField',
//                    'Textarea',
//                    'Select',
//                    'Button',
//                    'ImageButton',
//                    'HiddenField'
//                ),
                array(
                    'Bold',
                    'Italic',
                    'Underline',
                    'Strike',
                    'Subscript',
                    'Superscript',
                    '-',
                    'JustifyLeft',
                    'JustifyCenter',
                    'JustifyRight',
                    'JustifyBlock',
                    '-',
                    'RemoveFormat',
                ),
                array(
                    'NumberedList',
                    'BulletedList',
                    '-', 'Outdent',
                    'Indent',
                    '-',
                    'Blockquote',
                    'CreateDiv',
//                    '-', 'BidiLtr',
//                    'BidiRtl',
                ),
                '/',
                array(
                    'Link',
                    'Unlink',
                    'Anchor',
                ),
                array(
                    'Styles',
                    'Format',
                    'Font',
                    'FontSize',
                ),
                array(
                    'TextColor',
                    'BGColor',
                ),
//                array(
//                    'About',
//                ),
            )
        ));
        ?>

        <div class="row">
            <?php echo CHtml::submitButton(Yii::t('common', 'saveBtn')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
