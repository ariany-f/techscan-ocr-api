<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */
 
spl_autoload_register(function ($class) {
    if (strpos($class, 'GettextDb\\') !== 0) {
        return;
    }

    $file = __DIR__.str_replace('\\', DIRECTORY_SEPARATOR, substr($class, strlen('GettextDb'))).'.php';

    if (is_file($file)) {
        require_once $file;
    }
});