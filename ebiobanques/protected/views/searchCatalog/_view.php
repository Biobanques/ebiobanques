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
    
    .id{
        
}
    
 .name{
        page-break-before: always;
        font-weight:bold;
        float:left;
        }
        
  .logo{
         height: auto; 
         width: auto; 
         max-width: 120px; 
        float:right;
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

#address
{

width:40%;
border:thin #000000 solid;
position:relative;
padding:0px;
margin-right:2%;
margin-left:auto;
float:right;
}

#box{
    background:gold;
    box-shadow: 3px 3px 2px #666666;
    width: 100%;
    
}
#container2{
    background:red;
    width: 100%;
    
}

</style>
</head>
</html>

<!-- Biobank's name-->
                 
  <div id="container2">                      
<div class='name'>
    
  <?php echo $data->name;?>
       
</div>

<!-- Biobank's identifier-->
<div class='id' style = float:left;>
    
    <?php echo CHtml::encode($data->getAttributeLabel('Identifiant BRIF')); ?>:
	<b><?php echo CHtml::encode($data->identifier); ?><b>
	
</div>
</div>
<br />

<div class="logo">
    
    <?php 
    
    //$logo = isset($data->activeLogo) && $data->activeLogo != null && $data->activeLogo != "" ? Logo::model()->findByPk(new MongoId($data->activeLogo)) : null;
   //  if ($logo != null) {
      // echo $logo->toHtml();   
     //  }
       // if(isset($data->activeLogo) && ($data->activeLogo != null) && ($data->activeLogo != "")){
       // $logo=  Logo::model()->findByPk(new MongoId($data->activeLogo));
        // echo $logo->toHtml(); 
        
      //  }
       // else echo 'No disponible';
        ?> 
    
</div>


<div id="box">
    
<!-- Biobank's contact-->
<div id='contact'
     >
    
   <h4  > 
       <?php echo CHtml::encode($data->getAttributeLabel('Coordinateur')); ?>:
       </h4>
      
      <?php  echo  $data->contact_id != null && !empty($data->contact_id) ?'<b>' . CHtml::encode($data->getShortContactInv()) . '</b>' . '<br>' . CHtml::encode($data->getPhoneContactPDF()) . '<br>' . CHtml::encode($data->getEmailContact()): "" ; ?>
       
</div>

<!-- Biobank's adress-->
<div id='address'>
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