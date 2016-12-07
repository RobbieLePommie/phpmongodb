<?php

/**
 * @package PHPmongoDB
 * @version 2.0.0
 */

namespace PHPMongoDB\PHPMongoDB;

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors',1);
define('PMDDA',TRUE);
require(dirname(__FILE__).'/system/Engine.php');
$engine=new Engine();
$engine->start();
$engine->stop();
?>
