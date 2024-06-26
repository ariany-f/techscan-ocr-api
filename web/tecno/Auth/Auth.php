<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Tecno\Auth {

    use Exception;
    use Tecno\Lib\Utils;

    class Auth implements Auths {

        /**
         * @vars
         */
        public $config, $method;

        /**
         * Auth constructor.
         * @param array $auth_config
         * @throws Exception
         */
        public function __construct(array $auth_config)
        {
            $this->config = $auth_config;

            switch ($this->config['method'])
            {
                case 'Api':
                    try {
                        $auth = new Api($this->config);
                        $this->method = $auth;
                    }
                    catch (Exception $e)
                    {
                        echo __('Authenticate type error') . ' (' . $this->config['method'] . ')';
                        die;
                    }
                break;

                case 'Restful':
                    try {
                        $auth = new Restful($this->config);
                        $this->method = $auth;
                    }
                    catch (Exception $e)
                    {
                        echo __('Authenticate type error') . ' (' . $this->config['method'] . ')';
                        die;
                    }
                break;

                case 'Database':
                    try {
                        $auth = new Database($this->config);
                        $this->method = $auth;
                    }
                    catch (Exception $e)
                    {
                        echo __('Authenticate type error') . ' (' . $this->config['method'] . ')';
                        die;
                    }
                    break;

                default:
                    echo __('Authenticate type error') . ' (' . $this->config['method'] . ')';
                    die;
            }
        }

        /**
         * Recebe array com actions que nao necessitam de login
         * @param array $actions
         * @return bool|mixed
         * @throws Exception
         */
        public function allow(array $actions = [])
        {
            return $this->method->allow($actions);
        }

        /**
         * Checa autenticacao
         * @return bool|mixed
         * @throws Exception
         */
        public function check()
        {
            return $this->method->authCheck(Utils::getDetailsExec(), $this->config);
        }

        /**
         * Logged Id somente para auth Restful
         * @return int
         * @throws Exception
         */
        public function LoggedId(): int
        {
            return $this->method->LoggedId();
        }
    }
}