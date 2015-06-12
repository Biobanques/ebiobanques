<?php
/* @var $this BiobankController */
/* @var $model Biobank */
$logo = isset($model->activeLogo) && $model->activeLogo != null ? Logo::model()->findByPk(new MongoId($model->activeLogo)) : null;
?>

<div class="logoHeader">
    <h1>Update Biobank <?php echo $model->name; ?></h1>
    <div class="logo">
        <?php
        if ($logo != null) {
            echo $logo->toHtml();
        }
        ?>
    </div>
</div>

<?php
echo $this->renderPartial('_form', array('model' => $model));
?>