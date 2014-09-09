<?php

/**
 * CMenuBarlLineWidget class file.
 *
 * @author Malservet Nicolas <n.malservet@biosoftwarefactory.com>
 * @link http://www.biosoftwarefactory.com/
 * @copyright Copyright &copy; 2012 BioSoftware Factory
 *
 * affichage d une ligne de menu pour effectuer diverses actions
 */
class CMenuBarLineWidget extends CWidget
{
    /**
     * tableau de liens contenant des tableaux de chaque lien, avec label, action et image si possible
     * @var unknown_type
     */
    public $links = array();
    /**
     * nom du model utilisé, exemple, studio etc. pour exports
     * @var unknown_type
     */
    public $controllerName;
    /**
     * surcharge du nom de l action si besoin, en cas de doublon de nom d exports sur un controller.
     * @var unknown
     */
    public $actionPrint;
    /**
     * surcharge du nom de l action si besoin, en cas de doublon de nom d exports sur un controller.
     * @var unknown
     */
    public $actionExportXls;
    /**
     * surcharge du nom de l action si besoin, en cas de doublon de nom d exports sur un controller.
     * @var unknown
     */
    public $actionExportCsv;
    /**
     * surcharge du nom de l action si besoin, en cas de doublon de nom d exports sur un controller.
     * @var unknown
     */
    public $actionExportPdf;
    /**
     * boolean to activate search button.
     * @var unknown
     */
    public $searchable;

    /**
     * affichage de la ligne de menu.
     */
    public function run() {
        echo "<div style=\"background:#EFFDFF;margin-bottom:2px;padding-top:2px;padding-bottom:2px;padding-right: 10px;height:20px;\">";
        if (isset($this->links)) {
            foreach ($this->links as $link) {
                $label = "non def";
                $image = "";
                if (count($link) > 2) {
                    if (!empty($link[2])) {
                        $image = CHtml::image(Yii::app()->baseUrl . '/images/' . $link[2], $link[0]);
                    }
                }
                $style = "";
                $style = "style=\"padding-right: 10px;\"";
                echo "<span " . $style . ">" . CHtml::link($image . $link[0], array($link[1])) . "</span>";
            }
        }
        if (isset($this->controllerName)) {
            //recherche avancee
            if ($this->searchable) {
                $imagesearch = CHtml::image(Yii::app()->baseUrl . '/images/zoom.png', Yii::t('common', 'advancedsearch'));
                echo CHtml::link($imagesearch . Yii::t('common', 'advancedsearch'), '#', array('class' => 'search-button'));
            }
            echo "<div style=\"display:inline;float:right;\">";
            $print = 'print';
            if (isset($this->actionPrint)) {
                $print = $this->actionPrint;
            }
            $imageprinter = CHtml::image(Yii::app()->baseUrl . '/images/printer.png', 'Liste imprimable');
            echo "<span>" . CHtml::link($imageprinter, array($this->controllerName . '/' . $print)) . "</span>";
            $imageexportpdf = CHtml::image(Yii::app()->baseUrl . '/images/page_white_acrobat.png', 'Liste format pdf');
            $actionNamePdf = 'exportPdf';
            if (isset($this->actionExportPdf)) {
                $actionNamePdf = $this->actionExportPdf;
            }
            echo "<span style=\"padding-left: 10px;\">" . CHtml::link($imageexportpdf, array($this->controllerName . '/' . $actionNamePdf)) . "</span>";
            $imageexport = CHtml::image(Yii::app()->baseUrl . '/images/page_white_csv.png', 'Liste format csv');
            $actionNameCsv = 'exportCsv';
            if (isset($this->actionExportCsv)) {
                $actionNameCsv = $this->actionExportCsv;
            }
            echo "<span style=\"padding-left: 10px;\">" . CHtml::link($imageexport, array($this->controllerName . '/' . $actionNameCsv)) . "</span>";
            $imageexportxls = CHtml::image(Yii::app()->baseUrl . '/images/page_white_excel.png', 'Liste format excel');
            $actionNameXls = 'exportXls';
            if (isset($this->actionExportXls)) {
                $actionNameXls = $this->actionExportXls;
            }
            echo "<span style=\"padding-left: 10px;\">" . CHtml::link($imageexportxls, array($this->controllerName . '/' . $actionNameXls)) . "</span>";
            echo "</div>";
        }
        echo "</div>";
    }

}