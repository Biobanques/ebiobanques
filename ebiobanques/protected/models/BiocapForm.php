<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BiocapForm extends CFormModel
{
    /*
     * DIAGNOSTIC BLOCK
     */
    public $iccc_group;
    public $iccc_group1;
    public $iccc_group2;
    public $iccc_group3;
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

    /*
     * ECHANTILLON NON TUMORAL SUBBLOCK
     */
    public $ENTA;
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
            'topoOrganeField' => 'Topo / organe',
            'morphoHistoField' => 'Morpho / histo',
            'metastasique' => 'Métastasique',
            'cr_anapath_dispo' => 'CR anapath disponible',
            'donCliInBase' => 'Données cliniques en base',
            /*
             * PATIENT
             */
            'age' => 'Age',
            'age[0-1]' => '0-1 an',
            'age[2-4]' => '2-4 ans',
            'age[5-9]' => '5-9 ans',
            'age[10-14]' => '10-14 ans',
            'age[15+]' => '&ge;15 ans',
            'sexe' => 'Sexe',
            'stat_vital' => 'Statut vital',
            'ano_chrom_constit' => 'Anomalie chromosomique constituante',
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
            'type_prelev[moelle]' => 'Moëlle',
            'type_prelev[sang]' => 'Sang',
            'type_prelev[autre]' => 'Autre',
            'mode_prelev' => 'Mode de prélèvement',
            'mode_prelev[biopsie]' => 'Biopsie',
            'mode_prelev[pieceOp]' => 'Pièce opératoire',
            'mode_prelev[ponction]' => 'Ponction',
            'mode_prelev[autre]' => 'Autre / Inconnu',
            'ETL[tum_prim]' => 'Tumeur primitive',
            'ETL[metastase]' => 'Métastase',
            'ETL[tissu_cong]' => 'Tissu congelé',
            'ETL[bloc_para]' => 'Bloc paraffine',
            'ETL[cell_DMSO]' => 'Cellules DMSO',
            'ETL[cell_CS]' => 'Cellules culot sec',
            'ETL[adn_der]' => 'ADN dérivé',
            'ETL[arn_der]' => 'ARN dérivé',
            'ENTA[tissu_sain_org_tumeur]' => 'Tissu sain - Organe de la tumeur',
            'ENTA[moelle_sang_rem]' => 'Moëlle ou sang de rémission complète',
            'ENTA[tissu_sain_autre_org]' => 'Tissu sain - autre organe',
            'ENTA[sang_tot_cong]' => 'Sang total congelé',
            'ENTA[lymphocyte]' => 'Lymphocytes',
            'ENTA[salive]' => 'Salive',
            'ENTA[adn_const]' => 'ADN constitutionnel',
            'ENTA[arn_const]' => 'ARN constitutionnel',
            'ENTA[serum]' => 'Sérum',
            'ENTA[plasma]' => 'Plasma',
            'consent_rech' => 'Consentement recherche',
            'consent_RGC' => 'Consentement recherche génétique constitutionnelle'
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