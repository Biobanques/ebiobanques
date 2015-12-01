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
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public static $LINE_HEIGHT = 7;

    public static function exporter($models) {
        require_once(Yii::getPathOfAlias('application.vendors') . '/tcpdf/tcpdf.php');
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Biobanques');
        $pdf->SetTitle('Annuaire Biobanques');

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
        $pdf->SetFont('times', '', 12);


        $pdf->setPrintFooter(true);
        $foot = '<div class="pdf_logo" style=" text-align:left; margin-top: 35px;">' . CHtml::image('/images/logobb.png', 'logo', array());
        '</div>'
                . '<div class="pdf_name" style="color:black; text-align:center;display: inline-block;" >Annuaire BIOBANQUES 2015</div>'
                . '<div class="pdf_pagination" style="color:black; text-align:right;" >' . $pdf->getAliasNumPage() . '</div>';

        //$pdf->Footer();
       // $pdf->Cell(0, 0,'right', 0, false, 'R', 0, '', 0, false, 'T', 'M');
       
        //affichage de attribut
        foreach ($models as $model) {
            $pdf->SetAutoPageBreak(TRUE, 10); //marge inferieure
            $pdf->SetFont('timesB', '', 11);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(0, 0, $model->name, 0, false, 'L', 0, '', 0, false, 'T', 'M');
            $pdf->Ln(4);
            $pdf->SetFont('times', '', 12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(0, 0,'Identifiant BRIF : '.$model->identifier , 0, false, 'L', 0, '', 0, false, 'T', 'M');
             //$pdf->SetFont('timesB', '', 11);
           


            $logo = isset($model->activeLogo) && $model->activeLogo != null && $model->activeLogo != "" ? Logo::model()->findByPk(new MongoId($model->activeLogo)) : null;
            if ($logo != null) {

                $pdf->Image($logo->toSimpleImage(), '',16,25 ,10 , '', '', '', true, 300, 'R');
            }
           
            $pdf->Ln(6);

            if (isset($model->website))
                $web = $model->website;
           

                    
            $html1 = '<div style = "background-color:gold;"> '
                    . '<div  style=" text-align:left;margin-top:0;">'
                    . '<h4  style= "color:red;">'
                    . $model->getAttributeLabel('Coordinateur:')
                    . '</h4>'
                    . '<b>' . $model->getShortContactInv() . '</b>'
                    . '<br>' . $model->getPhoneContact() . '<br>' . $model->getEmailContact()
                    . '</div>'
                  
                   .'<div style= "width:40%;position:relative;padding:0px;margin-left:2%;margin-right:auto;text-align:right;">'
                    . '<h4  style= " color:red;">'
                    . $model->getAttributeLabel('Adresse:')
                    . '</h4>'
                    . nl2br($model->getAddress()) . '<br>'
                    . '<b>' . $web . '</b>'
                    . '</div>'
                     . '</div>';
            
           
            $pdf->writeHTML($html1);
            //$pdf->writeHTMLCell(0, 0, '', '', $html1, 0, 0, false, true, '', false);      
            $pdf->SetFont('timesB', '', 11);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->Ln(7);
           
           // $pdf->Cell(0, 0,$model->getAttributeLabel('Coordinateur:'), 0, true, 'L', 0, '', 0, true, 'T', 'M');
            //$pdf->Cell(0, 0,$model->getAttributeLabel('Adresse :'), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            //$pdf->Ln(6);
            $pdf->SetFont('timesB', '', 11);
            $pdf->SetTextColor(0, 0, 0);
            //$pdf->Cell(0, 0,$model->getShortContactInv(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
            
           // $pdf->Ln(10);
            $pdf->SetFont('timesB', '', 11);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->writeHTML($model->getAttributeLabel('Présentation : '));
            $pdf->SetFont('times', '', 12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Ln(2);
            if (isset($model->presentation))
                $pdf->writeHTML(nl2br($model->presentation));
            //$pdf->writeHTMLCell(0,0,'','',nl2br($model->presentation),0,0,false,true,'R',true);
            $pdf->Ln(12);
            $pdf->SetFont('timesB', '', 11);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->writeHTML($model->getAttributeLabel('Thématiques : '));
            $pdf->SetFont('times', '', 12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Ln(2);
            if (isset($model->thematiques))
                $pdf->writeHTML(nl2br($model->thematiques));

            $pdf->Ln(1);
            $pdf->SetFont('timesB', '', 11);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->writeHTML($model->getAttributeLabel('Projets de recherche : '));
            $pdf->SetFont('times', '', 12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Ln(2);
            if (isset($model->projetRecherche))
                $pdf->writeHTML(nl2br($model->projetRecherche));

            $pdf->Ln(1);
            $pdf->SetFont('timesB', '', 11);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->writeHTML($model->getAttributeLabel('Publications : '));
            $pdf->SetFont('times', '', 12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Ln(2);
            if (isset($model->publications))
                $pdf->writeHTML(nl2br($model->publications));

            $pdf->Ln(1);
            $pdf->SetFont('timesB', '', 11);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->writeHTML($model->getAttributeLabel('Réseaux : '));
            $pdf->SetFont('times', '', 12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Ln(2);
            if (isset($model->reseaux))
                $pdf->writeHTML(nl2br($model->reseaux));

            $pdf->Ln(1);
            $pdf->SetFont('timesB', '', 11);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->writeHTML($model->getAttributeLabel('Qualité : '));
            $pdf->SetFont('times', '', 12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Ln(2);
            if (isset($model->qualite))
                $pdf->writeHTML(nl2br($model->qualite));


            $pdf->AddPage();
        }
        $pdf->LastPage();
        $pdf->Output("biobanks_list.pdf", "I");
    }

}
