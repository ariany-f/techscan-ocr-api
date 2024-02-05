<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Tecno\Lib {

    use Config\Config;

    class Cookie {

        /**
         * Retorna a Cookie toda
         * @return array|bool
         */
        public static function readAll()
        {
            return isset($_COOKIE) ? $_COOKIE : false;
        }

        /**
         * Set um Cookie
         * @param string $key
         * @param $value
         * @param int $seconds
         * @param string $path
         * @param string $domain
         * @param bool $secure
         * @param bool $httponly
         * @return bool
         */
        public static function write(string $key, $value, int $seconds = 432000, string $path = '/', string $domain = '', bool $secure = false, bool $httponly = false)
        {
            $config_samesite = Config::vars('php.session.samesite');
            $samesite = ($config_samesite) ? $config_samesite : 'strict';
            $validate = time() + $seconds;
            $value = serialize([
                'value' => $value,
                'params' => [
                    'expire' => $validate,
                    'path' => $path,
                    'domain' => $domain,
                    'secure' => $secure,
                    'httponly' => $httponly,
                    'samesite' => $samesite
                ]
            ]);
            setcookie($key, $value, [
                'expires' => $validate,
                'path' => $path,
                'domain' => $domain,
                'secure' => $secure,
                'httponly' => $httponly,
                'samesite' => $samesite
            ]);
            return true;
        }

        /**
         * Retorna valor da chave especificada
         * @param string $name
         * @param string $type
         * @return bool
         */
        public static function read(string $name, string $type = 'serialize')
        {
            switch ($type)
            {
                case 'serialize':
                    return isset($_COOKIE[$name]) ? unserialize($_COOKIE[$name])['value'] : false;
                break;

                case 'json':
                    return isset($_COOKIE[$name]) ? json_decode($_COOKIE[$name], true) : false;
                break;

                default:
                    return false;
            }
        }

        /**
         * Deleta a chave
         * @param $name
         * @return bool
         */
        public static function del($name)
        {
            if(isset($_COOKIE[$name]))
            {
                setcookie($name, "", time() - 3600, $_COOKIE[$name]['params']['path']);
                return true;
            }
            return false;
        }

        /**
         * Apaga todas os cookies
         * @return bool
         */
        public static function delAll()
        {
            if ($_COOKIE)
            {
                foreach ($_COOKIE as $key => $value)
                {
                    @setcookie($key, "", time() - 3600, @unserialize($_COOKIE[$key])['params']['path']);
                }
            }
            return true;
        }
    }
}