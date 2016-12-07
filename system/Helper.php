<?php
/**
 * @package PHPmongoDB
 * @version 2.0.0
 */

namespace PHPMongoDB\PHPMongoDB;

defined('PMDDA') or die('Restricted access');

class Helper {

    public static function getLoginDatabase() {
        $session = Application::getInstance('Session');
        $model = new Model();
        return array(
            'databases' => array(
                array(
                    'name' => isset($session->options['db']) ? $session->options['db'] : '',
                    'noOfCollecton' => isset($session->options['db'])?count($model->listCollections($session->options['db'], array())):NULL,
                ),
            ),
        );
    }

    // Puts debug data into a nice PRE display box
    public static function preBlock($text) {
        $toDisplay = self::preBlockText($text);
        return '<pre style="overflow: auto; white-space: pre-wrap; background: #eee; padding: 5px;">' .
                $toDisplay .
            '</pre>';
    }

    public static function preBlockText($text) {
        $aJsonDecoded = @json_decode($text);
        if ($aJsonDecoded) {
            if (isset($aJsonDecoded->p)) {
                $toDisplay = self::indentJSON(json_encode($aJsonDecoded->p));
            } else {
                $toDisplay = self::indentJSON(stripslashes($text));
            }
        } else {
            $toDisplay = htmlentities($text);
        }
        return $toDisplay;
    }

    /**
     * Indents a flat JSON string to make it more human-readable.
     *
     * @param string $json The original JSON string to process.
     *
     * @return string Indented version of the original JSON string.
     */
    public static function indentJSON($json) {

        $result      = '';
        $pos         = 0;
        $strLen      = strlen($json);
        $indentStr   = '  ';
        $newLine     = "\n";
        $prevChar    = '';
        $outOfQuotes = true;

        for ($i=0; $i<=$strLen; $i++) {

            // Grab the next character in the string.
            $char = substr($json, $i, 1);

            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;

            // If this character is the end of an element,
            // output a new line and indent the next line.
            } else if(($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos --;
                for ($j=0; $j<$pos; $j++) {
                    $result .= $indentStr;
                }
            }

            // Add the character to the result string.
            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line.
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos ++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            $prevChar = $char;
        }

        return $result;
    }



}
