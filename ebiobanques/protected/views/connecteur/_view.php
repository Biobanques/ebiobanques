<?php
/* @var $this ConnecteurController */
/* @var $data Connecteur */
?>
<?php
$splitStringArray = split("/", $data->filename);
$fileName = end($splitStringArray);

$uploadDate = $data->uploadDate;
?>
<div class="view">
    <b><?php echo "Nom du fichier :</b> $fileName"; ?>
        <br/>
        <?php echo "Date de chargement :</b>" . date(CommonTools::FRENCH_HD_DATE_FORMAT, $uploadDate->sec); ?>
        <br>
        <?php
        echo CHtml::link(CHtml::encode(Yii::t('common', 'download', array('filename' => $fileName))), array('download', 'id' => $data->_id));
        ?>
        <br />
</div>

