<?php

namespace src\Helper {

    use Tecno\Lib\Session;
    
    class HtmlHelper {
        
        /**
         * Trocar logo do menu por parceiro
         */
        public static function logo()
        {
            $logo_path = 'https://' . $_SERVER['SERVER_NAME'] . '/img/logos/branco-semlegenda.png';
            return $logo_path;
        }
    }  
}