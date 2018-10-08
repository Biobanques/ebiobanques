<?php
$num_biobank = count(Biobank::model()->findAll()); 

return array(
    'accueil' => 'Home',
    'administration' => 'Management',
    'seconnecter' => 'Login',
    'sedeconnecter' => 'Logout',
    'dashboard' => 'Dashboard',
    'Search' => 'Search',
    'FAQ' => 'Frequently asked questions',
    'activities' => 'Activities',
    'ChampsObligatoires' => 'Fields with <span class="required">*</span> are required.',
    'yes' => 'Yes',
    'no' => 'No',
    'contactus' => 'Contact us',
    'contactus_phrase' => 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.',
    'contactForm_name' => 'Name',
    'contactForm_email' => 'Email',
    'contactForm_subject' => 'Subjet',
    'contactForm_body' => 'Body',
    'contactForm_verifcode' => 'Verification code',
    'submit' => 'Submit',
    'explain_verify_code' => 'This verification code helps us to ensure you are not a machine.',
    'searchsamples' => 'Search samples',
    'biobanks' => 'Biobanks',
    'contacts' => 'Contacts',
    'myaccount' => 'My account',
    'administration' => 'Administration',
    'totalnumbersamples' => 'The count of samples in the database is',
    'advancedsearch' => 'Advanced search',
    'keywords' => 'Keywords',
    'smartsearchexplain' => 'Tool in beta version. You can use keywords like "male T4N2M0" to find samples quickly.<br>
								At this time, the fields searchables by this tools are : Notes & Gender',
    'firstname' => 'First name',
    'lastname' => 'Last name',
    'email' => 'Email',
    'phone' => 'Phone',
    'address' => 'Address',
    'city' => 'City',
    'country' => 'Country',
    'zipcode' => 'Zip code',
    'biobank' => 'Biobanque',
    'search' => 'Search',
    'bbadmin' => 'My biobank',
    'bbManage' => 'Manage biobank',
    'bbUpdate' => 'Update biobank',
    'old_update' => 'old update',
    'echManage' => 'Manage samples',
    'benchmarking' => 'Benchmarking',
    'msgAnnulModif' => 'Warning : all updates will be lost at the next sending of data.',
    'saveBtn' => 'Save',
    'createBtn' => 'Create',
    'requiredField' => 'Fields with <span class="required">*</span> are required.',
    'userUpdate' => 'Update user',
    'user_view'=>'Profile user',
    'create_user'=> 'Create user',
    'manage_users'=> 'Manage users',
    'inscription_date'=> 'Inscription date',
    'prefsSelect' => 'Select columns to display',
    'choseDemand' => 'Active application',
    'proceedApplication' => 'Proceed application',
    'success_register' => 'Your application has been send , you will receive an email when it will be approved.',
    'error_register' => 'An error occured during your registration, please try later.',
    'inactive' => 'Inactive',
    'active' => 'Active',
    'identifier' => 'Identifier',
    'name' => 'Name',
    'collection_name' => 'Pathology',
    'collection_id' => 'Collection id',
    'date_entry' => 'Date of entry',
    'folder_reception' => 'Reception folder',
    'folder_done' => 'Done folder',
    'passphrase' => 'Passphrase',
    'echUpdate' => 'Update of sample ',
    'Login' => 'Login',
    'notUnique' => 'is already in database. Please chose abother one.',
    'notEnoughDigits' => 'Password must contain at least 2 digits.',
    'FiReAct' => 'Files reception activity',
    'LoSaCh' => 'Location samples chart',
    'BioBkReg' => 'Biobanks registered',
    'SaReAct' => 'Samples reception activity',
    'identifyYou' => 'Please fill out the following form with your login credentials:',
    'rememberMe' => 'Remember me next time',
    'userName' => 'Username',
    'password' => 'Password',
    'passwordCompare' => 'Repeat password',
    'noAccount' => 'Create an account',
    'subscribe' => 'Subscribe',
    'invalidUsername' => 'Invalid username.',
    'invalidPassword' => 'Incorrect password.',
    'inactiveProfil' => 'Your profil is inactive. Please contact an admin.',
    'gsm' => 'Mobile phone',
    'verifyCode' => 'Verification code',
    'save' => 'Save',
    'BetaSmartSearch' => 'Smart search - beta tool',
    'idUser' => 'User id',
    'expression' => 'Expression',
    'indexTitle' => 'ebiobanques.fr: Improving research of biological material',
    'indexContent_p1' => '&nbsp;&nbsp; <b>ebiobanques</b>.fr</b> is a catalog of the BIOBANQUES network containing information collected from its '.$num_biobank.' members and allowing access to 6 millions of biological samples.

<br><br>&nbsp;&nbsp; To explore ebiobanques, you need to be a registered user. Please click on <a href="/index.php/site/login">login</a> then “subscribe” to create your account.
A validation email will be sent to you within 24h.

<br><br>&nbsp;&nbsp; <a href="/index.php/catalog/search/">In Catalog of biobanks</a>, you will find information on biobanks, pathologies, sample types and biobank relevant contacts.',
    'faq_t1' => 'How can I find biological samples for my research project? ',
    'faq_c1' => ' Search samples by pathology in the Catalog of biobanks (use Advanced search)',
    'faq_t2' => ' How can I request biological samples?',
    'faq_c2' => ' For the process and request form, please click <a href="http://www.biobanques.eu/en/services/biospecimen-request">here</a>. The request form is also available on the top button. ',
    'faq_t3' => ' How much do samples cost?',
    'faq_c3' => ' To promote partnerships between BCRs and sample requesters, as well as transparency, BIOBANQUES implemented a <a href="http://www.biobanques.eu/files/grille-tarifaire-biobanques-pd-96YV5RLABE.pdf">tarification grid</a> to evaluate cost. This grid is based on objective international criteria and offers 3 billing levels corresponding to 3 levels of partnerships.',
    'faq_t4' => ' How does it take to receive my samples?',
    'faq_c4' => ' Following reception and validation of your request form, BIOBANQUES sends it to its network. Response times from BRCs can vary. We however closely follow up with centers of our network (phone, email, request at European level if necessary) in the following month to ensure that you promptly receive your samples for your research project.',
    'faq_t5' => ' How can BIOBANQUES help me?',
    'faq_c5' => 'When requesting biological samples, BIOBANQUES can also provide you with <a href="http://www.biobanques.eu/en/offre-de-services/ethics-regulations">Ethics and Regulatory</a> services to facilitate all the steps necessary for accessing samples (Material Transfer Agreement, partnership contract, ethics questions, international laws,…)
BIOBANQUES can offer you several expert services and technical platforms for setting up all the steps of your research project. <a href="http://www.biobanques.eu/en/service-request">Contact us for more information.</a> ',
    'forgotedPwd' => 'Forgot password',
    'atLeastOneField' => 'You have to fill at least one field to get your password back.',
    'recoverMessageSent' => 'A message with your credentials was sent at the following mail adress : {userEmail}',
    'noUserWithEmailAndIdentifier' => 'There is no user in our database with the identifier \'{badIdentifier}\' and the email \'{badEmail}\'',
    'noUserWithEmail' => 'There is no user in our database with the email \'{badEmail}\'',
    'noUserWithIdentifier' => 'There is no user in our database with the identifier \'{badIdentifier}\'',
    'download' => 'Download {filename}',
    'noBiobankFound' => 'The biobank website cannot be found, please chose one in the following list',
    'subscribeHelpTitle' => 'IMPORTANT : registration process',
    'subscribeHelpContent' => 'Subscription to ebiobanques.fr comprises a step of validation of your account.<br> '
    . '<b> Your registration will be effective when your account has been validated by the administrator of the platform .</b> The maximum period of account validation is 24 .<br>'
    . 'If you encounter a problem during this step, please contact the bioinformatics service of Biobanks infrastructure.',
    'atLeastOneTel' => 'At least one phone number must be specified. ',
    'onlyAlpha' => 'Only the alphabetic characters are allowed for this field.',
    'onlyAlphaNumeric' => 'Only the alphanumeric characters are allowed for this field.',
    'diagnosisAvailable' => 'Diagnosis available',
    'website' => 'Web site',
    'catalog' => 'Catalog of biobanks',
    'shortContact' => 'Contact\'s name and first name',
    'emailContact' => 'Contact\'s email',
    'phoneContact' => 'Contact\'s phone',
    'InvalidPhoneNumber' => 'Invalid phone number.',
    'qualityCombinate' => 'Quality fields',
    'Map of biobanks' => "Map of biobanks",
    'show map' => 'Show map of biobanks',
    'undefined' => 'Undefined',
    'presentation_en' => 'Description in english',
    'sample_information' => 'Sample Information',
    'quality_information' => 'Quality Information',
    'contact_information' => 'Contact Information',
    'in_progress' => ' In progress',
    /*
     * BIOBANK
     */
    /*
     * Properties labels
     */
    'biobank.name' => 'Name of biobank',
    'biobank.identifier' => 'Identifier',
    'biobank.collection_id' => 'Collection identifier',
    'biobank.acronym' => 'Biobank acronym ',
    'biobank.presentation' => 'Biobank description in french',
    'biobank.presentation_en' => 'Biobank description',
    'biobank.cert_ISO9001' => 'Certification ISO-9001',
    'biobank.cert_NFS96900' => 'Certification NFS-96900',
    'biobank.cert_autres' => 'Others certifications',
    'biobank.nb_total_samples' => 'Sample number',
    'biobank.website' => 'Website',
    'biobank.keywords_MeSH' => 'MeSH keywords',
    'biobank.keywords_MeSH_fr' => 'MeSH keywords in french',
    'biobank.diagnosis_available' => 'ICD code available',
    'biobank.snomed_ct' => 'SNOMED-CT',
    'biobank.pathologies' => 'Pathologies in french',
    'biobank.pathologies_en' => 'Pathologies',
    'biobank.email' => 'Email',
    /*
     *
     */
    'biobank.updateTitle' => 'Update of the biobank {name}',
    'biobank.createTitle' => 'Create a biobank ',
    /*
     * Update form - Main parts titles
     */
    'biobank.form_part_1' => 'Name and description',
    'biobank.form_part_2' => 'Address',
    'biobank.form_part_3' => 'Coordinator',
    'biobank.form_part_4' => 'Biological material available',
    'biobank.form_part_contact_resp' => 'Coordinator',
    'biobank.form_part_responsable_adj' => 'Deputy manager',
    'biobank.form_part_responsable_op' => 'Operational manager',
    'biobank.form_part_responsable_qual' => 'Quality manager',
    'biobank.form_part_quality' => 'Quality and certifications',
    'biobank.form_part_keywords' => 'Keywords and coding',
    /*
     * Misc
     */
    'biobank.material_types' => 'Biological material types stored',
    'biobank.materialStoredDNA' => 'DNA',
    'biobank.materialStoredPlasma' => 'Plasma',
    'biobank.materialStoredSerum' => 'Serum',
    'biobank.materialStoredTissueFFPE' => 'FFPE Tissue',
    'biobank.materialStoredTissueFrozen' => 'Frozen Tissue',
    'biobank.materialStoredRNA' => 'RNA',
    'biobank.materialStoredSaliva' => 'Saliva',
    'biobank.materialStoredUrine' => 'Urine',
    'biobank.materialStoredBlood' => 'Blood',
    'biobank.materialStoredFaeces' => 'Stools',
    'biobank.materialStoredImmortalizedCellLines' => 'Cell lines',
    'biobank.materialTumoralTissue' => 'Pathological Tissue',
    'biobank.materialHealthyTissue' => 'Healthy/control Tissue',
    'biobank.materialLCR' => 'CSF',
    'biobank.materialPBMC' => 'PBMC',
    'biobank.materialBuffyCoat' => 'Buffy coat',
    'biobank.materialPrimaryCells' => 'Primary cells',
    'biobank.materialOther' => 'Others',
    'biobank.phone' => 'Phone',
    'biobank.sample_type' => 'Sample type',
    'catalog_intro' => 'This part of the website lists all the biobanks of the French network. Pathologies are identified by their usual name, ICD 10 code or MeSH keywords.
<br><br>Biobank information details (sample type, certification, etc.) are available by clicking on the magnifying glass symbol (right column).
<br><br>Search for specific pieces of information from all biobanks can be done using “Advanced search”
<br><br>You can print or export (pdf, csv, excel) the entire directory or the information you selected using the top-right button of the table.',
    'icd_example' => '(ICD code, ex: C00)',
    'biobank_information' => 'Biobank information',
    'profil' => 'Profile',
    'standard_user'=> 'Standard user',
    'system_admin'=> 'System admin',
    'biobank_admin'=> 'Biobank admin',
    'button_ask_samples' => 'Request biological samples',
    'thematiques' => 'Thematics in french',
    'thematiques_en' => 'Thematics',
    'presentation' => 'Description in french',
    'presentation_en' => 'Description',
    'projetRecherche' => 'Research projects in french',
    'projetRecherche_en' => 'Research projects',
    'publications' => 'Publications',
    'reseaux' => 'Networks',
    'qualite' => 'Quality in french',
    'qualite_en' => 'Quality',
    
    'exported_fields'=> 'Exported Field',
   
    'create_biobank'=>'Create biobank',
    'manage_fields_of_biobanks_directory' =>'Manage fields of biobanks directory',
    'upload_a_logo'=>'Upload a logo',
    'manages_biobanks' => 'Manage of biobanks',
    'export_field'=> 'Export fields',
    'admin_page' => 'Welcome to admin page',
    'disable' =>' Disable',
    'enable'=>'Enable',
    'validate'=> 'Validate',
    'resetBtn' => 'Reset',
    'updateBtn' => 'Update',
    
    'system_log' => 'System log',
    'userLog' => 'User log',
    
// Stats biobank
    
    'fields_biobank'=> 'different fields on these biobanks',
    'average_rate_completeness'=>'The average rate of completeness per biobank is',
    'rate_completeness'=> 'Rate of completeness per field',
    'completion_rate'=> 'Completion rate',
    'global_stats'=> 'Global stats',
    'biobank_ base'=>'biobanks',
    'missing_fields'=> 'Missing fields',
    'present_fields'=> 'Present fields',
    'biobanks_global_stats' => 'Biobanks global stats',
    'detailed_stats_biobank' => 'Detailed statistics of the biobank',
    'completion_rate' => 'Completion rate',
    
    'select_biobank'=> 'Select a biobank',
    'biobank'=> 'Biobank',
    
    //flash message
    
    'error_create_biobank'=> 'The biobank has not been save!',
);
?>