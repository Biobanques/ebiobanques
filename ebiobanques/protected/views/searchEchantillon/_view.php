<?php
/* @var $this SearchEchantillonController */
/* @var $data Echantillon */
?>

<div class='view'>
<?php 
foreach(Echantillon::Model()->attributeExportedLabels() as $attribute=>$value){
?>
<b><?php echo CHtml::encode($data->getAttributeLabel($attribute)); ?>:</b>
<?php 
if($attribute=='biobank_id'){
		echo CHtml::encode(Biobank::Model()->findByPk($data->$attribute)->identifier);?>
		<?php 
		}elseif($attribute=='notes'){
foreach($data->notes as $note){
if($note->VALEUR!=null&&!empty($note->VALEUR)){
echo CHtml::encode($note->CLE.' : '.$note->VALEUR);
?><br><?php 
}}
 }elseif ($attribute=="storage_conditions"){


 echo CHtml::encode($data->getLiteralStorageCondition());
 }elseif ($attribute=="gender"){
$genderList=$data->getArrayGender();
 	echo CHtml::encode($genderList[$data->gender]);
 	}elseif ($attribute=="consent"||$attribute=='consent_ethical'){
$consentList=$data->getArrayConsent();
 		echo CHtml::encode($consentList[$data->$attribute]);
		}else
echo CHtml::encode($data->$attribute); ?>
<br />
<?php }?>
		<br />
		<br />
</div>