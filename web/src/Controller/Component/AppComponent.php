<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Src\Controller\Component {

    use Config\Config;

    class AppComponent {

        private $bi;

        /**
         * ProviderComponent constructor
         * @throws \Exception
         */
        public function __construct()
        {
            /**
             * Load
             */
        }

        /**
         * Compara data
         * @param $date_1
         * @param $date_2
         * @return false|int
         */
        public function dateCompare($date_1, $date_2)
        {
            $date_1 = strtotime($date_1);
            $date_2 = strtotime($date_2);
            $unix = $date_1 - $date_2;
            return $unix;
        }

        /**
         * Verifica se foi setado o index no array e se não está vazio, então retorna seu valor, se estiver vazio retorna o valor default
         * @param $array
         * @param $index
         * @param string $default
         * @return mixed|string
         */
        public static function notNullAndBeSet($array, $index, $default = '')
        {
            if (count($array) > 0) {
                if (isset($array[$index]) && !empty($array[$index])) {
                    return $array[$index];
                }
            }
            return $default;
        }
    }
}