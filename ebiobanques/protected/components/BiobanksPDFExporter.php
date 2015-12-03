<?php

//require_once('tcpdf_include.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BiobanksPDFExporter
 * render to display elements of Biobanks
 * @author nicolas
 */
class BiobanksPDFExporter {

    public static $LINE_HEIGHT = 7;

    public static function exporter($models) {
        $pdf = new BiobankPDF();
        $pdf->SetCreator('Biobanques');
        $pdf->SetAuthor('Biobanques');
        $pdf->SetTitle('Annuaire Biobanques');
        $pdf->SetDisplayMode($zoom = 'fullpage', $layout = 'TwoColumnRight', $mode = 'UseNone');

        //set header and footer
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set margins
        $pdf->SetMargins(15, 18, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 0);
        
        //pas de header et footer sur la premier page
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);  
        //affichage de la premier page
        $pdf = BiobanksPDFExporter::getFirstPage($pdf);
        //reaffectation du header et footer
        $pdf->SetPrintHeader(true);
        $pdf->SetPrintFooter(true);  
        //affichage de attribut
        foreach ($models as $model) {
            $pdf = BiobanksPDFExporter::getPage($pdf, $model);
        }
        // add a  Table Of Content
        // // add a new page for TOC
        $pdf->addTOCPage();
        $pdf->SetFont('times', 'B', 16);
        $pdf->MultiCell(0, 0, 'Table des matières', 0, 'C', 0, 1, '', '', true, 0);
        $pdf->Ln();
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->addTOC(2, 'courier', '.', 'Table des matières', 'B', array(128, 0, 0));
        $pdf->endTOCPage();
        // $pdf->LastPage();
        $pdf->Output("biobanks_list.pdf", "D");
    }

    public static function getFirstPage($pdf) {
        $pdf->SetFont('timesB', '', 20);
        $pdf->AddPage();
        $pdf->Ln(20);
        $pdf->SetLineStyle(array('width' => 0.35, 'color' => array(0, 0, 0)));
        $pdf->Line(20, 20, $pdf->getPageWidth() - 20, 20); //  ligne superieur
        // bordures double interieur rouge
        $pdf->SetLineStyle(array('width' => 0.35, 'color' => array(255, 0, 0)));
        $pdf->Line(30, 30, $pdf->getPageWidth() - 30, 30);
        $pdf->Line(32, 32, $pdf->getPageWidth() - 32, 32);
        $pdf->Cell(0, 9, 'INFRASTRUCTURE BIOBANQUES', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $pdf->Ln(50);
        $pdf->SetFont('timesB', '', 30);
        $pdf->SetTextColor(140, 140, 140);
        $pdf->Cell(0, 9, 'ANNUAIRE DES', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $pdf->Ln(10);
        $pdf->Cell(0, 9, 'BIOBANQUES', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $pdf->Ln(20);
        $pdf->SetFont('timesB', '', 14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 9, 'Edition 2015', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $pdf->Ln(90);
        $pdf->setImageScale(1.50);
        $pdf->Image('images/logobb.png', '', '', '', '', 'PNG', '', '', true, 150, 'C');
        $pdf->Line($pdf->getPageWidth() - 30, 30, $pdf->getPageWidth() - 30, $pdf->getPageHeight() - 30); //ligne lateral droite
        $pdf->Line($pdf->getPageWidth() - 32, 32, $pdf->getPageWidth() - 32, $pdf->getPageHeight() - 32);
        $pdf->Line(30, $pdf->getPageHeight() - 30, $pdf->getPageWidth() - 30, $pdf->getPageHeight() - 30); //ligne inferieur
        $pdf->Line(32, $pdf->getPageHeight() - 32, $pdf->getPageWidth() - 32, $pdf->getPageHeight() - 32); //ligne inferieur
        $pdf->Line(30, 30, 30, $pdf->getPageHeight() - 30); //ligne lateral gauche
        $pdf->Line(32, 32, 32, $pdf->getPageHeight() - 32);
        ///fin bordure souble interieur rouge
        $pdf->SetLineStyle(array('width' => 0.35, 'color' => array(0, 0, 0)));
        $pdf->Line($pdf->getPageWidth() - 20, 20, $pdf->getPageWidth() - 20, $pdf->getPageHeight() - 20); //ligne lateral droite
        $pdf->Line(20, $pdf->getPageHeight() - 20, $pdf->getPageWidth() - 20, $pdf->getPageHeight() - 20); //ligne inferieur
        $pdf->Line(20, 20, 20, $pdf->getPageHeight() - 20); //ligne lateral gauche
        return $pdf;
    }

    /**
     * each biobank have 2 pages
     * @param type $pdf
     * @param type $model
     * @return type
     */
    public static function getPage($pdf, $model) {
        $pdf->AddPage();
        $pdf->Bookmark($model->name, 0, 0, '', 'B', array(0, 64, 128));
        $pdf->SetAutoPageBreak(TRUE, 10); //marge inferieure
        $pdf->Ln(4);
        $pdf->SetFont('timesB', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 0, $model->name, 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $pdf->Ln(4);
        $pdf->SetFont('times', '', 12);
        $pdf->Cell(0, 0, 'Identifiant BRIF : ' . $model->identifier, 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $logo = isset($model->activeLogo) && $model->activeLogo != null && $model->activeLogo != "" ? Logo::model()->findByPk(new MongoId($model->activeLogo)) : null;
        if ($logo != null) {
            $pdf->Image($logo->toSimpleImage(), '', 16, 25, 10, '', '', '', true, 300, 'R');
        }
        $pdf->Ln(6);
        //affichage du cadre Coordinateur : addresse
        //color gold
        //espace vide d une ligne
        $pdf->Cell(0, 0, '', 0, 1, '', 0, '', 4);
        $pdf->SetFillColor(255, 215, 0);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
        $pdf->RoundedRect($x=10,$y= 35,$w= 190,$h=30,$r=3.50,$round_corner='1111',$style='DF');
        //color red to text
        $pdf->SetTextColor(205, 0, 0);
        $pdf->MultiCell(90, 5, 'Coordinateur:', 0, 'L', 1, 0, '', '', false);
        $pdf->MultiCell(90, 5, 'Adresse:', 0, 'L', 1, 1, '', '', false);
        //color black text
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->MultiCell(90, 2, $model->getShortContactInv() . "\n" . CommonFormatter::telNumberToFrench($model->getPhoneContact()) . "\n" . $model->getEmailContact(), 0, 'L', 1, 0, '', '');
        $website = isset($model->website) ? $model->website : '';
        $pdf->MultiCell(90, 2, ($model->getAddress()) . "\n" . $website, 0, 'L', 1, 1, '', '');
        $pdf->Ln(7);
        //add each paragraph with title
        $pdf = BiobanksPDFExporter::addParagraph($pdf, 'Présentation : ', isset($model->presentation) ? $model->presentation : '');
        $pdf = BiobanksPDFExporter::addParagraph($pdf, 'Thématiques : ', isset($model->thematiques) ? $model->thematiques : '');
        $pdf = BiobanksPDFExporter::addParagraph($pdf, 'Projets de recherche : ', isset($model->projetRecherche) ? $model->projetRecherche : '');
        $pdf = BiobanksPDFExporter::addParagraph($pdf, 'Publications : ', isset($model->publications) ? $model->publications : '');
        $pdf = BiobanksPDFExporter::addParagraph($pdf, 'Réseaux : ', isset($model->reseaux) ? $model->reseaux : '');
        $pdf = BiobanksPDFExporter::addParagraph($pdf, 'Qualité : ', isset($model->qualite) ? $model->qualite : '');
        return $pdf;
    }

    /**
     * add a paragraph to the pdf.
     * Always the same style, title in red
     * txt in black justified
     */
    public static function addParagraph($pdf, $title, $txt) {
        $pdf->SetFont('timesB', '', 11);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->MultiCell(180, 2, $title, 0, 'L', 0, 1, '', '', true);
        $pdf->SetFont('times', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);
        $pdf->MultiCell(180, 15, $txt, 0, 'L', 0, 1, '', '', true);
        return $pdf;
    }

}
