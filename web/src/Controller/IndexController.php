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
use src\Model\Option\OptionModel;
use src\Model\Camera\CameraModel;
use src\Model\Passage\PassageModel;
use Tecno\Lib\Csrf;
use Tecno\Lib\Mailer;


class IndexController extends App
{
    
    public $Wegate;
    public $Securos;
    public $userModel;
    public $gateModel;
    public $cameraModel;
    public $optionModel;
    public $passageModel;
    public $reasonModel;
    public $method;
    public $api;

    /**
     * IndexController constructor
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
            'tempo'
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
        $this->optionModel = new OptionModel();
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
     * Index
     */
    public function tempo()
    {
        $this->setRender('Ajax');

        if($this->method == 'PUT')
        {
            $params = $this->json;

            $params['value'] = $this->checkFieldRequest($params, 'time', false, "integer");
            $params['description'] = 'register_collapse_seconds';
            $params['id'] = current($this->optionModel->get($params['description']))['id'];

            $result = $this->optionModel->update($params);

            if($result) {

                $return = [
                    'id'=> $result,
                    'value' => $params['value']
                ];

                $this->output->setCode(200);
                $this->output->setMessage( 'Tempo alterado com sucesso!' );
                $this->output->setSuccess( true );
                $this->output->setData( $return );
            }
            else
            {
                $this->output->setCode(200);
                $this->output->setMessage( 'Erro ao alterar tempo' );
                $this->output->setSuccess( false );
                $this->output->setData( [] );
            }
        }
        else if($this->method == 'GET')
        {
            $params = $this->json;

            $params['description'] = 'register_collapse_seconds';
            $result = $this->optionModel->get($params['description'] );

            $this->output->setCode(200);
            $this->output->setMessage( 'Configuração de tempo' );
            $this->output->setSuccess( true );
            $this->output->setData( $result );
        }
        
        $this->output->now();
    }
    
    /**
     * Usuários do sistema
     */
    public function users()
    {
        $this->setRender('Ajax');

        if($this->method == 'GET')
        { 
            $params = $this->json;

            $id = $this->params[0] ?? null;
            $result = $this->userModel->get($id);

            $this->output->setCode(200);
            $this->output->setMessage( 'Usuários ativos' );
            $this->output->setSuccess( true );
            $this->output->setData( $result );
        }
        else if($this->method == 'POST')
        {
            $params = $this->json;

            $params['status'] = 1;
            $params['name'] = $this->checkFieldRequest($params, 'name', false);
            $params['permission_id'] = $this->checkFieldRequest($params, 'permission_id', false);
            $params['email'] = $this->checkFieldRequest($params, 'email', false, "mail");
            $pass = $this->checkFieldRequest($params, 'password', false);
            $params['password'] = sha1(Config::vars('salt') . $pass);
            $result = $this->userModel->save($params);

            if($result) {

                $return = [
                    'id'=> $result,
                    'email' => $params['email']
                ];

                $this->output->setCode(200);
                $this->output->setMessage( 'Usuário salvo com sucesso!' );
                $this->output->setSuccess( true );
                $this->output->setData( $return );
            }
            else
            {
                $this->output->setCode(200);
                $this->output->setMessage( 'Erro ao salvar usuário' );
                $this->output->setSuccess( false );
                $this->output->setData( [] );
            }
        }
        else if($this->method == 'DELETE')
        {
            $params = $this->json;

            $params['id'] = $this->checkFieldRequest($params, 'id', false, "integer");
            $params['status'] = 2;

            $result = $this->userModel->alterarStatus($params);

            if($result) {

                $return = [
                    'id'=> $result,
                    'status' => $params['status']
                ];

                $this->output->setCode(200);
                $this->output->setMessage( 'Usuário desativado com sucesso!' );
                $this->output->setSuccess( true );
                $this->output->setData( $return );
            }
            else
            {
                $this->output->setCode(200);
                $this->output->setMessage( 'Erro ao desativar usuário' );
                $this->output->setSuccess( false );
                $this->output->setData( [] );
            }
        }
        else if($this->method == 'PUT')
        {
            $params = $this->json;
            
            $params['id'] = $this->checkFieldRequest($params, 'id', false, "integer");

            if(!empty($params['status']))
            {
                $params['status'] = $this->checkFieldRequest($params, 'status', false);
            }
            if(!empty($params['name']))
            {
                $params['name'] = $this->checkFieldRequest($params, 'name', false);
            }
            if(!empty($params['email']))
            {
                $params['email'] = $this->checkFieldRequest($params, 'email', false);
            }
            if(!empty($params['permission_id']))
            {
                $params['permission_id'] = $this->checkFieldRequest($params, 'permission_id', false);
            }
            if(!empty($params['password']))
            {
                $pass = $this->checkFieldRequest($params, 'new_password', false);
                $params['password'] = sha1(Config::vars('salt') . $pass);
            }

            Utils::saveLogFile('update.log', [
                'params' => $params
            ]);
            $result = $this->userModel->update($params);

            if($result) {

                $return = [
                    'id'=> $result,
                    'status' => $params['status']
                ];

                $this->output->setCode(200);
                $this->output->setMessage( 'Usuário alterado com sucesso!' );
                $this->output->setSuccess( true );
                $this->output->setData( $return );
            }
            else
            {
                $this->output->setCode(200);
                $this->output->setMessage( 'Erro ao alterar usuário' );
                $this->output->setSuccess( false );
                $this->output->setData( [] );
            }
        }

        $this->output->now();
    }
    
    /**
     * Portões cadastrados
     */
    public function portoes()
    {
        
        $this->setRender('Ajax');

        if($this->method == 'GET')
        {
            $result = $this->gateModel->get();

            $this->output->setCode(200);
            $this->output->setMessage( 'Portões' );
            $this->output->setSuccess( true );
            $this->output->setData( $result );
        }
        else if($this->method == 'POST')
        {
            $params = $this->json;

            $params['api_origin'] = 0;
            $params['name'] = $this->checkFieldRequest($params, 'name', false);

            $result = $this->gateModel->save($params);

            if($result) {

                $return = [
                    'id'=> $result,
                    'name' => $params['name']
                ];

                $this->output->setCode(200);
                $this->output->setMessage( 'Portão salvo com sucesso!' );
                $this->output->setSuccess( true );
                $this->output->setData( $return );
            }
            else
            {
                $this->output->setCode(200);
                $this->output->setMessage( 'Erro ao salvar portão' );
                $this->output->setSuccess( false );
                $this->output->setData( [] );
            }
        }
        
        $this->output->now();
    }
    
    /**
     * Apis cadastrados
     */
    public function apis()
    {
        $this->setRender('Ajax');

        if($this->method == 'GET')
        {
            $result = $this->passageModel->getExternalApis();

            $this->output->setCode(200);
            $this->output->setMessage( 'Apis Externas' );
            $this->output->setSuccess( true );
            $this->output->setData( $result );
        }
        
        $this->output->now();
    }

    /**
     * Cameras cadastradas
     */
    public function cameras()
    {
        
        $this->setRender('Ajax');

        if($this->method == 'GET')
        {
            $result = $this->cameraModel->get();

            $this->output->setCode(200);
            $this->output->setMessage( 'Cãmeras' );
            $this->output->setSuccess( true );
            $this->output->setData( $result );
        }
        if($this->method == 'PUT')
        {
            $params = $this->json;

            $params['id'] = $this->checkFieldRequest($params, 'id', false, "integer");

            if(!empty($params['direction']))
            {
                $params['direction'] = $this->checkFieldRequest($params, 'direction', false);
            }
            if(!empty($params['name']))
            {
                $params['name'] = $this->checkFieldRequest($params, 'name', false);
            }
            if(!empty($params['position']))
            {
                $params['position'] = $this->checkFieldRequest($params, 'position', false);
            }
            if(!empty($params['representative_img_id']))
            {
                $params['representative_img_id'] = $this->checkFieldRequest($params, 'representative_img_id', false);
            }

            $result = $this->cameraModel->update($params);

            if($result) {

                $return = [
                    'id'=> $result
                ];

                $this->output->setCode(200);
                $this->output->setMessage( 'Câmera alterada com sucesso!' );
                $this->output->setSuccess( true );
                $this->output->setData( $return );
            }
            else
            {
                $this->output->setCode(200);
                $this->output->setMessage( 'Erro ao alterar câmera' );
                $this->output->setSuccess( false );
                $this->output->setData( [] );
            }
        }
        
        $this->output->now();
    }

    /**
     * Estatisticas
     */
    public function estatisticas() 
    {
        $this->setRender('Ajax');

        if($this->method == 'POST')
        {
            $params = $this->json;

            $id = $this->params[0] ?? null;
            $data_inicial = $params['dataInicial'] ?? null;
            $data_final = $params['dataFinal'] ?? null;
            $result = $this->passageModel->getStatistics($id, $data_inicial, $data_final);

            $this->output->setCode(200);
            $this->output->setMessage( 'Estatísticas' );
            $this->output->setSuccess( true );
            $this->output->setData( $result );

        }
        $this->output->now();
    }

    /**
     * Imagens Representativas
     */
    public function direcoes()
    {
        $this->setRender('Ajax');

        if($this->method == 'GET')
        {
            $result = $this->cameraModel->getDirecoes();

            $this->output->setCode(200);
            $this->output->setMessage( 'Direções' );
            $this->output->setSuccess( true );
            $this->output->setData( $result );
        }
        
        $this->output->now();
    }

    /**
     * Imagens Representativas
     */
    public function imagens()
    {
        
        $this->setRender('Ajax');

        if($this->method == 'GET')
        {
            $result = $this->cameraModel->getImagensRepresentativas();

            $this->output->setCode(200);
            $this->output->setMessage( 'Imagens Representativas' );
            $this->output->setSuccess( true );
            $this->output->setData( $result );
        }
        
        $this->output->now();
    }
    
    /**
     * Passagens registradas
     */
    public function passagens()
    {
        $this->setRender('Ajax');

        if($this->method == 'POST')
        { 
            $params = $this->json;

            $id = $this->params[0] ?? null;
            $data_inicial = $params['dataInicial'] ?? null;
            $data_final = $params['dataFinal'] ?? null;
            $result = $this->passageModel->get($id, $data_inicial, $data_final);
            
            if(isset($result['itens']) and !empty($result['itens']))
            {
                foreach($result['itens'] as $k => $rs)
                {
                    $result[$k]['images'] = array_values(array_filter(explode(",", $rs['images']), 'strlen'));
                }
            }

            $this->output->setCode(200);
            $this->output->setMessage( 'Passagens' );
            $this->output->setSuccess( true );
            $this->output->setData( $result );
        }
        if($this->method == 'GET')
        {
            $id = $this->params[0] ?? null;
            $result = $this->passageModel->get($id);

            if(isset($result) and !empty($result))
            {
                foreach($result as $k => $rs)
                {
                    foreach($rs['itens'] as $key => $item)
                    {
                        $result[$k]['itens'][$key]['images'] = (object) explode(",", $item['images']);
                    }
                }
            }

            $this->output->setCode(200);
            $this->output->setMessage( 'Passagens' );
            $this->output->setSuccess( true );
            $this->output->setData( $result );
        }
        else if ($this->method == 'OPTIONS') {
            $this->output->setCode(200);
            $this->output->setMessage( 'Passagens' );
            $this->output->setSuccess( true );
            $this->output->setData( [] );
        }
        else if($this->method == 'PUT')
        {
            $params = $this->json;

            $params['id'] = $this->checkFieldRequest($params, 'id', false, "integer");
            $params['is_ok'] = $params['is_ok'] ?? null;
            $params['preset_reason'] = isset($params['preset_reason']) ? $this->checkFieldRequest($params, 'preset_reason', false, "integer") : null;
            $params['description_reason'] = isset($params['description_reason']) ? $this->checkFieldRequest($params, 'description_reason', false) : null;
            $params['updated_by'] = isset($params['updated_by']) ? $this->checkFieldRequest($params, 'updated_by', false) : null;

            $result = $this->passageModel->alterar($params);

            if($result) {

                $return = [
                    'id'=> $result,
                    'is_ok' => $params['is_ok']
                ];

                $this->output->setCode(200);
                $this->output->setMessage( 'Passagem alterada com sucesso!' );
                $this->output->setSuccess( true );
                $this->output->setData( $return );
            }
            else
            {
                $this->output->setCode(200);
                $this->output->setMessage( 'Erro ao alterar passagem' );
                $this->output->setSuccess( false );
                $this->output->setData( [] );
            }
        }
        else if($this->method == 'PATCH')
        {
            $params = $this->json;

            $params['id'] = $this->checkFieldRequest($params, 'id', false, "integer");
            $params['plate'] = $this->checkFieldRequest($params, 'plate', false);
            $params['container'] = $this->checkFieldRequest($params, 'container', false);
            $params['updated_by'] = isset($params['updated_by']) ? $this->checkFieldRequest($params, 'updated_by', false) : null;
          
            $result = $this->passageModel->update($params);

            if($result) {

                $return = [
                    'plate' => $params['plate'],
                    'container' => $params['container']
                ];

                $this->output->setCode(200);
                $this->output->setMessage( 'Passagem alterada com sucesso!' );
                $this->output->setSuccess( true );
                $this->output->setData( $return );
            }
            else
            {
                $this->output->setCode(200);
                $this->output->setMessage( 'Erro ao alterar passagem' );
                $this->output->setSuccess( false );
                $this->output->setData( [] );
            }
        }

        $this->output->now();
    }
    
    /**
     * Motivos cadastrados
     */
    public function motivos()
    {
        $this->setRender('Ajax');

        if($this->method == 'GET')
        {
            $result = $this->reasonModel->get();

            $this->output->setCode(200);
            $this->output->setMessage( 'Motivos de Erro' );
            $this->output->setSuccess( true );
            $this->output->setData( $result );
        }
        else if($this->method == 'POST')
        {
            $params = $this->json;

            $params['description'] = $this->checkFieldRequest($params, 'description', false);
            $params['is_ocr_error'] = $this->checkFieldRequest($params, 'is_ocr_error', false);

            $result = $this->reasonModel->save($params);

            if($result) {

                $return = [
                    'id'=> $result,
                    'description' => $params['description'],
                    'is_ocr_error' => $params['is_ocr_error']
                ];

                $this->output->setCode(200);
                $this->output->setMessage( 'Motivo de erro salvo com sucesso!' );
                $this->output->setSuccess( true );
                $this->output->setData( $return );
            }
            else
            {
                $this->output->setCode(200);
                $this->output->setMessage( 'Erro ao salvar motivo de erro' );
                $this->output->setSuccess( false );
                $this->output->setData( [] );
            }
        }

        $this->output->now();
    }
}
