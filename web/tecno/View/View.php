<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Tecno\View {

    class View implements Views {

        protected $view;
        protected $message;
        protected $success;
        protected $errors;

        /**
         * View constructor
         * @param Views $object
         */
        public function __construct(Views $object)
        {
            $this->view = $object;
        }

        /**
         * http code
         * @param int $code
         */
        public function setCode(int $code)
        {
            $this->view->code = $code;
        }

        /**
         * request id quando houver
         * @param string $request_id
         * @return mixed|void
         */
        public function setRequestId(string $request_id)
        {
            $this->view->request_id = $request_id;
        }

        /**
         * Mensagem de saida
         * @param string $message
         * @return mixed|void
         */
        public function setMessage(string $message)
        {
            $this->view->message = $message;
        }

        /**
         * Array de errors se houver
         * @param array $errors
         * @return mixed|void
         */
        public function setErrors(array $errors)
        {
            $this->view->errors = $errors;
        }

        /**
         * Sucesso do Request
         * @param bool $success
         * @return mixed|void
         */
        public function setSuccess(bool $success)
        {
            $this->view->success = $success;
        }

        /**
         * Seta os dados de saida
         * @param array $data
         * @return mixed|void
         */
        public function setData(array $data)
        {
            $this->view->data = $data;
        }

        /**
         * Manda para a saida
         * @return mixed|void
         */
        public function now()
        {
            $this->view->now();
        }
    }
}