<?php
/**
 * @package PHPmongoDB
 * @version 2.0.0
 */

namespace PHPMongoDB\PHPMongoDB;

defined('PMDDA') or die('Restricted access');

class Engine {

    protected $system;

    public function __construct() {
        $this->environmentDetection();
        $this->load();
    }

    public function start() {

        $this->system = new System();
        $this->system->start();
    }

    public function stop() {
        if ($this->system->isTheme()) {
            $this->system->getTheme();
        } else {
            $this->system->getView();
        }
    }

    public function environmentDetection() {

        if (!version_compare(PHP_VERSION, "5.0")) {
            exit("To make things right, you must install PHP5");
        }

        if (!file_exists(realpath(__DIR__ . '/../vendor/autoload.php'))) {
            exit("To make things right, you must run 'composer install'. Please refer to the read me.");
        }

        if (phpversion("mongodb") === false) {
            exit("To make things right, you must install the MongDB drivers. http://php.net/manual/en/set.mongodb.php");
        }

        require(realpath(__DIR__ . '/../vendor/autoload.php'));

        if (!class_exists('\MongoDB\Client')) {
            exit("To make things right, you must run 'composer install'. Please refer to the read me 2.</a>");
        }
    }

    public function load() {
        self::loadConfig();
        spl_autoload_register('self::autoloadSystem');
        spl_autoload_register('self::autoloadController');
        spl_autoload_register('self::autoloadModel');
    }

    public static function loadConfig() {
        $fileWithPath = getcwd() . '/config.php';
        self::includes($fileWithPath);
    }

    public static function autoloadSystem($class) {
        $parts = explode('\\', $class);
        $filename = end($parts);
        $fileWithPath = dirname(__FILE__) . '/' . $filename . '.php';
        self::includes($fileWithPath);
    }

    public static function autoloadController($class) {
        $parts = explode('\\', $class);
        $filename = end($parts);
        $fileWithPath = getcwd() . '/application/controllers/' . str_replace('Controller', '', $filename) . '.php';
        self::includes($fileWithPath);
    }

    public static function autoloadModel($class) {
        $parts = explode('\\', $class);
        $filename = end($parts);
        $fileWithPath = getcwd() . '/application/models/' . $filename . '.php';
        self::includes($fileWithPath);
    }

    public static function includes($fileWithPath) {
        if (is_readable($fileWithPath)) {
            require_once ($fileWithPath);
        }
    }

}

?>