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
use src\Model\Passage\PassageImageModel;
use src\Model\Securos\WebsocketModel;
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
        $this->passageImageModel = new PassageImageModel();
        $this->websocketModel = new WebsocketModel();
        
        /**
         * Method de request
         */
        $this->method = $_SERVER['REQUEST_METHOD'];

        $this->api = Config::vars('api');
        $this->public = Config::vars('public');
    }

    /**
     * Index
     */
    public function index()
    {
        $this->setRender('Ajax');
        $this->output->setCode(200);
        $this->output->setData(['WebSocket OCR API']);

        $request = $this->json;
        Utils::saveLogFile('websocketEvent.log', $request);
        $save['request_json'] = json_encode($request);
        $save['action'] = $request[0]['action'];
        $save['number'] = $request[0]['params']['number'];
        $save['camera'] = $request[0]['params']['camera_id'];
        $save['recognizer'] = $request[0]['params']['recognizer_id'];
        $save['time_enter'] = isset($request[0]['params']['time_enter']) ? $request[0]['params']['time_enter'] : str_replace('T', ' ', $request[0]['time']);
        $save['time_leave'] = isset($request[0]['params']['time_leave']) ? $request[0]['params']['time_leave'] : str_replace('T', ' ', $request[0]['time']);
        $save['source'] = $request[0]['params']['__source'];
        $this->websocketModel->save($save);
        
        foreach($request as $k => $passage)
        {
            $best_view_date_time = $passage['params']['best_view_date_time'];
            $camera_id = $passage['params']['camera_id'];
            $image = $this->Securos->getBestViewDataImage($camera_id, $best_view_date_time);
            
            $tmp_file = 'img/tmp/';
            $path = $this->public. $tmp_file;
            $file_name = 'securos-'.$passage['params']['tid'].'.jpeg';
            $file_path = $path.$file_name;
            file_put_contents($file_path, $image);

            $passage['imagens'][] = $tmp_file.$file_name;

            $params['api_origin'] = 2;
            $params['direction'] = $passage['params']['direction_id'];
            $params['datetime'] = isset($passage['params']['time_enter']) ? $passage['params']['time_enter'] : str_replace('T', ' ', $passage['time']);;
            $params['external_id'] = $passage['params']['uuid'];
            $params['id_gate'] = $passage['params']['tid'];
            $params['camera'] = current($this->cameraModel->findIdByExternalId($passage['params']['camera_id']))['id'];
            if($passage['type'] === 'CNR_CAM_TOP')
            {
                $params['container'] = $passage['params']['number'];
                $exists = $this->passageModel->exists('container', str_replace('T', ' ', $passage['time']), $passage['params']['number'], $params['camera']);
            }
            else
            {
                $params['plate'] = $passage['params']['number'];
                $exists = $this->passageModel->exists('plate', $passage['params']['time_enter'], $passage['params']['number'], $params['camera']);
            }

            $date_enter = isset($passage['params']['time_enter']) ? $passage['params']['time_enter'] : str_replace('T', ' ', $passage['time']);
            $date_exit = isset($passage['params']['time_leave']) ? $passage['params']['time_leave'] : str_replace('T', ' ', $passage['time']);
            $passages_in_the_meantime = $this->passageModel->bindPassage($params['camera'],  $date_enter, $date_exit);
            if(!empty($passages_in_the_meantime))
            {
                Utils::saveLogFile('bind.log', $passages_in_the_meantime);
                
                foreach($passage['imagens'] as $img)
                {
                    $params_edit['id'] = current($passages_in_the_meantime)['id'];
                    if($passage['type'] === 'CNR_CAM_TOP')
                    {
                        $params_edit['container'] = $passage['params']['number'];
                        $params_edit['plate'] = current($passages_in_the_meantime)['number'];
                    }
                    else
                    {
                        $params_edit['plate'] = $passage['params']['number'];
                        $params_edit['container'] = current($passages_in_the_meantime)['number'];
                    }

                    $id = $this->passageModel->update($params_edit);

                    $passage_image_param['passage_id'] = $params_edit['id'];
                    $passage_image_param['url'] = $img;
                    $this->passageImageModel->save($passage_image_param);
                }
            }
            else
            {
                if(empty($exists))
                {
                    $id = $this->passageModel->save($params);
                
                    foreach($passage['imagens'] as $img)
                    {
                        $passage_image_param['passage_id'] = $id;
                        $passage_image_param['url'] = $img;
                        $this->passageImageModel->save($passage_image_param);
                    }
                }
            }
        }
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
