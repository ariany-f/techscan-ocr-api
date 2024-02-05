<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

use Tecno\Lib\Utils;

?>
<div class="debug" id="debug">
    <div class="header" id="debug_header">
        <div class="title">Debug</div>
        <div class="button">
            <div class="minimize" onclick="debugAction('min')"></div>
            <div class="restore" onclick="debugAction('max')"></div>
            <div class="close" onclick="debugAction('close')"></div>
        </div>
    </div>
    <div class="body" id="debug_body">
        <pre>
<?php
print_r([
    'route' => $app->route,
    'controller' => $app->controller,
    'action' => $app->action,
    'params' => $app->params,
    'pass' => $app->pass,
    'query_string' => $app->query_string,
    'get' => $app->get,
    'post' => $app->post,
    'json' => $app->json,
    'method' => $app->method,
    'render' => $app->render,
    'headers' => $app->headers,
    'browser' => Utils::getBrowser(),
    'session' => @$_SESSION,
    'server' => $_SERVER
]);
?>
        </pre>
    </div>
</div>