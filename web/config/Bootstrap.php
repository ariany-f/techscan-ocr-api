<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Config {

    use Tecno\Lib\Utils;

    /**
     * Configuracoes iniciais
     */
    define('__DIR_ROOT__', dirname( __DIR__ ));
    define('__DIR_INDEX__', str_replace("index.php", "", $_SERVER['PHP_SELF']));

    /**
     * Load configuracoes
     */
    require_once 'Config.php';
    $php = Config::vars('php');
    @ini_set('error_reporting', $php['error_reporting']);
    @ini_set('display_errors', (Config::vars('debug')) ? $php['display_errors'] : 0);
    @ini_set('set_time_limit', $php['set_time_limit']);
    @ini_set('max_execution_time', $php['max_execution_time']);
    @ini_set('auto_detect_line_endings', $php['auto_detect_line_endings']);
    setlocale(LC_ALL, $php['locale'][0], $php['locale'][1], $php['locale'][2], $php['locale'][3]);
    setlocale(LC_NUMERIC,'en-US'); // Windows
    setlocale(LC_NUMERIC, 'en_US.utf8'); // Linux
    @ini_set( 'session.use_cookies', true);
    @ini_set( 'session.use_only_cookies', true);
    ini_set("log_errors", true);
    ini_set('error_log', $php['error_file']);

    /**
     * Registro session id para recuperar a session
     */
    if(isset($_COOKIE[$php['session']['name']]))
    {
        session_id($_COOKIE[$php['session']['name']]);
    }
    else
    {
        session_id($php['session']['id']);
    }

    /**
     * Cria a session
     * se nao for shell
     */
    if(!$php['shell'] and $php['session']['active'])
    {
        $samisite = isset($php['session']['samesite']) ? $php['session']['samesite'] : 'strict';
        session_save_path($php['session']['save_path']);
        session_name($php['session']['name']);
        session_set_cookie_params(
            $php['session']['lifetime'],
            $php['session']['path'] . ";samesite=" . $samisite,
            $php['session']['domain'],
            $php['session']['secure'],
            $php['session']['httponly']
        );
        session_start();
    }

    /**
     * Para carregar tudo
     * @param $classe
     */
    if(file_exists(__DIR_ROOT__ . "/vendor/autoload.php"))
    {
        require_once __DIR_ROOT__ . "/vendor/autoload.php";
    }

    /**
     * Registra o autoload na pilha
     */
    spl_autoload_register(function ($class) {
        $class = strtolower($class[0]) . substr($class, 1);
        require_once(str_replace('\\', '/', __DIR_ROOT__ . '/' . $class . '.php'));
    });
}