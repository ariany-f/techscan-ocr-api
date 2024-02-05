#!/usr/bin/php -q
<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

/**
 * Set path e carrega app
 */
$GLOBALS['shell'] = $argv;
$time_start = microtime(true);
require dirname(__DIR__) . '/config/Bootstrap.php';
use Tecno\Controller\Controller;
$app = new Controller();
$app->run();