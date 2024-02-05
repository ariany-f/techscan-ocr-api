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

    class SecurOSComponent extends App
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
            $this->service = Config::vars('service')[Config::vars('service_mode')]['securos'];
            $this->token = ('Basic ' . base64_encode($this->service['username'] . ':' . $this->service['password']));
        }

        /*Send Request Serviço when need token*/
        public function sendRequest($params, $action, $method, $url)
        {
            $headers = [
                'Content-Type' => 'application/json'
            ];
            
            if(!empty($this->token))
            {
                $headers['Authorization'] = $this->token;
            }
            
            $response = Request::send(
                $url . '/' . $action,
                $headers,
                $method,
                json_encode($params, JSON_PRETTY_PRINT),
                'securos.log'
            );

            if($response['headers']['Content-Type'] == 'application/octet-stream, image/jpeg')
            {
                return $response['body'];
            }

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
         * buscar cameras
         * @throws \Exception
         */
        public function getCameras()
        {            
            $action = 'cameras';
            $method = 'GET';
            $response = $this->sendRequest([], $action, $method, $this->service['url']);
            return $response;
        }

        /**
         * buscar passagens
         * @throws \Exception
         */
        public function getPassagens()
        {
            
            date_default_timezone_set('America/Sao_Paulo');
            $lastDay = date("Ymd\THis", strtotime("-15 min", strtotime(date("Ymd\THis"))));
            $today = date("Ymd\THis", strtotime(date("Ymd\THis")));
            $action = 'recognizers';
            $method = 'GET';
            $result_recognizers = $this->sendRequest([], $action, $method, $this->service['url2']);
            $response = [];
            foreach($result_recognizers['data'] as $recognizer)
            {
                $action = "recognizers/".$recognizer['id']."/protocol?start_time=$lastDay&stop_time=$today";
                $recognizer_by_id = $this->sendRequest([], $action, $method, $this->service['url2'])['data'];
                foreach($recognizer_by_id as $k => $passagem)
                {
                    $action = "recognizers/".$recognizer['id']."/image/".$passagem['tid'];
                    $image = $this->sendRequest([], $action, $method, $this->service['url2']);
                    
                    $tmp_file = 'img/tmp/';
                    $path = 'C:/xampp/htdocs/api/web/public/'. $tmp_file;
                    $file_name = 'securos-'.$passagem['tid'].'.jpeg';
                    $file_path = $path.$file_name;
                    file_put_contents($file_path, $image);
                    $recognizer_by_id[$k]['imagens'][] = $tmp_file.$file_name;
                }
                $response[] = !empty($recognizer_by_id) ? $recognizer_by_id : [];
                
            }
            return $response;
        }
    }
}