<div style="float:left;width:900px;padding-left:5px;padding-right:5px;padding-top:10px">
<h1><?php echo Yii::t('common','userUpdate').' : '.$model->prenom.' '.$model->nom; ?></h1>
</div>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>