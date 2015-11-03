<?php
/* @var $this SearchCatalogController */
/* @var $data Biobank */
?>

<html>
<head>
<style> 
    
    
#contact
{

width:40%;
border:thin #000000 solid;
position:relative;
padding:0px;
margin-left:2%;
margin-right:auto;
float:left;

}

#adress
{

width:40%;
border:thin #000000 solid;
position:relative;
padding:0px;
margin-right:2%;
margin-left:auto;
float:right;
}

</style>
</head>
</html>


<!-- Biobank's name-->

<div class='name'>
    
    <b> <?php echo $data->name;?></b>
       
</div>

<!-- Biobank's identifier-->
<div class='id'>
    
    <?php echo CHtml::encode($data->getAttributeLabel('Identifiant BRIF')); ?>:
	<b style="font-size:medium;"><?php echo CHtml::encode($data->identifier); ?><b>
	
</div>
<br />

<div id="container" style ="background:gold;box-shadow: 3px 3px 2px #666666; width: 100%;">
    
<!-- Biobank's contact-->
<div id='contact'
     >
    
   <b style="color:red;line-height:30pt;" > 
       <?php echo CHtml::encode($data->getAttributeLabel('Coordinateur')); ?>:
       </b>
      <br />
      <br />
      
      <?php  echo  $data->contact_id != null && !empty($data->contact_id) ?'<b>' . CHtml::encode($data->getShortContactInv()) . '</b>' . '<br>' . CHtml::encode($data->getPhoneContactPDF()) . '<br>' . CHtml::encode($data->getEmailContact()): "" ; ?>
       
</div>

<!-- Biobank's adress-->
<div id='adress'>
   <b style="color:red;" > 
       <?php echo CHtml::encode($data->getAttributeLabel('adresse')); ?>:
       </b>
      <br />
      <br />
	<?php  echo nl2br($data->getAddress()); ?>
    
    </div>
    <br />
</div>

<br />
<br />
        
<div class='view'>
     <?php
    foreach (Biobank::Model()->attributeExportedLabels() as $attribute => $value) {
        if (isset($data->$attribute)) {
            ?>
   
            <b style="color:red;">
                <?php echo CHtml::encode($data->getAttributeLabel($attribute)); ?>:</b>
             <br />
             <br />
               <?php
            switch ($attribute) {
                case 'presentation':
                    echo nl2br($data->presentation);
                    break;
                case 'thematiques':
                    echo nl2br($data->thematiques);
                    break;
                case 'projetRecherche':
                    echo nl2br($data->projetRecherche);
                    break;
                case 'publications':
                    echo nl2br($data->publications);
                    break;
                 case 'reseaux':
                    echo nl2br($data->reseaux);
                    break;
                case 'qualite':
                    echo nl2br($data->qualite);
                    break;
                
                case 'website':
                    echo CHtml::link($data->website, array('target' => 'blank'));
                    break;
                
                default:
                   // echo CHtml::encode($data->$attribute);
                    break;
               
  
            }
            ?>
            <br />
            <br />
            <?php
        }
    }
    ?>
    <br />
    <br />
</div>