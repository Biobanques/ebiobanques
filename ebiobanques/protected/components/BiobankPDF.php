<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BiobankPDF.
 * Template of pdf to extends header and footer
 *
 * @author nicolas
 */
require_once(Yii::getPathOfAlias('application.vendors') . '/tcpdf/tcpdf.php');

class BiobankPDF extends TCPDF{
       public function Header() {
        // Logo
        //$image_file = K_PATH_IMAGES.'logo_example.jpg';
        $this->Image('images/logo_biobanques_mini.png', $x='', $y='', $w='', $h='15', 'PNG', '', '', $resize=false, 60, 'L');
        // Set font
        $this->SetFont('helvetica', '', 10);
        // Title
        $this->Cell(0, 15, 'Annuaire Biobanques '.date('Y'), 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
           $this->SetY(-15);
          // Set font
          $this->SetFont('helvetica', '', 10);
          // Page number
          $this->Cell(0, 10, $this->getAliasNumPage(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
         
    }
}
