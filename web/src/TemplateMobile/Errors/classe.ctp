<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

use Config\Config;
use Tecno\Lib\Utils;

if (Config::vars('service_mode') != 'production') {

    if(Config::vars('php.shell'))
    {
        echo "Classe $error " . __('not found');
    }
    else
    {
        echo "Classe <b>$error</b> " . __('not found');
    }

} else {

    Utils::setMessage('error', '<strong style="font-size: 1.8rem;">Página não encontrada</strong><br>Ops! Não localizamos o endereço no servidor.');
    Utils::redirect(['url' => '/']);

}

?>