<?php

/**
 * @author Nanhe Kumar <nanhe.kumar@gmail.com>
 * @version 1.0.0
 * @package PHPMongoDB
 */

class Config {

    public static $theme = 'default';
    public static $autocomplete=false;

    public static $language = array(
        'english' => 'English',
        'german' => 'German',
    );
    public static $server=array(
        'name' => "Localhost",
        'server'=>false,
        'host' => "127.0.0.1",
        'port'=>"27017",
        'timeout'=>0,
        'user' => '',
        'password' => '',
        'db' => ''
    );
    public static $driverOptions=array(
    );

    public static $authentication = array(
        'authentication'=>false,
        'user' => 'admin',
        'password' => 'admin'
    );
    public static $authorization = array(
        'readonly'=>false,
    );
}

?>
