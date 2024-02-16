<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

$block = [
    //'IP' => 'LABEL'
];

if (!empty($_SERVER['HTTP_CLIENT_IP']))
{
    $ip = $_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
{
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
    $ip = $_SERVER['REMOTE_ADDR'];
}

/**
 * Mensagem
 */
if(array_key_exists($ip, $block))
{
    echo "Sai demónio...";
    die;
}

use Config\Config;
use Tecno\Lib\Session;
use Tecno\Controller\Controller;
use Tecno\Lib\Utils;

/**
 * Set headers
 */
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
//header("Content-Security-Policy: default-src https: 'unsafe-inline' 'unsafe-eval'; img-src 'self' data:; font-src fonts.gstatic.com 'self' data:");
//header("X-Frame-Options: SAMEORIGIN");
//header("X-Content-Type-Options: nosniff");
//header("Referrer-Policy: same-origin");
header("Feature-Policy:  geolocation 'self'; camera 'self'; fullscreen '*'");
header("X-XSS-Protection: 1; mode=block");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, PUT, PATCH, GET, DELETE, OPTIONS, PATCH');
header('Access-Control-Allow-Headers: Origin, X-Api-Key, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');


/**
 * Set path e carrega app
 */
$GLOBALS['shell'] = [];
$time_start = microtime(true);
require dirname(__DIR__) . '/config/Bootstrap.php';

/**
 * Rota dinamica retencao de 3600 segundos
 * Arquivo de include com todas as rotas para comparar
 */
$route_dynamic = [];

/**
 * Comeca o jogo
 */
start:
$app = new Controller($route_dynamic);
$app->run();

/**
 * Tempo de execucao
 */
if(Config::vars('execution_time_show'))
{
    $time_end = microtime(true);
    $execution_time = $time_end - $time_start;
    echo "<div class=\"execution-time\">" . $execution_time . "</div>";
}