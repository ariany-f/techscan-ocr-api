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
use src\Model\User\UserModel;
use src\Model\Gate\GateModel;
use src\Model\Camera\CameraModel;
use src\Model\Passage\PassageModel;
use src\Model\Passage\PassageImageModel;
use Tecno\Lib\Csrf;
use Tecno\Lib\Mailer;


class GetOCRDataController extends App
{

    /**
     * GetOCRData constructor
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
            'cameras',
            'passagens',
            'gates'
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
        $this->gateModel = new GateModel();
        $this->userModel = new UserModel();
        $this->cameraModel = new CameraModel();
        $this->passageModel = new PassageModel();
        $this->passageImageModel = new PassageImageModel();
        
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
        $this->output->setData(['Bem vIndo a API OCR']);
        $this->output->now();
    }
    
    public function gates()
    {
        $this->setRender('Ajax');

        switch($this->api)
        {
            case 'wegate':
                $result = $this->Wegate->getGates();
                $params['api_origin'] = 3;
                foreach($result as $gate)
                {
                    $params['name'] = $gate['name'];
                    $params['external_id'] = $gate['id'];
                    $this->gateModel->save($params);
                }
                break;
            default:
                $result = [
                    'Não há OCR configurado, por favor contate o administrador'
                ];
            break;
        }

        $this->output->setCode(200);
        $this->output->setSuccess(true);
        $this->output->setData([ $result ]);
        $this->output->now();
    }
    

    public function cameras()
    {
        $this->setRender('Ajax');

        switch($this->api)
        {
            case 'securos':
                $result = $this->Securos->getCameras();
                
                if(isset($result['data']))
                {
                    $result = $result['data'];
                }
                else
                {
                    $result = [
                        'Não há OCR configurado, por favor contate o administrador'
                    ];
                    break;
                }

                $params['api_origin'] = 1;
                foreach($result as $camera)
                {
                    $params['direction'] = (isset(explode(':', $camera['name'])[1]) && explode(':', $camera['name'])[1] == 'Externo') ? 1 : 2;
                    $params['gate_id'] = 0;
                    $params['external_id'] = $camera['id'];
                    $params['name'] = $camera['name'];
                    $params['position'] = isset(explode(':', $camera['name'])[2]) ? explode(':', $camera['name'])[2] : ($camera['name'] === 'LPR' ? 'LPR' : 'plate');
                    $this->cameraModel->save($params);
                }
                break;
            case 'wegate':
                $result = $this->Wegate->getCameras();
                $params['api_origin'] = 3;
                foreach($result as $gate)
                {
                    if(strpos($gate['name'], "ENTRADA"))
                    {
                        $params['direction'] = 1;
                    }
                    else if(strpos($gate['name'], "SAÍDA"))
                    {
                        $params['direction'] = 2;
                    }
                    else
                    {
                        $params['direction'] = 3;
                    }
                    $params['gate_id'] = $gate['id'];

                    foreach($gate['cameras'] as $camera)
                    {
                        $params['external_id'] = explode('.', $camera['host'])[3];
                        $params['position'] = $camera['type'];
                        $params['name'] = $camera['name'];
                        $this->cameraModel->save($params);
                    }
                }
                break;
            default:
                $result = [
                    'Não há OCR configurado, por favor contate o administrador'
                ];
            break;
        }

        $this->output->setCode(200);
        $this->output->setSuccess(true);
        $this->output->setData([ $result ]);
        $this->output->now();
    }
    

    public function passagens()
    {
        $this->setRender('Ajax');

        switch($this->api)
        {
            case 'securos':
                $result = $this->Securos->getPassagens();
                $params['api_origin'] = 2;
                foreach(current($result) as $passagem)
                {
                    $params['direction'] = $passagem['direction_id'];
                    $params['datetime'] = $passagem['time_enter'];
                    $params['external_id'] = $passagem['uuid'];
                    $params['id_gate'] = $passagem['tid'];
                    $params['plate'] = $passagem['number'];
                    $params['camera'] = current($this->cameraModel->findIdByExternalId($passagem['camera_id']))['id'];
					
					$exists = $this->passageModel->exists('plate', $passagem['time_enter'], $passagem['number'], $params['camera']);
					if(empty($exists))
					{
						$id = $this->passageModel->save($params);
                    
						foreach($passagem['imagens'] as $img)
						{
							$passage_image_param['passage_id'] = $id;
							$passage_image_param['url'] = $img;
							$this->passageImageModel->save($passage_image_param);
						}
					}
                }
                break;
            case 'wegate':
                $result = $this->Wegate->getPassagens();
                $params['api_origin'] = 3;
                foreach($result as $passagem)
                {
                    if(!empty($passagem))
                    {
                        $params['direction'] = (($passagem['direction'] == 'in') ? 1 : 2);
                        $params['datetime'] = $passagem['datetime'];
                        $params['external_id'] = $passagem['number'];
                        $params['id_gate'] = $passagem['gateId'];
                        
                        if(empty($passagem['plates']) && empty($passagem['containers']))
                        {
                            $params['camera'] = 1;
                            $exists = $this->passageModel->exists(null, $passagem['datetime'], null, $params['camera']);
                            if(empty($exists))
                            {
                                $params['is_ok'] = 0;
                                $id = $this->passageModel->save($params);

                                $params['container'] = null;
                                $params['plate'] = null;
                                $params['camera'] = null;
                            }
                        }
                        else
                        {
                            foreach($passagem['plates'] as $plate)
                            {
                                $params['plate'] = $plate['plate'];
                                $params['camera'] = (current($this->cameraModel->findIdByName($plate['camera']))['id'] ?? 1);
                                $exists = $this->passageModel->exists('plate', $passagem['datetime'], $plate['plate'], $params['camera']);
                                if(empty($exists))
                                {
                                    $id = $this->passageModel->save($params);
                                    foreach($plate['imagens'] as $plate_image)
                                    {
                                        $passage_image_param['passage_id'] = $id;
                                        $passage_image_param['url'] = $plate_image;
                                        $this->passageImageModel->save($passage_image_param);
                                    }
    
                                    $params['plate'] = null;
                                    $params['camera'] = null;
                                }
                            }
                            foreach($passagem['containers'] as $container)
                            {
                                $params['container'] = $container['text'];
                                $params['camera'] = (current($this->cameraModel->findIdByName($container['camera']))['id'] ?? 1);
                                $exists = $this->passageModel->exists('container', $passagem['datetime'], $container['text'], $params['camera']);
                                if(empty($exists))
                                {
                                    $id = $this->passageModel->save($params);
                                    foreach($container['imagens'] as $container_image)
                                    {
                                        $passage_image_param['passage_id'] = $id;
                                        $passage_image_param['url'] = $container_image;
                                        $this->passageImageModel->save($passage_image_param);
                                    }
    
                                    $params['container'] = null;
                                    $params['camera'] = null;
                                }
                            }
                        }
                    }
                }
                break;
            default:
                $result = [
                    'Não há OCR configurado, por favor contate o administrador'
                ];
            break;
        }

        $this->output->setCode(200);
        $this->output->setSuccess(true);
        $this->output->setData([ $result ]);
        $this->output->now();
    }
}
