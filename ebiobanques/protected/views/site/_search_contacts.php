<?php
/* @var $this ContactController */
/* @var $model Contact */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php

$form = $this->beginWidget ( 'CActiveForm', array (
		'action' => Yii::app ()->createUrl ( $this->route ),
		'method' => 'get' 
) );
?>

<table>
		<tr>
			<td>
				<?php echo $form->label($model,'first_name'); ?>
				<?php echo $form->textField($model,'first_name',array('size'=>20,'maxlength'=>250)); ?>
			</td>
			<td>
				<?php echo $form->label($model,'last_name'); ?>
				<?php echo $form->textField($model,'last_name',array('size'=>20,'maxlength'=>250)); ?>
			</td>
			</tr>
			<tr>
			<td>
				<?php echo $form->label($model,'ville'); ?>
		<?php echo $form->textField($model,'ville',array('size'=>20,'maxlength'=>50)); ?>
			</td>
			<td>
					<?php echo $form->label($model,'pays'); ?>
		<?php echo $form->textField($model,'pays',array('size'=>20, 'maxlength'=>50)); ?>
			</td>
			</tr>
			<tr>
			<td>
			<?php //$biobank = new Biobank;?>
			<?php //echo $form->label($model,'biobank'); ?>
		 	<?php //echo $form->dropDownList($model,'biobank',$biobank->getArrayBiobanks(),array('prompt' => '----'));
 			?>
		</td>
			</tr>
	</table>

<!-- 			 	<div class="row buttons">  -->
		<?php echo CHtml::submitButton(Yii::t('common','search')); ?>
<!-- 	</div> -->

<?php $this->endWidget(); ?>

</div>
		<!-- search-form -->