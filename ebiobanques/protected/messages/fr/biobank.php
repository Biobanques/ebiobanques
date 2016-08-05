

<?php

/*
 * FR

 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
return [
    /*
     * Properties labels
     */
    'name' => 'Nom de la biobanque',
    'identifier' => 'Code BRIF',
    'collection_id' => 'Identifiant de la collection',
    'acronym' => 'Acronyme de la biobanque',
    'presentation' => 'Description de la biobanque en français',
    'presentation_en' => 'Description de la biobanque en anglais',
    'cert_ISO9001' => 'Certification ISO-9001',
    'cert_NFS96900' => 'Certification NFS-96900',
    'cert_autres' => 'Autres certifications',
    'nb_total_samples' => 'Nombre total d\'échantillons',
    'website' => 'Site Internet',
    'keywords_MeSH' => 'Mots clés MeSH',
    'diagnosis_available' => 'Codes CIM disponibles',
    'pathologies' => 'Pathologies',
    'email' => 'Email',
    /*
     *
     */
    'updateTitle' => 'Mise à jour de la biobanque {name}',
    /*
     * Help popup
     */
    'helpAcronymContent' => 'Indiquez l\'acronyme de la biobanque si disponible.<br>ex : ANSES',
    'helpNameContent' => 'Indiquez le nom complet de la biobanque.<br>ex :  Agence nationale de sécurité sanitaire, de l\'alimentation, de l\'environnement et du travail',
    'helpPresentationContent' => 'Description de la biobanque <b>en français</b>.<br> Cette description pourra être utilisée dans une recherche par mots clés.',
    'helpPresentationEnContent' => 'Description de la biobanque <b>en anglais</b>.<br> Cette description pourra être utilisée dans une recherche par mots clés.',
    'help_nb_total_samplesContent' => 'Nombre total d\'échantillons, approximatif. Ce nombre sera affiché dans une fourchette de valeurs.',
    'helpWebsiteContent' => 'Indiquez ici l\'url du site Internet de la biobanque, sous la forme "http(s)://urlbiobanque.domaine".<br><br>Ex : https://ebiobanques.fr',
    'helpidentifierContent' => 'Le code BRIF est composé de la manière suivante :<br>'
    . 'BB-0033-00XXX',
    'help_keywords_MeSHContent' => 'Mots clés MeSH en anglais. Utiliser "/" comme séparateur<br><br><b>Ex :<br> Liver, neoplasm / Cardiovascular diseases</b>',
    'help_diagnosis_availableContent' => 'Utiliser "/" comme séparateur<br>Vous pouvez indiquer des codes seuls ou des plages<br><br><b>Ex: A15 / B00-B99 / C45</b>',
    'help_pathologiesContent' => 'Nom usuel des pathologies, en français. Utiliser "/" comme séparateur<br><b>Ex: Cancer / Maladies cardiovasculaires</b>',
    'helpPhoneContent' => 'Numéro de télephone au format international :<br>'
    . '+33123456789',
    'helpEmailContent' => 'Email : abcde@xyz.com',
    /*
     * Update form - Main parts titles
     */
    'form_part_1' => 'Nom et descriptions',
    'form_part_2' => 'Adresse',
    'form_part_3' => 'Coordinateur',
    'form_part_4' => 'Materiel biologique disponible',
    'form_part_responsable_adj' => 'Responsable adjoint',
    'form_part_responsable_op' => 'Responsable opérationnel',
    'form_part_responsable_qual' => 'Responsable qualité',
    'form_part_quality' => 'Qualité et certifications',
    'form_part_keywords' => 'Mots clés et codifications',
    /*
     * Misc
     */
    'material_types' => 'Type de matériel biologique stocké',
    'materialStoredDNA' => 'ADN',
    'materialStoredPlasma' => 'Plasma',
    'materialStoredSerum' => 'Sérum',
    'materialStoredTissueFFPE' => 'Tissus en paraffine',
    'materialStoredTissueFrozen' => 'Tissus congelés',
    'materialStoredRNA' => 'ARN',
    'materialStoredSaliva' => 'Salive',
    'materialStoredUrine' => 'Urine',
    'materialStoredBlood' => 'Sang',
    'materialStoredFaeces' => 'Fécès',
    'materialStoredImmortalizedCellLines' => 'Lignées cellulaires',
    'materialTumoralTissue' => 'Tissus tumoraux',
    'materialHealthyTissue' => 'Tissus sains',
    'materialLCR' => 'LCR',
    'materialOther' => 'Autres',
    'phone' => 'Télephone'
];
