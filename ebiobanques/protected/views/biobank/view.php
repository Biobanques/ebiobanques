<?php
/* @var $this BiobankController */
/* @var $model Biobank */


try {
    $logo = isset($model->activeLogo) && $model->activeLogo != null && $model->activeLogo != "" ? Logo::model()->findByPk(new MongoId($model->activeLogo)) : null;
} catch (Exception $ex) {
    $logo = null;
    Yii::app()->user->setFlash('error', 'An error occured with logo, unable to display it');
}
?>
<div class="logoHeader">
    <h1>View Biobank <?php echo $model->name; ?></h1>
    <div class="logo">
        <?php
        if ($logo != null) {
            echo $logo->toHtml();
        }
        ?>
    </div>
</div>

<?php





$cims = array('name' => 'cims', 'value' => nl2br(print_r($model->cims, true)), 'type' => 'raw',);






?>
<div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_1'); ?></div>
<div id="biobank_oblig" >
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'acronym',
            'name',
            'identifier',
            array('name' => 'website', 'value' => $model->getFormattedWebsite(), 'type' => 'raw',),
            'presentation',
            'presentation_en'
        )
    ));
    ?>
</div>


<div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_quality'); ?></div>

    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'cert_ISO9001',
            'cert_NFS96900',
            'cert_autres'
        )
    ));
    ?>



 <div class = 'help help-title' style = "clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_2');
        ?></div>
<?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model->address,
        'attributes' =>array(
            'street',
            'zip',
            'city',
            'country'
            
        )
    ));
    ?>

<?php
    $resps = [
        'contact_resp',
        'responsable_adj',
        'responsable_op',
        'responsable_qual',
    ];
    foreach ($resps as $resp) {
        ?>


    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_' . $resp); ?></div>

<?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model->$resp,
        'attributes' =>array(
            'firstName',
            'lastName',
            'email',
            'direct_phone'
            
        )
    ));
    }
    ?>
    
    
 <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_4'); ?></div>


  <?php
 $this->widget('zii.widgets.CDetailView', array(
     'data' => $model,
     'attributes' => $model->getAttributesMaterial()
 ));

 $this->widget('zii.widgets.CDetailView', array(
     'data' => $model,
     'attributes' => array('nb_total_samples')
 ));
 ?>

    <div class='help help-title' style="clear: both;margin-bottom: 15px"><?php echo Yii::t('common', 'biobank.form_part_keywords'); ?></div>
<?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'keywords_MeSH',
            'keywords_MeSH_fr',
            'pathologies_en',
            'pathologies',
            'diagnosis_available',
            'snomed_ct'
        )
    ));
    ?>