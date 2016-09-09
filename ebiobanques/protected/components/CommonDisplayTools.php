<?php

/**
 * class to centralize common tools useful to display data.
 * Function needs to be useful only to views.
 * @since 1.8.1
 * @author nicolas malservet
 */
class CommonDisplayTools {

    /**
     * return the array of options to display th ehelpbox into a field.
     * @param attributeName the name of the attribute in th eform
     * @param helpLabel the label of the explanation available in the help.php file of each language
     * @param controller the currnet controller
     * @since 1.8.1
     */
    public static function getHelpBox($attributeName,$helpLabel,$controller) {
        
            return ['class' => 'helpedInput', 'data-toggle' => "hover", "popover-title" => "Popover Header", 'data-content' =>
            $controller->renderPartial('/site/_help_message', array(
                    'title' => Yii::t('common', $attributeName),
                    'content' => Yii::t('help', $helpLabel)
                        ), true
                )
            ];
        
    }

}

