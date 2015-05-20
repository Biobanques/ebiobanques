

<h1><?php echo Yii::t('common', 'sample') . ' #' . $model->biobank_id . '_' . $model->id_sample; ?></h1>
<div style="float:left;">
    <h3 >Caracteristics</h3>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'id_depositor',
            'id_sample',
            'consent_ethical',
            'gender',
            'age',
            'collect_date',
            //TODO normaliser les dates de collecte avant d activer cette feature
            //array('name'=>'collect_date','value'=>CommonTools::toShortDateFR($model->collect_date)),
            array('name' => 'storage_conditions', 'value' => $model->getLiteralStorageCondition()),
            'consent',
            'supply',
            'max_delay_delivery',
            'detail_treatment',
            'disease_outcome',
            'authentication_method',
            'patient_birth_date',
            'tumor_diagnosis'
        ),
    ));
    ?>
</div>
<div style="float:left;padding-left:10px;">
    <div>
        <h3 style="margin-bottom:-5px;" >Notes</h3>
        <?php
        $notesDataProvider = new CArrayDataProvider($model->notes, array('keyField' => 'key'));
        $this->widget('zii.widgets.grid.CGridView', array(
            'dataProvider' => $notesDataProvider,
            'template' => '{items}{pager}',
            'columns' => array(
                array('header' => 'Key', 'value' => '$data->key'),
                array('header' => 'Value', 'value' => '$data->value'),
            )
                )
        );
        ?>
    </div>
    <div>
        <h3 >Biobank informations</h3>
        <?php
        $data = Biobank::model()->findByPk(new MongoId($model->biobank_id));
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $data,
            'attributes' => array(
                array('name' => 'biobank', 'value' => $data->identifier),
                array('name' => 'contact', 'value' => $data->getShortContact()),
                array('name' => 'email', 'value' => $data->getEmailContact()),
                array('name' => 'phone', 'value' => $data->getPhoneContact()),
            ),
        ));
        ?>
    </div>
</div>
<div style="clear:both;"></div>