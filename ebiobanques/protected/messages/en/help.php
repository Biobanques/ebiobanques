<?php

return array(
    'remplirPanier' => '<b>How manage your samples application.</b><br>To manage your requests for samples ebiobanques.fr suggest you search and then check the samples in the table.<br>
Once selected samples, you only have to click on the "proceed application" link and follow the process of multi-site application.',
        /*
     * Help popup
     */
    'helpAcronymContent' => 'Indicate the acronyme of the biobank if it is available. This attribute refers to the MIABIS 2.0-02 attribute.<br>ex : ANSES',
    'helpNameContent' => 'Indicate the complete name of the biobank.<br>ex : Human Tissue Resource Network',
    'helpPresentationContent' => 'Description of the biobank <b>in french</b>.<br> this description can be used in the keywords search.',
    'helpPresentationEnContent' => 'Description de la biobanque <b>in english</b>.<br> this description can be used in the keywords search.',
    'help_nb_total_samplesContent' => 'Total number of samples,integer number is required, an aproximative value is autorised. this number will be dispalyed in the format power of 10',
    'helpWebsiteContent' => 'Indicate the website URL of the biobank, in the form of "http(s)://urlbiobank.domain".<br><br>Ex : https://ebiobanques.fr',
    'helpidentifierContent' => 'the BRIF code, it is composed as follows  :<br>'
    . 'BB-0033-00XXX',
    'help_keywords_MeSHContent' => 'MeSH Keywords in english. Use the field separator "/" <br><br><b>Ex :<br> Liver, neoplasm / Cardiovascular diseases</b>',
    'help_keywords_MeSHFRContent' => 'MeSH Keywords only in french . Use the field separator "/" <br><br><b>Ex :<br> Foie, neoplasmes / maladies cardiovasculaires</b>',
    
    'help_diagnosis_availableContent' => 'Use the field separator "/"<br> You can indicate a unique code or ranges <br><br><b>Ex: A15 / B00-B99 / C45</b>',
    'help_pathologiesContent' => 'Usual name of pathologies, in french. Use the field separator "/" <br><b>Ex: Cancer / Maladies cardiovasculaires</b>',
    'help_pathologiesenContent' => 'Usual name of pathologies, in english. Use the field separator "/"  <br><b>Ex: Cancer / cardiovascular diseases</b>',
    'help_snomed_ctContent'=> 'Systematized Nomenclature of Medicine – Clinical Terms. Use the field separator "/" <br><b>Ex: Pneumonia</b> ',
    'helpPhoneContent' => 'Phone number in the international format :<br>'
    . '+33123456789',
    'helpEmailContent' => 'Email : abcde@xyz.com',
    'help_others_certifications'=>'This field must contains the declaration of others certifications done, separated by a comma.It must contains / to indicate that no other certification has been done. <br> Ex : Certification ISO 10001, Certification AFNOR 032',
    'helpCatalogSearch'=>'You can enter many keywords (identifier, city, ICD code, etc), using the space as separator.<br> Examples:<ul><li> animal anses<li> brain C00 <li> D50-D89 </ul>',
);
?>