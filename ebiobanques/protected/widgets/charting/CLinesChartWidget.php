<?php

/**
 * CPieChartWidget class file.
 *
 * @author Malservet Nicolas <n.malservet@biosoftwarefactory.com>
 * @link http://www.biosoftwarefactory.com/
 * @copyright Copyright &copy; 2012 BioSoftware Factory
 *
 * Presentation of AGenda using DOJO lib
 * PREREQUIS : mettre dans header le lien de la lib dojo?
 */
class CLinesChartWidget extends CWidget
{
    /**
     * theme utilisé par dojo, themes possibles: Tom, Claro,
     * @var unknown_type
     */
    public $theme;
    /**
     * title afficher en dessous du graphe.
     * @var unknown_type
     */
    public $title;
    /**
     * data = donnees a affciher: tableau de nom/int sous la forme : array[array(string,int)]
     */
    public $data;
    /**
     * graph width
     * @var unknown
     */
    public $width;
    /**
     * graph height
     * @var unknown
     */
    public $height;
    /**
     * enable comparison with global rates
     * @var boolean
     */
    public $enableCompare;

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
        if (!isset($this->theme)) {
            $this->theme = "Claro";
            //echo "pas de theme";
        }
        if (!isset($this->width)) {
            $this->width = 300;
        }
        if (!isset($this->height)) {
            $this->height = 200;
        }
        if (!isset($this->enableCompare)) {
            $this->enableCompare = true;
        }
        $keys = array_keys($this->data);

        echo "

            <script>
require([
    \"dojox/charting/Chart\",
   \"dojox/charting/themes/" . $this->theme . "\",
    \"dojox/charting/plot2d/Lines\",
    \"dojox/charting/plot2d/Markers\",
\"dojox/charting/axis2d/Default\",

\"dojo/domReady!\"
], function(Chart, theme, Lines) {
    var mychart$this->id = new Chart(\"" . $this->id . "\");
    mychart$this->id.setTheme(theme);

    // Add the only/default plot
    mychart$this->id.addPlot(\"default\", {
        type: Lines,

    });
    mychart$this->id.addAxis(\"x\");
    mychart$this->id.addAxis(\"y\", {vertical: true,min : 0, max : 102});";

        echo "
    mychart$this->id.addSeries(\"$keys[0]\", [";
        foreach ($this->data[$keys[0]] as $value) {
            echo str_replace(',', '.', $value) . ",";
        }
        echo "]);";

        if ($this->enableCompare == true) {
            echo "
    mychart$this->id.addSeries(\"$keys[1]\", [";
            foreach ($this->data[$keys[1]] as $value) {
                echo str_replace(',', '.', $value) . ",";
            }
            echo "]);";
        }
        echo "

mychart$this->id.render();




});
</script>

<div id=\"" . $this->id . "\" style=\"width:" . $this->width . "px;height:" . $this->height . "px;text-align:center;display:inline-block\"></div>

		";
        if (isset($this->title)) {
            echo "<div style=\"text-align:center;font-weight:bold;font-style:italic;\">" . $this->title . "</div>";
        } else {
            echo "<div>Aucun titre</div>";
        }
    }

}