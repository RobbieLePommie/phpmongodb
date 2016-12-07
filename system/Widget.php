<?php
/**
 * @package PHPmongoDB
 * @version 2.0.0
 */

namespace PHPMongoDB\PHPMongoDB;

defined('PMDDA') or die('Restricted access');

class Widget {

    protected static $controller = 'WidgetController';
    protected static $prefix = 'get';

    public static function setController($controller='WidgetController') {
        self::$controller=$controller;
    }
    public static function setPrefix($prefix='get'){
        self::$prefix;
    }

    public static function get() {
        if (func_num_args() < 1)
            return false;
        $nameSpacedClass = 'PHPMongoDB\\PHPMongoDB\\' . self::$controller;
        return call_user_func(array(new $nameSpacedClass, self::$prefix . func_get_arg(0)));
    }

}