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



class CPieChartWidget extends CWidget
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

	public function init()
	{
		parent::init();

	}


	/**
	 * TODO inclure la declaration du css js pour dojo ici plutot que dans
	 */

	/**
	 * NOTES :
	 * dateInterval : day, week, month ( vue par jour, semaine mois du calendrier)
	 */
	public function run()
	{
		if(!isset($this->theme)){
			$this->theme="Claro";
			//echo "pas de theme";
		}
	if(!isset($this->width))
			{
				$this->width = 300;
			}
			if(!isset($this->height))
			{
				$this->height = 200;
			}
		
		echo "<script>
require([
     // Require the basic chart class
    \"dojox/charting/Chart\",
 
    
    // Require the theme of our choosing
    \"dojox/charting/themes/".$this->theme."\",
 
    // Charting plugins:
 
    //  We want to plot a Pie chart
    \"dojox/charting/plot2d/Pie\", 
 
    // Retrieve the Legend, Tooltip, and MoveSlice classes
    \"dojox/charting/action2d/Tooltip\",
    \"dojox/charting/action2d/MoveSlice\",
 
    //  We want to use Markers
    \"dojox/charting/plot2d/Markers\",
 
    
    //legend
    \"dojox/charting/widget/Legend\",
 
    // Wait until the DOM is ready
    \"dojo/domReady!\"
], function(Chart, theme, Pie, Tooltip, MoveSlice) {
 
    
    // Create the chart within it's \"holding\" node
    var mychart = new Chart(\"".$this->id."\");
 
    // Set the theme
    mychart.setTheme(theme);
 
    // Add the only/default plot
    mychart.addPlot(\"default\", {
        type: Pie,
        markers: true,
        radius: 80
    });
    // Add the series of data
    // Define the data
    mychart.addSeries(\"Series A\", [
    		
    		";
		foreach($this->data as $serie){
			$nom = $serie[0];
			$valeur =$serie[1];
			echo  "{y: ".$valeur.", text: \"".$nom."\",   stroke: \"black\", tooltip: \"".$nom."=".$valeur."\"},";
		}
		echo"
    ]);
 
    // Create the tooltip
    var tip = new Tooltip(mychart,\"default\");
 
    // Create the slice mover
    var mag = new MoveSlice(mychart,\"default\");
 
    // Render the chart!
    mychart.render();
 
});
</script>
 
<div id=\"".$this->id."\" style=\"width:".$this->width."px;height:".$this->height."px;\"></div>
		<div id=\"".$this->id."-legend\"></div>
		";
		if(isset($this->title)){
			echo "<div style=\"text-align:center;font-weight:bold;font-style:italic;\">".$this->title."</div>";
		}else{
			echo "<div>Aucun titre</div>";
		}

	}
}
