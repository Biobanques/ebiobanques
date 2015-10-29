<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo $logo;
//if (isset($logo) && $logo != null && is_file(Yii::app()->basePath . '/../images/extractedLogos/' . $logo))
//    echo CHtml::image(Yii::app()->request->baseUrl . '/images/extractedLogos/' . $logo, '', array('style' => 'border:solid 1px black')) . '<br>';



$this->renderPartial('_form', array('model' => $model, 'listLogos' => $listLogos,'biobankIdentifier' =>$biobankIdentifier ));

