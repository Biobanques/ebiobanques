<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BiocapForm extends CFormModel
{
    /*
     * Mode de requete choisi
     */
    public $mode_request = 0;
    /*
     * DIAGNOSTIC BLOCK
     */
    public $iccc_group;
    public $iccc_sousgroup;
    public $iccc_group1;
    public $iccc_group2;
    public $iccc_group3;
    public $iccc_sousgroup1;
    public $iccc_sousgroup2;
    public $iccc_sousgroup3;
    public $topoOrganeType = 'cimo';
    public $topoOrganeField;
    public $topoOrganeField1;
    public $topoOrganeField2;
    public $topoOrganeField3;
    public $morphoHistoType = 'cimo';
    public $morphoHistoField;
    public $morphoHistoField1;
    public $morphoHistoField2;
    public $morphoHistoField3;
    public $metastasique = 'inconnu';
    public $cr_anapath_dispo = 'inconnu';
    public $donCliInBase = 'inconnu';

    /*
     * PATIENT BLOCK
     */
    public $age;
    public $sexe = 'inconnu';
    public $stat_vital = 'inconnu';
    public $ano_chrom_constit;
    public $affect_gen;

    /*
     * PRELEVEMENT-ECHANTILLON BLOCK
     */


    /*
     * PRELEVEMENT SUB-BLOCK
     */
    public $evenement;
    public $avantChimio = 'inconnu';
    public $type_prelev;
    public $mode_prelev;
    /*
     * ECHANTILLON TUMORAL SUB-BLOCK
     */
    public $ETL;
    public $ETLLoc;
    public $ETLTyp;
    public $ETLDer;


    /*
     * ECHANTILLON NON TUMORAL SUBBLOCK
     */
    public $ENTA;
    public $ENTLoc;
    public $ENTTyp;
    public $ENTDer;
    public $ENTRBA;

    /*
     * CONSENTEMENT SUBBLOCK
     */
    public $consent_rech = 'inconnu';
    public $consent_RGC = 'inconnu';

    public function rules() {
        $result = array(
            array('metastasique,cr_anapath_dispo,donCliInBase', 'yesNoValidate'),
            array('avantChimio', 'yesNoUnknowValidate'),
        );
        foreach ($this->attributes as $attName => $attValue) {
            $result[] = array($attName, 'safe');
        }
        return $result;
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            /*
             * DIAGNOSTIC
             */
            'iccc_group' => 'Groupe ICCC',
            'iccc_group1' => 'Groupe ICCC',
            'iccc_group2' => 'Groupe ICCC',
            'iccc_group3' => 'Groupe ICCC',
            'iccc_sousgroup' => 'Sous groupe ICCC',
            'iccc_sousgroup1' => 'Sous groupe ICCC',
            'iccc_sousgroup2' => 'Sous groupe ICCC',
            'iccc_sousgroup3' => 'Sous groupe ICCC',
            'topoOrganeField' => 'Code CIM topo',
            'topoOrganeField1' => 'Code CIM topo',
            'morphoHistoField' => 'Code CIM Morpho',
            'morphoHistoField1' => 'Code CIM Morpho',
            'metastasique' => 'Métastasique',
            'cr_anapath_dispo' => 'CR anapath disponible',
            'donCliInBase' => 'Données cliniques en base',
            /*
             * PATIENT
             */
            'age' => 'Age au prélèvement',
            'age[0-1]' => '0-1 an',
            'age[2-4]' => '2-4 ans',
            'age[5-9]' => '5-9 ans',
            'age[10-14]' => '10-14 ans',
            'age[15+]' => '&ge;15 ans',
            'sexe' => 'Sexe',
            'stat_vital' => 'Statut vital',
            'ano_chrom_constit' => 'Anomalie chromosomique constitutionnelle',
            'affect_gen' => 'Affection génétique',
            /*
             * PRELEVEMENT-ECHANTILLON
             */
            'evenement' => 'Evènement',
            'evenement[diag_init]' => 'Diagnostic initial',
            'evenement[rechute]' => 'Rechute',
            'evenement[sec_cancer]' => 'Second cancer',
            'avantChimio' => 'Avant chimio',
            'type_prelev' => 'Type de prélèvement',
            'type_prelev[tissu]' => 'Tissu',
            'type_prelev[moelle]' => 'Moelle',
            'type_prelev[sang]' => 'Sang',
            'type_prelev[liquide]' => 'Liquide',
            'type_prelev[autre]' => 'Autre',
            'mode_prelev' => 'Mode de prélèvement',
            'mode_prelev[biopsie]' => 'Biopsie',
            'mode_prelev[pieceOp]' => 'Pièce opératoire',
            'mode_prelev[ponction]' => 'Ponction',
            'mode_prelev[autre]' => 'Autre / Inconnu',
            'ETL' => 'Echantillon tumoral',
            'ETLLoc' => 'Localisation',
            'ETLTyp' => 'Type',
            'ETLDer' => 'Dérivés',
            'ENTLoc' => 'Localisation',
            'ENTTyp' => 'Type',
            'ENTDer' => 'Dérivés',
            'ENTRBA' => 'Ressources biologiques associées',
            'ETLLoc[tum_prim]' => 'Tumeur primitive',
            'ETLLoc[metastase]' => 'Métastase',
            'ETLTyp[tissu_cong]' => 'Tissu congelé',
            'ETLTyp[bloc_para]' => 'Bloc paraffine',
            'ETLTyp[cell_DMSO]' => 'Cellules DMSO',
            'ETLTyp[cell_CS]' => 'Cellules culot sec',
            'ETLDer[adn_der]' => 'ADN dérivé',
            'ETLDer[arn_der]' => 'ARN dérivé',
            'ENTA' => 'Echantillon non tumoral',
            'ENTLoc[tissu_sain_org_tumeur]' => 'Tissu sain - Organe de la tumeur',
            'ENTLoc[moelle_sang_rem]' => 'Moëlle ou sang de rémission complète',
            'ENTLoc[tissu_sain_autre_org]' => 'Tissu sain - autre organe',
            'ENTTyp[sang_tot_cong]' => 'Sang total congelé',
            'ENTTyp[tiss_sain]' => 'Tissu sain',
            'ENTTyp[cellNT]' => 'Cellules non tumorales',
            'ENTTyp[lymphocyte]' => 'Lymphocytes',
            'ENTTyp[salive]' => 'Salive',
            'ENTDer[adn_const]' => 'ADN constitutionnel',
            'ENTDer[arn_const]' => 'ARN constitutionnel',
            'ENTRBA[serum]' => 'Sérum',
            'ENTRBA[plasma]' => 'Plasma',
            'ENTRBA[autre]' => 'Autres liquides',
            'consent_rech' => 'Consentement recherche',
            'consent_RGC' => 'Consentement recherche génétique constitutionnelle',
            'mode_request' => "Mode de requête",
        );
    }

    public function yesNoValidate($attribute, $params) {
        if (in_array($this->$attribute, array('oui', 'non', 'yes', 'no'))) {
            return true;
        }return false;
    }

    public function yesNoUnknowValidate($attribute, $params) {
        if (in_array($this->$attribute, array('oui', 'non', 'yes', 'no', 'inconnu', 'unknown'))) {
            return true;
        }return false;
    }

}