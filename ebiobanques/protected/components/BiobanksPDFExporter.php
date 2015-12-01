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

    public function Header() {
        // Logo
        //$image_file = K_PATH_IMAGES.'logo_example.jpg';
        $pdf->Image('images/logobb.png', '', '', '', '', 'PNG', '', '', true, 60, 'C');
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        /*   $this->SetY(-15);
          // Set font
          $this->SetFont('helvetica', 'I', 8);
          // Page number
          $this->Cell(0, 10, 'Page '.$this->getAliasNumPage(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
         * */
    }

    public static $LINE_HEIGHT = 7;

    public static function exporter($models) {
        require_once(Yii::getPathOfAlias('application.vendors') . '/tcpdf/tcpdf.php');
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Biobanques');
        $pdf->SetTitle('Annuaire Biobanques');
        $pdf->SetDisplayMode($zoom = 'fullpage', $layout = 'TwoColumnRight', $mode = 'UseNone');

        $pdf = BiobanksPDFExporter::getFirstPage($pdf);

        $pdf->SetFont('times', '', 12);


        /* $pdf->setPrintFooter(true);
          $foot = '<div class="pdf_logo" style=" text-align:left; margin-top: 35px;">' . CHtml::image('/images/logobb.png', 'logo', array());
          '</div>'
          . '<div class="pdf_name" style="color:black; text-align:center;display: inline-block;" >Annuaire BIOBANQUES 2015</div>'
          . '<div class="pdf_pagination" style="color:black; text-align:right;" >' . $pdf->getAliasNumPage() . '</div>';

          $pdf->Footer();
         * */

        //$pdf->Cell(0, 0,'right', 0, false, 'R', 0, '', 0, false, 'T', 'M');
        //affichage de attribut
        foreach ($models as $model) {
            $pdf = BiobanksPDFExporter::getPage($pdf, $model);
        }
        // $pdf->LastPage();
        $pdf->Output("biobanks_list.pdf", "D");
    }

    public static function getFirstPage($pdf) {
        $pdf->SetHeaderData('', 0, PDF_HEADER_TITLE, '');
        $pdf->setHeaderFont(Array('helvetica', '', 8));
        $pdf->setFooterFont(Array('helvetica', '', 6));
        $pdf->SetMargins(15, 18, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
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
        $pdf->AddPage();
        $pdf->AddPage();
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
        $pdf->SetAutoPageBreak(TRUE, 10); //marge inferieure
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
        $pdf->SetFillColor(255, 215, 0);
        $pdf->SetFont('helvetica', 'B', 12);

        $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
        $pdf->RoundedRect(10, 28, 190, 25, 3.50, '1111', 'DF');
        //color red to text
        $pdf->SetTextColor(205, 0, 0);
        $pdf->MultiCell(90, 5, 'Coordinateur:', 0, 'L', 1, 0, '', '', false);
        $pdf->MultiCell(90, 5, 'Adresse:', 0, 'L', 1, 1, '', '', false);
        //color black text
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->MultiCell(90, 2, $model->getShortContactInv() . "\n" . $model->getPhoneContact() . "\n" . $model->getEmailContact(), 0, 'L', 1, 0, '', '');
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
        //$pdf->Cell(0,0,'Présentation : ');
        $pdf->MultiCell(180, 2, $title, 0, 'L', 0, 1, '', '', true);

        $pdf->SetFont('times', '', 12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);
        $pdf->MultiCell(180, 15, $txt, 0, 'J', 0, 1, '', '', true);
        return $pdf;
    }

}
