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
                //affichage du logo
                $logo = $model->getLogo();
                if ($logo != null) {
                    echo $logo->toHtml();
                }
                ?>
            </div>
            <div style="clear:both;"/>
        </div>
        <?php
        echo $form->labelEx($model, 'vitrine[page_accueil_fr]');
        $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'model' => $model,
            'attribute' => 'vitrine[page_accueil_fr]',
            'width' => '700px',
            'advancedTabs' => false,
            'resizeMode' => 'vertical',
            'toolbar' => array(
                array(
                    'Source',
                    '-',
                    'Preview',
                ),
                array(
                    'Cut',
                    'Copy',
                    'Paste',
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
                    'Table',
                    'HorizontalRule',
                    'SpecialChar',
                ),
                array(
                    'Maximize',
                    'ShowBlocks',
                ),
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
            )
        ));
        ?>

        <div class="row">
            <?php echo CHtml::submitButton(Yii::t('common', 'saveBtn')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->
