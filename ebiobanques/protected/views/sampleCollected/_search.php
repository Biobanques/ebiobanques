<?php
/* @var $this EchantillonController */
/* @var $model SampleCollected */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <?php
    foreach ($model->attributes as $nameAtt => $valueAtt) {
        if ($nameAtt != "_id") {
            ?>
            <div style="float: left">
                <?php
                echo $form->label($model, $nameAtt);
                ?>
                <?php
                echo $form->textField($model, $nameAtt);
                ?>
            </div>

            <?php
        }
    }
    ?>


    <div class="row buttons">
<?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->