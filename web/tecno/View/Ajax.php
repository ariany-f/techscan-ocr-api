<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Tecno\View {

    use Config\Config;

    class Ajax implements Views {

        /**
         * code -> http code
         * data -> result da requisicao
         * @var
         */
        public  $code = null,
            $data = null;

        /**
         * Ajax constructor
         */
        public function __construct()
        {
            $this->code = Config::vars('view.ajax.code');
            $this->data = Config::vars('view.ajax.data');
        }

        /**
         * @param int $code
         */
        public function setCode(int $code)
        {
            $this->code = $code;
        }

        /**
         * Id do request para request assincrono
         * Ainda nao foi implementado
         * @param string $request_id
         * @return mixed
         */
        public function setRequestId(string $request_id){}

        /**
         * Define uma mensagem de saida
         * @param string $message
         * @return mixed
         */
        public function setMessage(string $message){}

        /**
         * Array com erros se houver
         * @param array $errors
         * @return mixed
         */
        public function setErrors(array $errors){}

        /**
         * Sucesso do request (true ou false)
         * @param bool $success
         * @return mixed
         */
        public function setSuccess(bool $success){}

        /**
         * Seta os dados de saida
         * @param array $data
         * @return mixed|void
         */
        public function setData(array $data)
        {
            $this->data = $data;
        }

        /**
         * Gera a saida Ajax
         */
        public function now()
        {
            header('X-Requested-With: XMLHttpRequest');
            header('Content-Type: application/json');
            header('Accept: application/json');
            http_response_code($this->code);
            echo json_encode($this->data);
            die;
        }
    }
}