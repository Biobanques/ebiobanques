<?php
class CompletionTools{
/**
 * poids des champs dans le calcul des taux de completion
 * @var unknown
 */
const ID_DEPOSITOR_RATE=1;
const ID_SAMPLE_RATE=1;
const CONSENT_ETHICAL_RATE=1;
const GENDER_RATE=1;
const AGE_RATE=1;
const COLLECT_DATE_RATE=1;
const STORAGE_CONDITION_RATE=1;
const CONSENT_RATE=1;
const SUPPLY_RATE=1;
const MAX_DELAY_DELIVERY_RATE=1;
const DETAIL_TREATMENT_RATE=1;
const DISEASE_OUTCOME_RATE=1;
const AUTHENTICATION_METHOD_RATE=1;
const PATIENT_BIRTH_DATE_RATE=1;
const TUMOR_DIAGNOSIS_RATE=1;
const NOTES_RATE=1;

public function getTotalRates(){
return CompletionTools::ID_DEPOSITOR_RATE +  CompletionTools::ID_SAMPLE_RATE +  CompletionTools::CONSENT_ETHICAL_RATE +  CompletionTools::GENDER_RATE +  CompletionTools::AGE_RATE 
+  CompletionTools::COLLECT_DATE_RATE +  CompletionTools::STORAGE_CONDITION_RATE +  CompletionTools::CONSENT_RATE + CompletionTools::SUPPLY_RATE 
+  CompletionTools::MAX_DELAY_DELIVERY_RATE +  CompletionTools::DETAIL_TREATMENT_RATE +  CompletionTools::DISEASE_OUTCOME_RATE +  CompletionTools::AUTHENTICATION_METHOD_RATE +  
CompletionTools::PATIENT_BIRTH_DATE_RATE +  CompletionTools::TUMOR_DIAGNOSIS_RATE +  CompletionTools::NOTES_RATE; 
}
}
?>
