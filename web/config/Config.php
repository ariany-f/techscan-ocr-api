<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Config {

    use ArrayAccess;

    class Config {

        /**
         * Configuracoes do app
         * @param $value
         * @return array|mixed|string
         */
        public static function vars($value)
        {
            $params = [
                /**
                 * Modo de debug
                 * para exibir erros
                 */
                'debug' => true,

                /**
                 * Show detalhes execucao
                 */
                'params_show' => false,
                'execution_time_show' => false,
                'screen_size_show' => true,

                'api' => 'securos',
                'public' => 'C:/xampp/htdocs/api/web/public/',

                /**
                 * Ambientes
                 * dev
                 * homolog
                 * production
                 */
                'service_mode' => 'dev',

                /**
                 * App name
                 */
                'app_name' => 'API OCR',

                /**
                 * Idioma default
                 */
                'lang' => 'pt_BR',

                /**
                 * Idiomas disponiveis
                 */
                'lang_available' => [
                    'pt_BR',
                    'en_US'
                ],

                /**
                 * Paises aceitos
                 */
                'countries' => [
                    'BRA',
                    'USA'
                ],

                /**
                 * Salt para Senhas
                 */
                'salt' => '183hdj19fh1adhakanlad9f1jf1u9fh8e13hf1032&*^6d*AD68313Ada*AD&y7yd7saD*sADsaDY9ASDas6d78sadd',

                /**
                 * Prazo de validade do token
                 * em segundos
                 */
                'expire_token_in' => 3600,

                /**
                 * Webhook tokens
                 */
                'webhook' => [
                    'dev' => [
                        'token' => ''
                    ],
                    'homolog' => [
                        'token' => ''
                    ],
                    'production' => [
                        'token' => ''
                    ]
                ],

                /**
                 * Serviço Base
                 */
                
                 'service' => [
                    'dev' => [
                        'wegate' => [
                            'url' => 'http://10.11.12.109/rest',
                            'username' => '',
                            'password' => ''
                        ],
                        'securos' => [
                            'url' => '127.0.0.1:8890/api/v1',
                            'url2' => '127.0.0.1:8899/api/v1',
                            'url3' => '127.0.0.1:8890/api/v2',
                            'username' => 'admin',
                            'password' => 'securos'
                        ]
                    ],
                    'homolog' => [
                        'wegate' => [
                            'url' => '',
                            'username' => '',
                            'password' => ''
                        ],
                        'securos' => [
                            'url' => '127.0.0.1:8890/api/v1',
                            'url2' => '127.0.0.1:8899/api/v1',
                            'url3' => '127.0.0.1:8890/api/v2',
                            'username' => 'admin',
                            'password' => 'securos'
                        ]
                    ],
                    'production' => [
                        'wegate' => [
                            'url' => '',
                            'username' => '',
                            'password' => ''
                        ],
                        'securos' => [
                            'url' => '127.0.0.1:8890/api/v1',
                            'url2' => '127.0.0.1:8899/api/v1',
                            'url3' => '127.0.0.1:8890/api/v2',
                            'username' => 'admin',
                            'password' => 'securos'
                        ]
                    ]
                ],
                
                /**
                 * Configuracoes de parceiros
                 */
                'partners' => [
                    'apis' => [
                        'dev' => [
                            'url' => '',
                            'username' => '',
                            'password' => ''
                        ],
                        'homolog' => [
                            'url' => '',
                            'username' => '',
                            'password' => ''
                        ],
                        'production' => [
                            'url' => '',
                            'username' => '',
                            'password' => ''
                        ]
                    ],                    

                    /**
                     * Configuracoes de servico do google
                     */
                    'google' => [
                        'dev' => [
                            'maps' => [
                                'apis' => [
                                    'key' => ''
                                ],
                                'javascript' => [
                                    'key' => ''
                                ]
                            ]
                        ],
                        'homolog' => [
                            'maps' => [
                                'apis' => [
                                    'key' => ''
                                ],
                                'javascript' => [
                                    'key' => ''
                                ]
                            ]
                        ],
                        'production' => [
                            'maps' => [
                                'apis' => [
                                    'key' => ''
                                ],
                                'javascript' => [
                                    'key' => ''
                                ]
                            ]
                        ]
                    ]
                ],

                /**
                 * Database
                 */
                'database' => [
                    /**
                     * Database padrao do framework
                     */
                    'default' => [
                        'dev' => [
                            'type' => 'mysql',
                            'host' => '127.0.0.1',
                            'port' => 3306,
                            'username' => 'root',
                            'password' => '',
                            'database' => 'api_ocr',
                            'encoding' => 'utf8',
                            'language' => 'pt_BR',
                            'persistent' => false
                        ],
                        'homolog' => [
                            'type' => 'mysql',
                            'host' => '127.0.0.1',
                            'port' => 3306,
                            'username' => 'root',
                            'password' => '',
                            'database' => 'api_ocr',
                            'encoding' => 'utf8',
                            'language' => 'pt_BR',
                            'persistent' => false
                        ],
                        'production' => [
                            'type' => 'mysql',
                            'host' => '',
                            'port' => 3306,
                            'username' => '',
                            'password' => '',
                            'database' => '',
                            'encoding' => 'utf8',
                            'language' => 'pt_BR',
                            'persistent' => false
                        ]
                    ]
                ],

                /**
                 * Envio automatico do sistema
                 * Notificacoes entre outros
                 */
                'mail_listener' => [
                    'ti' => [
                        'ti@thunderbold.com.br' => 'Equipe de TI'
                    ],
                    'errors' => 'ti@thunderbold.com.br'
                ],

                /**
                 * Server de email
                 */
                'mail' => [
                    'debug' => [
                        'server' => '',
                        'port' => '',
                        'user' => '',
                        'passwd' => '',
                        'name' => '',
                        'mail' => ''
                    ],
                    'default' => [
                        'server' => '',
                        'port' => '',
                        'user' => '',
                        'passwd' => '',
                        'name' => '',
                        'mail' => ''
                    ]
                ],

                /**
                 * Detalhes da View
                 */
                'view' => [
                    /**
                     * Saida json
                     */
                    'json' => [
                        'code' => 200,
                        'request_id' => null,
                        'message' => '',
                        'errors' => [],
                        'success' => true,
                        'data' => []
                    ],
                    /**
                     * Saida ajax
                     */
                    'ajax' => [
                        'code' => 200,
                        'data' => []
                    ]

                ],

                /**
                 * Set php params
                 */
                'php' => [
                    'shell' => $GLOBALS['shell'],
                    'error_reporting' => E_ALL,
                    'display_errors' => 1,
                    'error_file' => __DIR_ROOT__ . '/tmp/logs/errors.log',
                    'query_log' => true,
                    'query_log_file' => __DIR_ROOT__ . '/tmp/logs/queries.log',
                    'set_time_limit' => 0,
                    'max_execution_time' => 0,
                    'auto_detect_line_endings' => 1,
                    'locale' => [
                        //echo strftime('%A, %d de %B de %Y', strtotime('today'));
                        'pt_BR',
                        'pt_BR.utf-8',
                        'pt_BR.utf-8',
                        'portuguese'
                    ],
                    'session' => [
                        'active' => false,
                        'id' => md5(date('YmdHis') . @$_SERVER['REMOTE_ADDR'] . @$_SERVER['REQUEST_TIME_FLOAT']),
                        'save_path' => __DIR_ROOT__ . '/tmp/sessions',
                        'name' => 'app',
                        'lifetime' => 3600,
                        'path' => '/',
                        'domain' => '',
                        'secure' => true,
                        'httponly' => false,
                        'samesite' => 'lax'
                    ]
                ],

                /**
                 * Diretórios
                 */
                'dir' => [
                   
                ],

                'SFTP' => [
                    'generali' => [
                        'dev' => [
                            'ip' => '',
                            'username' => '',
                            'password' => ''
                        ],
                        'homolog' => [
                            'ip' => '',
                            'username' => '',
                            'password' => ''
                        ],
                        'producao' => [
                            'ip' => '',
                            'username' => '',
                            'password' => ''
                        ]
                    ]
                ],
            ];

            /**
             * Pode chamar um valor do config desta forma por ex:
             * php.session.lifetime
             */
            if(strpos($value, ".") !== false)
            {
                $parts = explode('.', $value);
                switch (count($parts))
                {
                    case 1:
                        return isset($params[$parts[0]]) ? $params[$parts[0]] : '';
                        break;
                    case 2:
                        return isset($params[$parts[0]][$parts[1]]) ? $params[$parts[0]][$parts[1]] : '';
                        break;
                    case 3:
                        return isset($params[$parts[0]][$parts[1]][$parts[2]]) ? $params[$parts[0]][$parts[1]][$parts[2]] : '';
                        break;
                    default:
                        foreach ($parts as $key)
                        {
                            if ((is_array($params) || $params instanceof ArrayAccess) && isset($params[$key]))
                            {
                                $params = $params[$key];
                            }
                            else
                            {
                                return '';
                            }
                        }
                }

                return $params;
            }
            else
            {
                return (isset($params[$value])) ? $params[$value] : '';
            }
        }
    }
}
