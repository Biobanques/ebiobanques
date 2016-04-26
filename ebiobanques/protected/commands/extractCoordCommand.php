<?php

/**
 * Command to mass extract biobanks adress and get lat/long from google API
 * To use it : $path/protected/yiic extractcoord
 */
class extractCoordCommand extends CConsoleCommand {

    public function run($args) {
        echo 'Extract coordinates from biobank address :' . "\n";
        $biobanks = Biobank::model()->findAll();
        foreach ($biobanks as $biobank) {
            CommonTools::getLatLong($biobank);
        }
    }

}
