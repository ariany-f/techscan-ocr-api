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


class WebSocketController extends App
{

    /**
     * WebSocketController constructor
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
            'subscribe'
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
        $this->output->setData(['WebSocket OCR API']);
        $params = $this->json;
        foreach($params as $passage)
        {
            
        }
        Utils::saveLogFile('webSocketEvent.log', ['params' => $params]);
        $this->output->now();
    }

    public function subscribe()
    {
        $result = [];
        $this->setRender('Ajax');
        $result[] = $this->Securos->subscribeToEvents('CONTAINER_NUMBER_RECOGNIZED');
        $result[] = $this->Securos->subscribeToEvents('CAR_LP_RECOGNIZED');
        $this->output->setCode(200);
        $this->output->setData($result);
        $this->output->now();
    }

    public function subscriptions()
    {
        $this->setRender('Ajax');
        $result = $this->Securos->getSubscriptions();
        $this->output->setCode(200);
        $this->output->setData($result);
        $this->output->now();
    }

    public function unsubscribe()
    {
        $this->setRender('Ajax');
        $params = $this->params;
        $result = $this->Securos->unsubscribeToEvents($params[0]);
        $this->output->setCode(200);
        $this->output->setData($result);
        $this->output->now();
    }
}
