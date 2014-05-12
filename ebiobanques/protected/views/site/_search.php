<?php
/* @var $this BiobankController */
/* @var $model Biobank */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table>
	<tr>
		<td>
		<?php echo $form->label($model,'identifier'); ?>
		<?php echo $form->textField($model,'identifier',array('size'=>45,'maxlength'=>45)); ?>
		</td>
	</tr>
	<tr>
		<td>
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		</td>
	</tr>
	<tr>
		<td>
		<?php echo $form->label($model,'collection_id'); ?>
		<?php echo $form->textField($model,'collection_id',array('size'=>45,'maxlength'=>45)); ?>
		</td>
	</tr>
</table>

 	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('common','search')); ?>
 	</div>


<?php $this->endWidget(); ?>

</div><!-- search-form -->