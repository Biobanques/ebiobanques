
<div style="padding:7px;"><?php
    /* @var $this BiobankController */
    /* @var $model Biobank */
    /* @var $samples Sample */

    try {
        $logo = isset($model->activeLogo) && $model->activeLogo != null && $model->activeLogo != "" ? Logo::model()->findByPk(new MongoId($model->activeLogo)) : null;
    } catch (Exception $ex) {
        $logo = null;
        Yii::app()->user->setFlash('error', 'An error occured with logo, unable to display it');
    }
    ?>
    <div style="padding:10px;">
        <div style="float:left;width:70%;margin-right:20px;text-align: justify;">
            <div><h1><?php echo $model->name; ?></h1></div>
            <div >
                <?php
//display presentation in each lang, function of the lang selected, default english
                if (Yii::app()->language == "fr") {
                    echo $model->presentation;
                } else {
                    echo $model->presentation_en;
                }
                ?>
            </div>

        </div>
        <div style="float:right;width:25%;text-align:right;top: 0px;right: 0px;">
            <?php
            if ($logo != null) {
                echo $logo->toHtml();
            }
            ?>
        </div>
        <div style="clear:both;"></div>
    </div>

    <?php
    $attributes_oblig = array(
        'identifier',
        'name',
        Yii::app()->language == "fr" ? 'keywords_MeSH_fr' : 'keywords_MeSH',
        'diagnosis_available',
        Yii::app()->language == "fr" ? 'pathologies' : 'pathologies_en',
            // array('name' => 'address', 'value' => nl2br($model->getAddress()), 'type' => 'raw',)
    );

    $attributes = $model->getAttributes();
    ?>
    <div id="biobank_oblig" style="width:550px;float:left;">
        <h3><?php echo Yii::t('common', 'biobank_information'); ?></h3>
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => $attributes_oblig
        ));
        ?>
    </div>

    <div id="contact" style="padding-left:20px;width:330px;float:left;">
        <h3><?php echo Yii::t('common', 'contact_information'); ?></h3>
        <?php
        $contact = $model->getContact();
        if (isset($contact)) {
            $attributes_contact = array(
                array('name' => 'last_name', 'value' => $contact->last_name),
                array('name' => 'first_name', 'value' => $contact->first_name),
                array('name' => 'phone', 'value' => $contact->phone),
                array('name' => 'email', 'value' => $contact->email),
                array('name' => 'address', 'value' => $contact->adresse),
                array('name' => 'zipcode', 'value' => $contact->code_postal),
                array('name' => 'city', 'value' => $contact->ville),
                array('name' => 'website', 'value' => $model->getFormattedWebsite(), 'type' => 'raw',),
            );
            $this->widget('zii.widgets.CDetailView', array(
                'data' => $model,
                'attributes' => $attributes_contact
            ));
        } else {
            echo "No contact as been defined for this biobank";
        }
        ?>
    </div>
    <div style="clear:both;"></div>
    <div  id="biobank_sample">
        <h3><?php echo Yii::t('common', 'sample_information'); ?></h3>
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                array('name' => 'nb_total_samples', 'value' => $model->getSampleNumberFormatted()),
                array('name' => 'sample_type', 'value' => $model->getSampleTypeFormatted()),
            )
        ));
        ?>
    </div>
    <div style="clear:both;"></div>
    <br><br>
    <div  id="biobank_qualite">
        <h3><?php echo Yii::t('common', 'quality_information'); ?></h3>
        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                array('name' => 'certification', 'value' => $model->getCertificationFormatted())
            )
        ));
        ?>
    </div>
</div>

