<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Src\Controller\Component {

    use DateTime;
    use Src\App;
    use Config\Config;
    use Tecno\Lib\Session;
    use Tecno\Lib\Utils;
    use Tecno\Lib\Request;

    class WegateComponent extends App
    {
        /**
         * 
         */
        private $service;

        /**
         * BiComponent constructor
         * @throws \Exception
         */
        public function __construct()
        {
            /**
             * Obrigatorio
             */
            parent::__construct();

            /**
             * Load Models entre outros
             */
            $this->service = Config::vars('service')[Config::vars('service_mode')]['wegate'];
        }

        /*Send Request Serviço when need token*/
        public function sendRequest($params, $action, $method)
        {
            $headers = [
                'Content-Type' => 'application/json'
            ];
            
            $response = Request::send(
                $this->service['url'] . '/' . $action,
                $headers,
                $method,
                json_encode($params, JSON_PRETTY_PRINT),
                'wegate.log'
            );
            
            switch($response['headers']['StatusCode'])
            {
                // Unauthorized
                case 401:
                    $error = [
                        'errors' => [
                            [
                                'code' => 'RFC 7235',
                                'description' => __('User or Password Invalids')
                            ]
                        ]
                    ];
                    return json_decode(json_encode($error), true);
                    break;
                //Unprocessable Entity
                case 422:
                    $error = [
                        'errors' => [
                            [
                                'code' => '422',
                                'description' => 'Não foi possível processar sua solicitação'
                            ]
                        ]
                    ];
                    return json_decode(json_encode($error), true);
                    break;
                //Not Found
                case 404:
                    $error = [
                        'errors' => [
                            [
                                'code' => '404',
                                'description' => 'Endpoint não encontrado'
                            ]
                        ]
                    ];
                    return json_decode(json_encode($error), true);
                    break;
                //Internal Server Error
                case 500:
                    $error = [
                        'errors' => [
                            [
                                'code' => '500',
                                'description' => 'Erro Interno'
                            ]
                        ]
                    ];
                    return json_decode(json_encode($error), true);
                    break;
                //Created
                case 201:
                    return json_decode($response['body'], true);
                    break;
                default:
                    return json_decode($response['body'], true);
            }
        }
        
        /**
         * buscar gates
         * @throws \Exception
         */
        public function getGates()
        {            
            $action = 'api/v1/gates';
            $method = 'GET';
            $response = $this->sendRequest([], $action, $method);
            return $response;
        }

        /**
         * buscar cameras
         * @throws \Exception
         */
        public function getCameras()
        {            
            $action = 'api/v1/gates';
            $method = 'GET';
            $response = $this->sendRequest([], $action, $method);
            foreach($response as $k => $camera)
            {
                $action = "wegate/transaction/getstatus?gateId=".$camera['id'];
                $response[$k]['status'] = $this->sendRequest([], $action, $method);
            }
            return $response;
        }

        /**
         * buscar passagens
         * @throws \Exception
         */
        public function getPassagens()
        {
            $cameras = $this->getCameras();
            $method = 'GET';
            foreach($cameras as $camera)
            {
                $action = "wegate/transaction/gettransactionbygateid?gateId=".$camera['id'];
                $transactions =  $this->sendRequest([], $action, $method);
                $result = isset($transactions['transaction']) ? $transactions['transaction'] : [];
                
                if(isset($result['plates']) and (!empty($result['plates'])))
                {
                    foreach($result['plates'] as $key => $passagem)
                    {
                        $tmp_file = 'img/tmp/';
                        $path = 'C:/xampp/htdocs/api/web/public/'. $tmp_file;
                        foreach($passagem['images'] as $k => $image)
                        {
                            $image_title = 'wegate-plate-' . $passagem['plate'] . '-' . $k . '-' . $passagem['camera'] . '.jpeg';
                            $file_path = $path.$image_title;

                            file_put_contents($file_path, file_get_contents(str_replace('192.168.137.231', '10.11.12.109', $image)));
                            
                            $result['plates'][$key]['imagens'][] = $tmp_file . $image_title;
                        }
                    }
                }
                if(isset($result['containers']) and (!empty($result['containers'])))
                {
                    foreach($result['containers'] as $key => $passagem)
                    {
                        $tmp_file = 'img/tmp/';
                        $path = 'C:/xampp/htdocs/api/web/public/'. $tmp_file;
                        foreach($passagem['images'] as $k => $image)
                        {
                            $image_title = 'wegate-container-' . $passagem['text'] . '-' . $k . '-' . $passagem['camera'] . '.jpeg';
                            $file_path = $path.$image_title;

                            file_put_contents($file_path, file_get_contents(str_replace('192.168.137.231', '10.11.12.109', $image)));

                            $result['containers'][$key]['imagens'][] =  $tmp_file . $image_title;
                        }
                    }
                }
                
                $response[] = $result;
            }
            return $response;
        }
    }
}