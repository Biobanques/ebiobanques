<?php
/**
 * HelpDivWidget class file.<br>
 * widget d 'affichage de div clicquable
 *
 * @author Malservet Nicolas <nicolas.malservet@inserm.fr>
 * @copyright Copyright &copy; 2014 BioSoftware Factory
 */



class HelpDivWidget extends CWidget
{
	/**
	 * id unique de l adiv
	 * @var unknown_type
	 */
	public $id;
	
	/**
	 * text html a afficher
	 */
	public $text;

	/**
	 * affichage de la ligne de menu.
	 */
	public function run()
	{
		echo "<script>function toggleHelp(eltId)
                {
                var elt = document.getElementById(eltId);
                elt.style.display = (elt.style.display == \"block\") ? \"none\" : \"block\";
                }</script>";
		echo "<a   style=\"margin: 0px 0px 0px 5px;\" onclick=\"toggleHelp('".$this->id."')\">";
		echo CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
		echo "</a>";
		echo "</div>
		<!-- div aide advanced search -->
		<div id=\"".$this->id."\" style=\"display:none;margin-top: 5px;border:1px solid blueviolet;background: #eeeeee;padding:5px;\">
                    <img src=\"".Yii::app()->request->baseUrl.'/images/'."help.png\"/ style=\"margin-right: 5px;\">
		<p style=\"display:inline;\">
		".$this->text."
		</p>
		</div>";
	}
}
