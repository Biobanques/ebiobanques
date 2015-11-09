




<!-- Cover Page -->
<html>
<head>
<style> 
   
    
    #title{
        
        color:gray;
        text-align: center;
        font-size: 38;
        font-weight:bold;
        width:100%;
        position: absolute;
        margin-bottom: 40px;
       
	
    }
     #infra{
         text-align: center;
         border-width: 10pt;
         margin-bottom: 160px;
         
        
    }
    #edition{
        
         text-align: center;
         border-width: 10pt;
         margin-bottom: 400px;
        
    }
    .box1{
        text-align: center;
        
        padding: 2em 2em 2em 2em;
        height: 95%;
	width:100%;
	border:2px solid #000000;
        margin-left: 20pt; 
        margin-right: 40pt;
        margin-top: 40pt; 
        margin-bottom: 30pt;
	
}
    #box2{
        text-align: center;
        height: 90%;
        margin:auto;
        padding: 0.5em 0.5em 0.5em 0.5em;
	width:100%;
	border:1px solid #ff0000;
        
       
        
	
}
#box3{
        text-align: center;
        height: 90%;
        margin:auto;
        padding:0px;
	width:100%;
	border:1px solid #ff0000;
        position: relative;
      
        
	
}
    #image{
        text-align: center;
    	
    }  
    
</style>
</head>
</html>



   
  <div class="box1">
  
<div id="box2">
    
    <div id="box3">
    
        <div id="infra"> 
         <h2>INFRASTRUCTURE BIOBANQUES </h2>
         
         </div>
     
         <div id="title"> ANNUAIRE DES BIOBANQUES
        </div>
      
           <div id="edition"> 
        <h3>Edition 2015</h3>
        </div>

      
           <div id="image"> 
               <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/fr.png');
                 
                        ?>
        </div>

     

</div>
</div>
      </div>
          
          
 <!-- Index -->
<h3 style=" text-align: center;" >Index géographique des biobanques</h3>

<div class='index'>
     <?php
  // Biobank::Model()->findByAttributes($data->getCity());
            ?>
   </div> 

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
        'template'=>'{items} {pager}',
)); ?>

<div class="box1">
  
<div id="box2">
    
    <div id="box3">
    
        
        </div>


</div>
</div>
          