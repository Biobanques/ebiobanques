<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**

 * Description of StringUtil

 *

 * @author  Rafael Goulart

 */
class StringUtils
{
    const ACCENT_STRINGS = 'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËẼÌÍÎÏĨÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëẽìíîïĩðñòóôõöøùúûüýÿ';
    const NO_ACCENT_STRINGS = 'SOZsozYYuAAAAAAACEEEEEIIIIIDNOOOOOOUUUUYsaaaaaaaceeeeeiiiiionoooooouuuuyy';

    /**

     * Returns a string with accent to REGEX expression to find any combinations

     * in accent insentive way

     *

     * @param string $text The text.

     * @return string The REGEX text.

     */
    static public function accentToRegex($text) {

        $from = str_split(utf8_decode(self::ACCENT_STRINGS));

        $to = str_split(strtolower(self::NO_ACCENT_STRINGS));

        $text = utf8_decode($text);

        $regex = array();

        foreach ($to as $key => $value) {

            if (isset($regex[$value])) {

                $regex[$value] .= $from[$key];
            } else {

                $regex[$value] = $value;
            }
        }

        foreach ($regex as $rg_key => $rg) {

            $text = preg_replace("/[$rg]/", "_{$rg_key}_", $text);
        }

        foreach ($regex as $rg_key => $rg) {

            $text = preg_replace("/_{$rg_key}_/", "[$rg]", $text);
        }

        return utf8_encode($text);
    }

}