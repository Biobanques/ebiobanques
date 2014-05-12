<?php

/**
 * CBarsChartWidget class file.
 *
 * @author Malservet Nicolas <n.malservet@biosoftwarefactory.com>
 * @link http://www.biosoftwarefactory.com/
 * @copyright Copyright &copy; 2012 BioSoftware Factory
 *
 * Presentation of chartline using DOJO lib
 * PREREQUIS : mettre dans header le lien de la lib dojo?
 */
class CBarsChartWidget extends CWidget {
    /**
     * theme utilisé par dojo, themes possibles: Tom, Claro,Dollar, Harmony, Midwest,Tufte
     * @var unknown_type
     */
    public $theme;
    /**
     * title afficher en dessous du graphe.
     * @var unknown_type
     */
    public $title;
    /**
     * data valeur a fixer dans le graph.
     * tableau associatif nom-valeur : array(array(string,integer),...)
     * @var unknown_type
     */
    public $data;
    public $width;
    public $heigth;
    /**
     * valeur de la rotation des label de l'axe x
     * @var unknown
     */
    public $xAxisRotation;

    public function init() {
        parent::init();
    }

    /**
     * TODO inclure la declaration du css js pour dojo ici plutot que dans
     */

    /**
     * NOTES :
     * dateInterval : day, week, month ( vue par jour, semaine mois du calendrier)
     */
    public function run() {
        if (!isset($this->data)) {
            echo "Aucune données à afficher";
        }
        else {
            if (!isset($this->theme)) {
                $this->theme = "Claro";
            }
            if (!isset($this->width)) {
                $this->width = 300;
            }
            if (!isset($this->heigth)) {
                $this->heigth = 200;
            }
            if (!isset($this->xAxisRotation)) {
                $this->xAxisRotation = 0;
            }

            $valeurs = "[";
            //axe des abcisses
            $xAxis = "[";
            $i = 0;
            foreach ($this->data as $serie) {
// 			if($i!=0){
// 				$valeurs.=',';
// 			}
                $valeurs.= $serie[1] . ',';
                $xAxis .= "{value: " . ++$i . ", text: \"" . $serie[0] . "\"}" . ', ';
            }
            $valeurs.=']';
            $xAxis.=']';
            echo "<script>

		require([
			 // Require the basic chart class
			\"dojox/charting/Chart\",

			// Require the theme of our choosing
			\"dojox/charting/themes/" . $this->theme . "\",

			// Charting plugins:

			// 	We want to plot Columns
			\"dojox/charting/plot2d/Bars\",

			// Require the highlighter
			\"dojox/charting/action2d/Highlight\",

			//	We want to use Markers
			\"dojox/charting/plot2d/Markers\",

			//	We'll use default x/y axes
			\"dojox/charting/axis2d/Default\",

			// Wait until the DOM is ready
			\"dojo/domReady!\"
		], function(Chart, theme, ColumnsPlot, Highlight) {

			// Define the data
			var chartData = " . $valeurs . ";

			// Create the chart within it's \"holding\" node
			var chart = new Chart(\"" . $this->id . "\");

			// Set the theme
			chart.setTheme(theme);

			// Add the only/default plot
			chart.addPlot(\"default\", {
				type: ColumnsPlot,
				markers: true,
				gap: 20
			});

			// Add axes
			chart.addAxis(\"x\");
			chart.addAxis(\"x\", {rotation: " . $this->xAxisRotation . "});
			chart.addAxis(\"y\", {vertical: true, labels: " . $xAxis . " });

			// Add the series of data
			chart.addSeries(\"Monthly Sales\",chartData);

			// Highlight!
			new Highlight(chart,\"default\");

			// Render the chart!
			chart.render();

		});</script>

<div id=\"" . $this->id . "\" style=\"width:" . $this->width . "px;height:" . $this->heigth . "px;\"></div>";
            if (isset($this->title)) {
                echo "<div style=\"text-align:center;font-weight:bold;font-style:italic;\">" . $this->title . "</div>";
            }
            else {
                echo "<div>Aucun titre</div>";
            }
        }
    }

}