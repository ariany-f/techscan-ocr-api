<?php
namespace src\Controller {

    use Src\App;
    use Tecno\Database\Db;
    use Tecno\Lib\Request;
    use Tecno\Lib\Utils;
    use Tecno\Lib\Session;

    class JsHelpController extends App
    {
        /**
         * Dados para envio de email
         * @var
         */
        private $db;

        /**
         * JsHelpController constructor
         * @throws \Exception
         */
        public function __construct()
        {
            /**
             * Obrigatorio
             */
            parent::__construct();

            /**
             * Auth
             * Presente se a controller necessita de autenticao
             * Array do allow actions que nao exigem autenticao
             */
            $this->auth->allow([
				'modules'
            ]);
        }

        /**
         * Ajax para retorno de js no final pos load da pagina
         * @throws \Exception
         */
        public function modules()
        {
            $this->setRender('Ajax');
            $code = 200;
            $result = [];

            if(!Utils::isAjax())
            {
                $code = 400;
                goto output;
            }

            output:
            $this->output->setCode($code);
            $this->output->setData($result);
            $this->output->now();
        }
    }
}