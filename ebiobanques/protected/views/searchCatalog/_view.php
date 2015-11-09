<?php
/* @var $this SearchCatalogController */
/* @var $data Biobank */
?>

<html>
<head>
<style> 
    
    h4{
        color:red;
    }
    
 .name{
        page-break-before: always;
        font-weight:bold;
        }
        

    
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

#container{
    background:gold;
    box-shadow: 3px 3px 2px #666666;
    width: 100%;
    
}



</style>
</head>
</html>

<!-- Biobank's name-->

<div class='name'>
    
  <?php echo $data->name;?>
       
</div>

<!-- Biobank's identifier-->
<div class='id'>
    
    <?php echo CHtml::encode($data->getAttributeLabel('Identifiant BRIF')); ?>:
	<b><?php echo CHtml::encode($data->identifier); ?><b>
	
</div>
<br />

<div id="container">
    
<!-- Biobank's contact-->
<div id='contact'
     >
    
   <h4  > 
       <?php echo CHtml::encode($data->getAttributeLabel('Coordinateur')); ?>:
       </h4>
      
      <?php  echo  $data->contact_id != null && !empty($data->contact_id) ?'<b>' . CHtml::encode($data->getShortContactInv()) . '</b>' . '<br>' . CHtml::encode($data->getPhoneContactPDF()) . '<br>' . CHtml::encode($data->getEmailContact()): "" ; ?>
       
</div>

<!-- Biobank's adress-->
<div id='adress'>
   <h4 > 
       <?php echo CHtml::encode($data->getAttributeLabel('adresse')); ?>:
       </h4>
      
	<?php echo nl2br($data->getAddress());?>
    <br>
    
      <b><?php if (isset($data->website)) 
       echo $data->website;?> </b>
      
    </div>
</div>

<!-- Biobank's attributes-->        
<div class='view'>
     <?php
    foreach (Biobank::Model()->attributeExportedLabels() as $attribute => $value) {
        if (isset($data->$attribute)) {
            ?>
   
            <h4 >
                <?php echo CHtml::encode($data->getAttributeLabel($attribute)); ?>:</h4>
             
             
             <p>   <?php
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
                
                default:
                   // echo CHtml::encode($data->$attribute);
                    break;
               
  
            }
            ?>
             </p>
            
            <?php
        }
    }
    ?>
   
</div>