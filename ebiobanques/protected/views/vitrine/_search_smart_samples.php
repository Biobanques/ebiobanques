<div style="padding: 5px;border:1px solid blueviolet;background-color: #D8E4F1;">
    <img src="<?php echo Yii::app()->request->baseUrl . '/images/'; ?>information.gif"/><div style="display: inline;margin-left: 5px;"><b><?php echo Yii::t('sample', 'helpSearchTitle') ?></b></div>
    <div style="margin-left: 5px;">
        <!--        Le champ de recherche permet d'effectuer des recherches complexes parmi les échantillons.<br>
                Les critères saisis doivent être séparés par un espace. <br>
                Les critères sont inteprétés pour effectuer une recherche approfondie des données parmi les données disponibles.<br>
                Les valeurs de comparaison doivent être ajoutées à droite du comparateur.<br>
                Exemples d'utilisation :
                <ul><li>male 35years
                    <li>H >=28ans
                    <li>H >35ans <60ans TO
                </ul>
                Les champs analysés lors de cette recherche sont le sexe, l'age, et les notes.<br>
                Les notes sont des champs libres pouvant contenir tout type d'information non normalisée.<br>
                Si votre recherche contient de nombreux critères, nous vous conseillons d' utiliser le formulaire de recherche avancée.-->
        <?php
        echo Yii::t('sample', 'helpSearchContent');
        ?>
    </div>
</div>

<div class = "wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route, array('id' => $this->biobank->id)),
        'method' => 'post',
    ));
    ?>

    <div>
    </div>
    <div class="row">
        <?php echo $form->label($smartForm, 'expression'); ?>
        <?php echo $form->textField($smartForm, 'keywords', array('style' => 'width:400px',)); ?>

        <?php echo CHtml::submitButton('Search'); ?>

    </div>

    <?php $this->endWidget(); ?>

</div><!-- smart search-form -->