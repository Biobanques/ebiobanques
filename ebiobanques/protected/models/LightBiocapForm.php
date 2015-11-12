<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LightBiocapForm extends CFormModel
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


    /*
     * PATIENT BLOCK
     */
    public $age;


    /*
     * PRELEVEMENT-ECHANTILLON BLOCK
     */


    /*
     * PRELEVEMENT SUB-BLOCK
     */
    public $evenement;
    public $type_prelev;
    public $mode_prelev;
    /*
     * ECHANTILLON TUMORAL SUB-BLOCK
     */

    public function rules() {
        $result = array(
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
            'mode_request' => 'Mode de requête',
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
            /*
             * PATIENT
             */
            'age' => 'Age au prélèvement',
            'age[0-1]' => '0-1 an',
            'age[2-4]' => '2-4 ans',
            'age[5-9]' => '5-9 ans',
            'age[10-14]' => '10-14 ans',
            'age[15+]' => '&ge;15 ans',
            /*
             * PRELEVEMENT-ECHANTILLON
             */
            'evenement' => 'Evènement',
            'evenement[diag_init]' => 'Diagnostic initial',
            'evenement[rechute]' => 'Rechute',
            'evenement[sec_cancer]' => 'Second cancer',
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