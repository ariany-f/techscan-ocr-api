<?php 

require_once('../vendor/econea/nusoap/src/nusoap.php');

$cliente = new nusoap_client("http://localhost/api/web/public/server.php?wsdl");

$parametros = array(
    "gate" => "",
    "direction" => ""
);

$resultado = $cliente->call('GetLastPassageDetail', $parametros);

echo utf8_encode($resultado);