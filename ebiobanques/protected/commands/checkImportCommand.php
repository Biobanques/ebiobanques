<?php

        class checkImportCommand extends CConsoleCommand
        {

        	
          public function run($args)
          {
 include_once dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'CommonMailer.php';         	
 $biobanks = Biobank::model()->findAll();
foreach($biobanks as $biobank){
	$lastImportDate = FileImported::model()->getDateLastImportByBiobank($biobank->id);
	$today = date('Y-m-d H:i:s');
	$diffSec=strtotime($today)-strtotime($lastImportDate);
	$diffJours=round($diffSec/60/60/24,0);
	if($diffJours>=30&&($diffJours-30)%5==0){
	CommonMailer::sendMailRelanceExport($biobank->getContact(),$lastImportDate, $diffJours);
	}
}
echo "Check des imports effectués et relances envoyées\n";

          	}
          }
          
        
?>