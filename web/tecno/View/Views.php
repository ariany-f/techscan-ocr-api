<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Tecno\View {

    interface Views {

        /**
         * Code do http response
         * @param int $code
         * @return mixed
         */
        public function setCode(int $code);

        /**
         * Id do request para request assincrono
         * Ainda nao foi implementado
         * @param string $request_id
         * @return mixed
         */
        public function setRequestId(string $request_id);

        /**
         * Define uma mensagem de saida
         * @param string $message
         * @return mixed
         */
        public function setMessage(string $message);

        /**
         * Array com erros se houver
         * @param array $errors
         * @return mixed
         */
        public function setErrors(array $errors);

        /**
         * Sucesso do request (true ou false)
         * @param bool $success
         * @return mixed
         */
        public function setSuccess(bool $success);

        /**
         * Seta os dados de saida
         * @param array $data
         * @return mixed
         */
        public function setData(array $data);

        /**
         * Manda para a saida
         * @return mixed
         */
        public function now();
    }
}