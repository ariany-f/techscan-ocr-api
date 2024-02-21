<?php

/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace src\Controller;

use Src\App;
use Config\Config;
use Tecno\Lib\Cookie;
use Tecno\Lib\Utils;
use src\Helper\UtilsHelper;
use Src\Controller\Component\UtilsComponent;
use Src\Controller\Component\WegateComponent;
use Src\Controller\Component\SecurOSComponent;
use src\Model\Gate\GateModel;
use src\Model\User\UserModel;
use src\Model\Reason\ReasonModel;
use src\Model\Camera\CameraModel;
use src\Model\Passage\PassageModel;
use Tecno\Lib\Csrf;
use Tecno\Lib\Mailer;


class AccessController extends App
{

    /**
     * AccessController constructor
     * Carregar os componentes
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
            'index',
            'login'
        ]);

        /**
         * Load componentes
         * entre outros
         */
        $this->Wegate = new WegateComponent();
        $this->Securos = new SecurOSComponent();

        /**
         * Models
         */
        $this->userModel = new UserModel();
        $this->gateModel = new GateModel();
        $this->cameraModel = new CameraModel();
        $this->passageModel = new PassageModel();
        $this->reasonModel = new ReasonModel();
        
        /**
         * Method de request
         */
        $this->method = $_SERVER['REQUEST_METHOD'];

        $this->api = Config::vars('api');
    }

    /**
     * Index
     */
    public function index()
    {
        $this->setRender('Ajax');
        $this->output->setCode(200);
        $this->output->setData(['Bem vIndo a API OCR']);
        $this->output->now();
    }
    
    /**
     * Login
     */
    public function login()
    {
        $this->setRender('Ajax');

        if($this->method == 'POST')
        {
            $params = $this->json;

            $params['email'] = $this->checkFieldRequest($params, 'email', true, "mail");
            $params['gate_id'] = $this->checkFieldRequest($params, 'gate_id', true, "integer");
            $pass = $this->checkFieldRequest($params, 'password', false);
            $params['password'] = sha1(Config::vars('salt') . $pass);
            Utils::saveLogFile('login.log', [
                'params' => $params
            ]);
            $return = $this->userModel->login($params);

            if($return) {

                $this->output->setCode(200);
                $this->output->setMessage( 'Login' );
                $this->output->setSuccess( true );
                $this->output->setData( $return );
            }
            else
            {
                $this->output->setCode(200);
                $this->output->setMessage( ' Dados incorretos ou usuário desativado ' );
                $this->output->setSuccess( false );
                $this->output->setData( [] );
            }
        }

        $this->output->now();
    }
    
    /**
     * Logout
     */
    public function logout()
    {
        
        $this->setRender('Ajax');

        if($this->method == 'POST')
        {
            $params = $this->json;

            $params['token'] = $this->checkFieldRequest($params, 'token', true);

            $result = $this->userModel->logout($params);

            if($result) {

                $return = [
                    'result'=> $result
                ];

                $this->output->setCode(200);
                $this->output->setMessage( 'Usuário deslogado com sucesso' );
                $this->output->setSuccess( true );
                $this->output->setData( $return );
            }
            else
            {
                $this->output->setCode(200);
                $this->output->setMessage( 'Erro ao deslogar usuário' );
                $this->output->setSuccess( false );
                $this->output->setData( [] );
            }
        }
        
        $this->output->now();
    }
}
