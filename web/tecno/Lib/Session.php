<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Tecno\Lib {

    use Config\Config;

    class Session {

        /**
         * Retorna a session toda
         * @return array|bool
         */
        public static function readAll()
        {
            return isset($_SESSION) ? $_SESSION : false;
        }

        /**
         * * Set session value
         * @param $key
         * @param $value
         * @return bool
         */
        public static function write($key, $value)
        {
            $_SESSION[$key] = $value;
            return true;
        }

        /**
         * Retorna valor da chave especificada
         * @param $name
         * @return bool
         */
        public static function read($name)
        {
            return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
        }

        /**
         * Verifica se chave existe na sessão
         * @param $name
         * @return bool
         */
        public static function check($name)
        {
            return isset($_SESSION[$name]) ? true : false;
        }

        /**
         * Deleta a chave
         * @param $name
         * @return bool
         */
        public static function del($name)
        {
            if(isset($_SESSION[$name]))
            {
                unset($_SESSION[$name]);
                return true;
            }
            return false;
        }

        /**
         * Apaga toda a sessao
         * @return bool
         */
        public static function delAll()
        {
            $_SESSION = [];
            if (ini_get("session.use_cookies"))
            {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 3600,
                    Config::vars('php.session.path')
                );
            }
            session_destroy();
            return true;
        }
    }
}