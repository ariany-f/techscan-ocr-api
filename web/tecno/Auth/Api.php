<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Tecno\Auth {

    use Tecno\Lib\Utils;
    use Tecno\Lib\Session;

    class Api {

        /**
         * Dados
         * @var array
         */
        private $config;

        /**
         * Restful constructor
         * @param array $params
         * @throws \Exception
         */
        public function __construct(array $params)
        {
            $this->config = $params;
        }

        /**
         * Checa de action exige autenticao
         * @param array $params
         * @return bool
         */
        public function allow(array $params)
        {
            $this->config['allow'] = $params;
            $details = Utils::getDetailsExec();
            if(!in_array(strtolower($details['action']), array_map('strtolower', $this->config['allow'])))
            {
                self::checkAuth($details, $this->config);
            }
            return true;
        }

        /**
         * Valida autenticacao
         * @param array $params
         * @param array $config
         */
        public function checkAuth(array $params, array $config)
        {
            /**
             * Cliente nao tem sessao de autenticacao
             */
            if (!Session::read('Auth'))
            {
                Utils::redirect($config['redirect_login'], $_SERVER['REQUEST_URI']);
            }
        }
    }
}