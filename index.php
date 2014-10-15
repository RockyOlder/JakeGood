<?php
/**
 * 入口
 *
 */

error_reporting(E_ERROR | E_WARNING | E_PARSE);
defined('YII_DEBUG') or define('YII_DEBUG', true);
define('YII_TRACE_LEVEL', 10);
$framework = dirname(__FILE__) . './framework/yiilite.php';
$config = dirname(__FILE__) . '/protected/config/main.php';
define('WWWPATH', str_replace(array('\\', '\\\\'), '/', dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);
require_once ($framework);
Yii::createWebApplication($config)->run();