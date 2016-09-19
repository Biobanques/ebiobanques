<?php

/**
 * NavbArBootstrap class file.
 * display the botstrap menu
 * require bootstrap >=3.3.7 installed
 *
 * @author Malservet Nicolas <nicolas.malservet@inserm.fr>
 * @copyright Copyright &copy; 2016 Biobanques
 * @license LGPL v3
 */
class NavBarBootstrap extends CWidget {

    // Navbar types.
    const TYPE_INVERSE = 'inverse';
    // Navbar fix locations.
    const FIXED_TOP = 'top';
    const FIXED_BOTTOM = 'bottom';

    /**
     * @var string the navbar type. Valid values are 'inverse'.
     * @since 1.0.0
     */
    public $type;

    /**
     * @var string the text for the brand.
     */
    public $brand;

    /**
     * @var string the URL for the brand link.
     */
    public $brandUrl;

    /**
     * @var array the HTML attributes for the brand link.
     */
    public $brandOptions = array();

    /**
     * @var mixed fix location of the navbar if applicable.
     * Valid values are 'top' and 'bottom'. Defaults to 'top'.
     * Setting the value to false will make the navbar static.
     * @since 0.9.8
     */
    public $fixed = self::FIXED_TOP;

    /**
     * @var boolean whether the nav span over the full width. Defaults to false.
     * @since 0.9.8
     */
    public $fluid = false;

    /**
     * @var boolean whether to enable collapsing on narrow screens. Default to false.
     */
    public $collapse = false;

    /**
     * @var array navigation items.
     * option visible : boolean
     * option position : left, right
     * @since 0.9.8
     */
    public $items = array();

    /**
     * @var array the HTML attributes for the widget container.
     */
    public $htmlOptions = array();

    /**
     * @var boolean whether the labels for menu items should be HTML-encoded. Defaults to true.
     */
    public $encodeLabel = true;
    
    /**
     *logo url to set
     * @var type 
     */
    public $logoUrl="";

    /**
     * Initializes the widget.
     */
    public function init() {

        
    }

    /**
     * Runs the widget.
     */
    public function run() {

        if (isset($this->brand)) {
            $brand = $this->brand;
        } else {
            $brand = Yii::app()->name;
        }
        echo "<nav class=\"navbar navbar-default\">
  <div class=\"container-fluid\">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class=\"navbar-header\">
      <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\" aria-expanded=\"false\">
        <span class=\"sr-only\">Toggle navigation</span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
        <span class=\"icon-bar\"></span>
      </button>
      <a class=\"navbar-brand\" href=\"index.php\">";
        if(isset($this->logoUrl)){
    echo "<img style=\"margin-top:-10px;height:60px;width:80px;\" alt=\"Logo\" src=\"".$this->logoUrl."\" class=\"pull-left\">";
        }
    echo"
    <span class=\"stylelogo\">" . $brand . "</span>
</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">
      ";
        echo $this->renderMenuRecursive($this->items);
        echo"    </div></div></nav>";
    }

    /**
     * Recursively renders the menu items.
     * @param array $items the menu items to be rendered recursively
     */
    protected function renderMenuRecursive($items) {
        $navbarLeft = "<ul class=\"nav navbar-nav\">";
        $navbarRight = "<ul class=\"nav navbar-nav navbar-right\">";
        foreach ($items as $item) {
            if (isset($item['visible']) && $item['visible'] == false) {
                //hide menu item
            } else {
                //check if the current link is active
                $class="";
                $route=$this->getController()->getRoute();
                if($this->isItemActive($item, $route)){
                    $class="active";
                }
                if (isset($item['position']) && $item['position'] == 'right') {
                    $navbarRight.= "<li class=".$class.">" . CHtml::link($item['label'], $item['url']) . "</li>";
                } else {
                    $navbarLeft.= "<li class=".$class.">" . CHtml::link($item['label'], $item['url']) . "</li>";
                }
            }
        }
        $navbarLeft.="</ul>";
        $navbarRight.="</ul>";
        return $navbarLeft.$navbarRight;
    }

    /**
     * Returns the navbar container CSS class.
     * @return string the class
     */
    protected function getContainerCssClass() {
        return $this->fluid ? 'container-fluid' : 'container';
    }
    
    /**
	 * Checks whether a menu item is active.
	 * This is done by checking if the currently requested URL is generated by the 'url' option
	 * of the menu item. Note that the GET parameters not specified in the 'url' option will be ignored.
	 * @param array $item the menu item to be checked
	 * @param string $route the route of the current request
	 * @return boolean whether the menu item is active
	 */
	protected function isItemActive($item,$route)
	{
		if(isset($item['url']) && is_array($item['url']) && trim($route,'/')==trim($item['url'][0],'/'))
		{
			return true;
		}
		return false;
	}

}
