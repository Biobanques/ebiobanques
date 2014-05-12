<div style="float:left;width:680px;padding-left:5px;padding-right:5px;padding-top:10px">
<h1><?php echo Yii::t('common','echUpdate')." #".$model->biobank_id.'_'.$model->id_sample; ?></h1>
<?php echo $this->renderPartial('_echForm', array('model'=>$model)); ?>
</div>
<div style="clear:both;"/>