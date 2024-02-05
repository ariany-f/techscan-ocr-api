<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Src {

    use Config\Config;
    use DateTime;
    use Mobile_Detect;
    use Src\Controller\Component\AppComponent;
    use Tecno\Lib\Request;
    use Tecno\Lib\Session;
    use Tecno\Lib\Utils;
    use Tecno\View\Json;
    use Tecno\Controller\Controller;

    class App extends Controller {

        /**
         * View em Json
         * @var Json
         */
        public $output,
               $AppComponent,
               $interface;

        /**
         * App constructor
         * Set classes de apoio
         * @throws \Exception
         */
        public function __construct()
        {
            /**
             * Obrigatorio
             */
            parent::__construct();

            /**
             * Load componentes
             */
            $this->authenticate([
                'method' => 'Restful',
                'table' => 'api_users',
                'status' => 'status',
                'status_active' => 1,
                'token' => 'token',
                'expire' => 'expire',
            ]);

            /**
             * Checks mobile
             */
            $this->interface = new Mobile_Detect();

            /**
             * Utils do app
             */
            $this->AppComponent = new AppComponent();

            /**
             * Troca o layout se logado
             */
            $auth = Session::read('Auth');
            if($auth)
            {
                $this->setLayout('Layout/auth');
            }
        }

        /**
         * Para acoes que so devem ocorrer uma vez por request
         * @throws \Exception
         */
        public function register()
        {
            $auth = Session::read('Auth');

            /***********************************************************************************************************
             * Para o dashboard
             */
            $ip = Utils::getClientIp();
            $browser = Utils::getBrowser();
            $client_access_key = Session::read('client_access_key');
            $post['post'] = $_POST;
            $json['json'] = json_decode(file_get_contents('php://input'), true);
            $received_params = array_merge($json, $post);
            $session = session_id();
            $browser_name_pattern = (isset($browser['browser_name_pattern']) and $browser['browser_name_pattern'] != '') ? $browser['browser_name_pattern'] : 'undefined';

            if(!$client_access_key)
            {
                $client_access_key = md5(date('YmdHis') . $ip . $browser_name_pattern . md5(rand(0, 10000000)));
                Session::write('client_access_key', $client_access_key);
            }

            /**
             * Ip do server
             */
            if(count($browser) > 1)
            {

                $platform = ($browser['platform'] != '') ? $browser['platform'] : 'undefined';
                $params = [
                    'origin' => (isset($browser['device_type']) and ($browser['device_type'] != '') ? strtolower($browser['device_type']) : 'undefined'),
                    'ip' => $ip,
                    'session_id' => $session,
                    'client_access_key' => $client_access_key,
                    'user_id' => ($auth) ? $auth['user_id'] : 0,
                    'url' => Utils::urlFull(),
                    'received_params' => json_encode($received_params),
                    'user_agent' => (isset($_SERVER['HTTP_USER_AGENT']) and !empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '*',
                    'browser_name' => ($browser['browser'] != '') ? $browser['browser'] : 'undefined',
                    'browser_version' => ($browser['version'] != '') ? $browser['version'] : 'undefined',
                    'so_name' => $platform,
                    'so_version' => $platform,
                    'request_time' => date('Y-m-d H:i:s')
                ];
              //  $this->AppComponent->sysAccessLog($params);
            }
            /***********************************************************************************************************/

            /**
             * Muda a linguagem caso venha na url
             */
            if(isset($this->get['lang']) and !empty($this->get['lang']))
            {
                Session::write('lang', $this->get['lang']);
                Utils::redirect(['url' => explode('?', Utils::urlFull())[0]]);
            }
            else
            {
                if(!Session::read('lang') and 1==0)
                {
                    $lang_browser = @(str_replace("-", "_", @explode(',', @getallheaders()['Accept-Language'])[0])) ?? 'pt_br';
                    $lang = Config::vars('lang');
                    $lang_available = Config::vars('lang_available');
                    if(in_array($lang_browser, $lang_available))
                    {
                        Session::write('lang', $lang_browser);
                    }
                    else
                    {
                        Session::write('lang', $lang);
                    }
                }
            }
        }

        /**
         * @param $request
         * @param $field
         * @param bool $nulo
         * @param string $type
         * @param int $size
         * @return array|mixed
         */
        public function checkFieldRequest($request, $field, $nulo = FALSE, $type = '', $size = 6, $rules = 1)
        {
            /**
             * Saida json
             */
            $this->setRender('json');
            $this->output->setCode(400);
            $this->output->setSuccess(false);
            $this->output->setData([]);

            if(!array_key_exists($field, $request))
            {
                $this->output->setMessage(__('Invalid request, contact the administrator'));
                $this->output->setErrors([
                    [
                        'request0' => [
                            'parameter' => $field,
                            'message' => __('Missing parameter :field', [
                                ':field' => $field
                            ])
                        ]
                    ]
                ]);
                $this->output->now();
            }

            /**
             * Trata vazio
             */
            if (!is_array($request[$field]) and $type != 'boolean')
            {
                $var = strlen(trim($request[$field]));
                if (empty($var) AND ($nulo))
                {
                    $this->output->setMessage(__('Empty field, contact the administrator'));
                    $this->output->setErrors([
                        [
                            'request0' => [
                                'parameter' => $field,
                                'message' => __('Parameter :field can not be empty', [
                                    ':field' => $field
                                ])
                            ]
                        ]
                    ]);
                    $this->output->now();
                }
            }

            /**
             * Para retorno e checagem
             */
            $var = (is_string($request[$field])) ? trim($request[$field]) : $request[$field];

            /**
             * Validacoes de tipo
             */
            switch ($type)
            {
                case 'date':
                    if(is_string($var))
                    {
                        DateTime::createFromFormat('Y-m-d', $var);
                        $check = DateTime::getLastErrors()['warning_count'] + DateTime::getLastErrors()['error_count'];
                    }
                    else
                    {
                        $check = true;
                    }

                    if ($check)
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value :var of the parameter :field does not follow the yyyy-mm-dd format or is not a valid date', [
                                        ':var' => $var,
                                        ':field' => $field
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                    break;

                case 'datetime':
                    DateTime::createFromFormat('Y-m-d H:i:s', $var);
                    if (DateTime::getLastErrors()['warning_count'] OR DateTime::getLastErrors()['error_count'])
                    {
                        $this->output->setCode(400);
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value :var of the parameter :field does not follow the yyyy-mm-dd hh:ii:ss format or is not a valid datetime', [
                                        ':var' => $var,
                                        ':field' => $field
                                    ])
                                ]
                            ]
                        ]);

                        $this->output->now();
                    }
                    break;

                case 'mail':
                    if($nulo)
                    {
                        if (!Utils::isMail($var))
                        {
                            $this->output->setMessage(__('Invalid request, contact the administrator'));
                            $this->output->setErrors([
                                [
                                    'request0' => [
                                        'parameter' => $field,
                                        'message' => __('The value :var of the parameter :field is not a valid email', [
                                            ':var' => $var,
                                            ':field' => $field
                                        ])
                                    ]
                                ]
                            ]);
                            $this->output->now();
                        }
                    }
                    break;

                case 'phone':
                    if($nulo)
                    {
                        if(!Utils::isPhone($var))
                        {
                            $this->output->setMessage(__('Invalid request, contact the administrator'));
                            $this->output->setErrors([
                                [
                                    'request0' => [
                                        'parameter' => $field,
                                        'message' => __('The value :var of the parameter :field does not appear to be a valid phone, must have between 10 and 15 numbers including the country code', [
                                            ':var' => $var,
                                            ':field' => $field
                                        ])
                                    ]
                                ]
                            ]);
                            $this->output->now();
                        }
                    }
                    break;

                case 'numeric':
                    if(!Utils::isNumeric($var))
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value :var of the parameter :field it\'s not a number', [
                                        ':var' => $var,
                                        ':field' => $field
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                    break;

                case 'cpf':
                    if(!Utils::isCpf($var))
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value :var of the parameter :field it\'s not a valid CPF',[
                                        ':var' => $var,
                                        ':field' => $field
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                    break;

                case 'document':
                    if((is_null($var) or empty($var) or strlen($var) < 5))
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value :var of the parameter :field it\'s not a valid document', [
                                        ':var' => $var,
                                        ':field' => $field
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                    break;

                case 'array':
                    if(!is_array($var))
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value :var of the parameter :field it\'s not an array', [
                                        ':var' => $var,
                                        ':field' => $field
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                    break;

                case 'password':
                    $check = Utils::passwordRules($var, $size, $rules);
                    if(!$check['status'])
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __("The value of parameter :field must follow these rules: \n:description", [
                                        ':field' => $field,
                                        ':description' => $check['description']
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                    break;

                case 'integer':
                    if(!Utils::isInteger($var))
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value of parameter :field it\'s is not integer number', [
                                        ':field' => $field
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                    break;

                case 'url':
                    if(!Utils::isUrl($var))
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value of paramenter :field is not a valid url, make sure url is correct', [
                                        ':var' => $var
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                    break;

                case 'img':
                    if(!Utils::isImage($var))
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value :var of the parameter :field is not a valid url, make sure url is correct', [
                                        ':var' => $var,
                                        ':field' => $field
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                    break;

                case 'gender':
                    if(!in_array($var, ['F', 'M']))
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value :var of the parameter :field is not valid, are accepted [F, M]', [
                                        ':var' => $var,
                                        ':field' => $field
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                    break;

                case 'boolean':
                    if(!is_bool($var))
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value :var of the parameter :field is not a boolean', [
                                        ':var' => $var,
                                        ':field' => $field
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                    break;

                case 'month':
                    $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                    if(!in_array($var, $month) or strlen($var) < 2)
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value :var of the parameter :field is not valid, months are accepted with 2 numeric digits', [
                                        ':var' => $var,
                                        ':field' => $field
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                    break;

                case 'year':
                    if(!(is_numeric($var)) or !(strlen($var) == 4) or !($var >= 1900))
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value :var of the parameter :field is not valid, years are accepted with 4 numerical digits greater than 1900', [
                                        ':var' => $var,
                                        ':field' => $field
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                    break;

                case 'paymentMethod':
                    if(!in_array($var, ['credit_card', 'boleto', 'debit']))
                    {
                        $this->output->setMessage('Invalid request, contact the administrator');
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The payment method :var of the parameter :field is not valid, they are accepted (credit_card, boleto and debit)', [
                                        ':var' => $var,
                                        ':field' => $field
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                break;

                case 'provider_type_id':
                    if(!Utils::isInteger($var))
                    {
                        $this->output->setMessage('Invalid request, contact the administrator');
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The value of parameter :field it\'s is not integer number', [
                                            ':field' => $field
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }

                    if(!in_array($var, [1, 2]))
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('Type of provider accepted [1 = Legal Entity or 2 = Individual contributor]')
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                break;

                case 'country':
                    if(!in_array($var, Config::vars('countries')))
                    {
                        $this->output->setMessage(__('Invalid request, contact the administrator'));
                        $this->output->setErrors([
                            [
                                'request0' => [
                                    'parameter' => $field,
                                    'message' => __('The country :var is not accepted, countries accepted [\':countries\']', [
                                        ':var' => $var,
                                        ':countries' => implode("', '",Config::vars('countries'))
                                    ])
                                ]
                            ]
                        ]);
                        $this->output->now();
                    }
                break;
            }

            return Utils::escape($var);
        }

        /**
         * Endpoint error
         */
        public function endpointError()
        {
            $this->output->setCode(405);
            $this->output->setMessage(__('Request method'));
            $this->output->setSuccess(false);
            $this->output->setErrors([
                [
                    'code' => 'request1',
                    'value' => __('Method not allowed or not implemented for this endpoint')
                ]
            ]);
            $this->output->now();
        }

        /**
         * Valores para a saida em json
         *
         * Recebe valor das mensagens
         * @var
         */
        public $message = 'Acesso não permitido!';

        /**
         * Codigo do erro
         * @var int
         */
        public $code = 403;

        /**
         * Status da acao
         * @var string
         */
        public $success = false;

        /**
         * @var array
         */
        public $data = [];

        /**
         * @var array
         */
        public $errors = [];

        /**
         * Gera saida em json
         */
        public function generateOutput()
        {
            $this->setRender('json');
            $this->output->setCode($this->code);
            $this->output->setMessage(__($this->message));
            $this->output->setSuccess($this->success);
            $this->output->setData($this->data);
            $this->output->setErrors($this->errors);
            $this->output->now();
        }
    }
}