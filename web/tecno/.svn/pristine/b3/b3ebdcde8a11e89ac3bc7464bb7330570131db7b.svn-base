<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Tecno\View {

    use Config\Config;

    class Json implements Views {

        /**
         * code -> http code
         * request_id -> para implementar requisicoes em lote
         * message -> Uma mensagem de retorno
         * error -> array de erros se hover
         * success -> status da solicitacao
         * data -> result da requisicao
         * @var
         */
        public  $code,
            $request_id,
            $message,
            $errors,
            $success,
            $data;

        /**
         * Json constructor
         */
        public function __construct()
        {
            $this->code = Config::vars('view.json.code');
            $this->request_id = Config::vars('view.json.request_id');
            $this->message = Config::vars('view.json.message');
            $this->errors = Config::vars('view.json.errors');
            $this->success = Config::vars('view.json.success');
            $this->data = Config::vars('view.json.data');
        }

        /**
         * http code
         * @param int $code
         */
        public function setCode(int $code)
        {
            $this->code = $code;
        }

        /**
         * request id quando houver
         * @param string $request_id
         * @return mixed|void
         */
        public function setRequestId(string $request_id)
        {
            $this->request_id = $request_id;
        }

        /**
         * Mensagem de saida
         * @param string $message
         * @return mixed|void
         */
        public function setMessage(string $message)
        {
            $this->message = $message;
        }

        /**
         * Array de errors se houver
         * @param array $errors
         * @return mixed|void
         */
        public function setErrors(array $errors)
        {
            $this->errors = $errors;
        }

        /**
         * Sucesso do Request
         * @param bool $success
         * @return mixed|void
         */
        public function setSuccess(bool $success)
        {
            $this->success = $success;
        }

        /**
         * Seta os dados de saida
         * @param array $data
         * @return mixed
         */
        public function setData(array $data)
        {
            $this->data = $data;
        }

        /**
         * Gera a saida json
         */
        public function output()
        {
            $output = array(
                'code' => $this->code,
                'request_id' => $this->request_id,
                'message' => $this->message,
                'errors' => $this->errors,
                'success' => $this->success,
                'data' => $this->data
            );

            header('Content-Type: application/json');
            header('Accept: application/json');
            http_response_code($this->code);
            echo json_encode($output);
            die;
        }

        /**
         * Gera a saida json
         */
        public function now()
        {
            $output = array(
                'code' => $this->code,
                'request_id' => $this->request_id,
                'message' => $this->message,
                'errors' => $this->errors,
                'success' => $this->success,
                'data' => $this->data
            );

            header('Content-Type: application/json');
            header('Accept: application/json');
            http_response_code($this->code);
            echo json_encode($output);
            die;
        }
    }
}