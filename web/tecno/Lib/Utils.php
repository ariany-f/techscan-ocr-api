<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Tecno\Lib {

    use Config\Config;
    use Config\Routes;
    use DateTime;
    use MongoDB\BSON\UTCDateTime;

    class Utils {
        /**
         * PrintR
         * @param $var
         * @param bool $stop
         * @param bool $html
         */
        public static function pr($var, $stop = true, $html = 1)
        {
            $status = debug_backtrace();
            if (Config::vars('debug'))
            {
                if($html)
                {
                    echo "<pre>";
                    echo "File: " . $status[0]['file'] . "\n";
                    echo "Line: " . $status[0]['line'] . "\n";
                    echo "\n";
                    print_r($var);
                    echo "</pre>";
                }
                else
                {
                    echo "File: " . $status[0]['file'] . "\n";
                    echo "Line: " . $status[0]['line'] . "\n";
                    echo "\n";
                    print_r($var);
                }

                if ($stop)
                {
                    die;
                }
            }
        }

        /**
         * VarDump
         * @param $var
         * @param bool $stop
         * @param bool $html
         */
        public static function vd($var, $stop = true, $html = false)
        {
            $status = debug_backtrace();
            if (Config::vars('debug'))
            {
                if($html)
                {
                    echo "<pre>";
                    echo "File: " . $status[0]['file'] . "\n";
                    echo "Line: " . $status[0]['line'] . "\n";
                    echo "\n";
                    var_dump($var);
                    echo "</pre>";
                }
                else
                {
                    echo "File: " . $status[0]['file'] . "\n";
                    echo "Line: " . $status[0]['line'] . "\n";
                    echo "\n";
                    var_dump($var);
                }

                if ($stop)
                {
                    die;
                }
            }
        }

        /**
         * Salva em arquivo um debug
         * @param $file
         * @param $data
         */
        public static function saveLogFile($file, $data)
        {
            if (Config::vars('debug'))
            {
                $status = debug_backtrace();
                $log = fopen(__DIR_ROOT__ . "/tmp/logs/" . $file, "a+");
                fwrite($log, date('Y-m-d H:i:s') . ' - ' . microtime(true) . "\n" . print_r(['file' => $status[0]['file'], 'line' => $status[0]['line'], 'data' => $data], true) . "\n\n");
                fclose($log);
            }
        }

        /**
         * Remove as barras duplicada na url
         * @param $string
         * @return string
         */
        public static function removeDoubleBar($string)
        {
            $p = str_split($string);
            return implode(array_map(function ($c) use ($p) {
                return ($c > 0 && $p[$c] == $p[$c - 1] && $p[$c] == '/'  ? '': $p[$c]);
            }, array_keys($p)));
        }

        /**
         * Remove os codes html
         * @param $string
         * @return string
         */
        public static function removeEntities($string)
        {
            return html_entity_decode($string);
        }

        /**
         * Remove caracteres na rota
         * @param $string
         * @return null|string|string[]
         */
        public static function routesClenner($string)
        {
            $find = ['?'];
            $replace = [''];
            $route = str_replace($find, $replace, $string);
            $route = (substr($route, -1) == '/') ? substr($route, 0, -1) : $route;
            $route = (substr($route, -1) == '_') ? substr($route, 0, -1) : $route;
            $route = (substr($route, -1) == '-') ? substr($route, 0, -1) : $route;
            return ($route == '') ? '/' : $route;
        }

        /**
         * CamelCase para controller e actions
         * @param $string
         * @return mixed
         */
        public static function camelCase($string)
        {
            $text = explode("_", $string);
            $camelcase = "";
            foreach ($text as $var)
            {
                $camelcase .= ucfirst($var);
            }
            return $camelcase;
        }

        /**
         * Data de modificacao do arquivo
         * @param $file
         * @return bool|int
         */
        public static function getFileTime($file)
        {
            if (file_exists($file))
            {
                $valor = filemtime($file);
            }
            else
            {
                $valor = false;
            }
            return $valor;
        }

        /**
         * Substitue controler e action e adiciona parametro
         * caso esteja confugurada
         * @param $route
         * @param array $route_dynamic
         * @return bool
         */
        public static function route($route, array $route_dynamic = [])
        {
            $new_router = false;
            $add_router = [];
            $router_compare = Routes::$routers;
            $route_index = isset($_SERVER['ROUTE_INDEX']) ? $_SERVER['ROUTE_INDEX'] : false;
            $route_file_path = __DIR_ROOT__ . "/tmp/routes/";

            /**
             * Checa se diretorio existe, se noa, cria
             */
            if(!file_exists($route_file_path))
            {
                mkdir($route_file_path, 0777);
            }

            if($route_index === false)
            {
                /**
                 * Arquivo de include com todas as rotas para comparar
                 */
                $route_file = 'routes.tmp';
                $route_file_path_full = $route_file_path . $route_file;

                /**
                 * Checa se arquivo existe e se tem menos de uma hora
                 */
                if(file_exists($route_file_path_full) and filemtime($route_file_path_full) > time()-(24*3600))
                {
                    include $route_file_path_full;
                    goto route_compair;
                }
            }
            else
            {
                /**
                 * Arquivo de include com todas as rotas modo vhost
                 */
                $route_vhost = 'routes_vhost.tmp';
                $route_vhost_file_path_full = $route_file_path . $route_vhost;

                /**
                 * Checa se arquivo existe e se tem menos de uma hora
                 */
                if(file_exists($route_vhost_file_path_full) and filemtime($route_vhost_file_path_full) > time()-(24*3600))
                {
                    include $route_vhost_file_path_full;
                    goto route_compair;
                }

                /**
                 * VHOST modifica rota index
                 */
                if($route_index)
                {
                    $route_index = [
                        '/' => [
                            'controller' => $route_index,
                            'action' => 'index',
                            'pass' => []
                        ]
                    ];
                    $router_compare = array_merge($router_compare, $route_index);
                }
            }

            /**
             * Valida array de rota dinamica
             */
            foreach ((array) $route_dynamic as $route_name => $values)
            {
                if(!$route_name)
                {
                    continue;
                }

                if(!preg_match('/^[a-z-\/]+$/', $route_name))
                {
                    continue;
                }

                if(!(isset($values['controller']) and !empty($values['controller'])))
                {
                    continue;
                }

                if(!(isset($values['action']) and !empty($values['action'])))
                {
                    continue;
                }

                if(!(isset($values['pass'])))
                {
                    continue;
                }

                /**
                 * Add rota
                 */
                $add_router[$route_name] = $values;
            }

            /**
             * Tem rota dinamica
             */
            if($add_router)
            {
                $router_compare = array_merge($router_compare, $add_router);
            }

            /**
             * Loop nas rotas
             */
            route_compair:
            foreach($router_compare as $key => $value)
            {
                $full = (strpos($key, '*') !== false) ? true : false;
                $key = ($full) ? substr($key, 0, strlen($key)-2) : $key;

                if($full)
                {
                    if(empty($key))
                    {
                        $params = str_replace($key, '', $route);
                        $params = explode("/", $params);
                        unset($params[0]);
                        $params = array_values($params);
                        $value['params'] = $params;
                        $new_router = $value;
                        break;
                    }

                    $key_arr = explode("/", $key);
                    $route_arr = explode("/", $route);
                    $valid = true;

                    if(count($key_arr) <= count($route_arr))
                    {
                        foreach ($key_arr as $in => $key_value)
                        {
                            if($route_arr[$in] != $key_value)
                            {
                                $valid = false;
                            }
                        }
                    }
                    else
                    {
                        $valid = false;
                    }

                    if($valid)
                    {
                        $params = str_replace($key, '', $route);
                        $params = explode("/", $params);
                        unset($params[0]);
                        $params = array_values($params);
                        $value['params'] = $params;
                        $new_router = $value;
                        break;
                    }
                }
                else
                {
                    if($route == $key)
                    {
                        $params = str_replace($key, '', $route);
                        $params = explode("/", $params);
                        unset($params[0]);
                        $params = array_values($params);
                        $value['params'] = $params;
                        $new_router = $value;
                        break;
                    }
                }
            }

            /**
             * Checa se arquivo existe e se tem menos de uma hora
             */
            if(!empty($route_dynamic))
            {
                if($route_index === false)
                {
                    if(!(file_exists($route_file_path_full) and filemtime($route_file_path_full) > time()-(24*3600)))
                    {
                        /**
                         * Cria o arquivo com todas as rotas
                         */
                        $route_create = fopen($route_file_path_full, "w");
                        $data = "<?php\n";
                        $data .= "\$router_compare = unserialize('" . str_replace("'", "\'", serialize($router_compare)) . "');";
                        fwrite($route_create, $data);
                        fclose($route_create);
                    }
                }
                else
                {
                    if(!(file_exists($route_vhost_file_path_full) and filemtime($route_vhost_file_path_full) > time()-(24*3600)))
                    {
                        /**
                         * Cria o arquivo com todas as rotas
                         */
                        $route_create = fopen($route_vhost_file_path_full, "w");
                        $data = "<?php\n";
                        $data .= "\$router_compare = unserialize('" . str_replace("'", "\'", serialize($router_compare)) . "');";
                        fwrite($route_create, $data);
                        fclose($route_create);
                    }
                }
            }

            return $new_router;
        }

        /**
         * Para saida em ajax
         * @param $data
         * @param $code
         */
        public static function ajax($data, $code)
        {
            header('Content-Type: application/json');
            header('Accept: application/json');
            http_response_code($code);
            echo json_encode($data);
            die;
        }

        /**
         * @param $valor
         * @return string
         */
        public static function moeda($valor)
        {
            return number_format($valor, 2, ',', '.');
        }

        /**
         * Retira uma mascara do valor
         * Ex: ###.###.###-## para CPF
         * @param $valor
         * @return mixed
         */
        public static function clearString($valor)
        {
            $search = [' ', '.', '+', '-', '_', '/', '(', ')', ',', '\\'];
            $replace = ['', '', '', '', '', '', '', '', '', ''];
            $valor = str_replace($search, $replace, trim($valor));
            return $valor;
        }

        /**
         * Valida cnpj
         * @param $cnpj
         * @return bool|string
         */
        public static function isCnpj($cnpj)
        {
            $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
            $cnpj_clean = $cnpj;

            if (strlen($cnpj) != 14) return false;
            if (preg_match('/(\d)\1{13}/', $cnpj)) return false;

            for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
            {
                $soma += $cnpj[$i] * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }

            $resto = $soma % 11;

            if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) return false;

            for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
            {
                $soma += $cnpj[$i] * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }

            $resto = $soma % 11;

            if($cnpj[13] == ($resto < 2 ? 0 : 11 - $resto))
            {
                return $cnpj_clean;
            }

            return false;
        }

        /**
         * Valida cpf
         * @param null $cpf
         * @return bool|string
         */
        public static function isCpf($cpf = null)
        {
            if(empty($cpf))
            {
                return false;
            }

            $cpf = Utils::clearString($cpf);
            $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
            $response = $cpf;

            if (strlen($cpf) != 11)
            {
                return false;
            }
            else if (
                $cpf == '00000000000' ||
                $cpf == '11111111111' ||
                $cpf == '22222222222' ||
                $cpf == '33333333333' ||
                $cpf == '44444444444' ||
                $cpf == '55555555555' ||
                $cpf == '66666666666' ||
                $cpf == '77777777777' ||
                $cpf == '88888888888' ||
                $cpf == '99999999999'
            )
            {
                return false;
            }
            else
            {
                for ($t = 9; $t < 11; $t++)
                {
                    for ($d = 0, $c = 0; $c < $t; $c++)
                    {
                        $d += $cpf[$c] * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpf[$c] != $d)
                    {
                        return false;
                    }
                }
            }
            return $response;
        }

        /**
         * Valida se genero ok
         * @param $gender
         * @return bool
         */
        public static function isGender($gender)
        {
            if(in_array($gender, ['F', 'M']))
            {
                return true;
            }
            return false;
        }

        /**
         * Verifica data
         * @param $date
         * @param string $mask_in
         * @param null $mask_out
         * @return bool|string
         */
        public static function isDate($date, $mask_in = 'Y-m-d', $mask_out = null)
        {
            if(empty($date))
            {
                return false;
            }

            $var = strlen(trim($date));
            if($var)
            {
                $date = DateTime::createFromFormat($mask_in, $date);
                if(DateTime::getLastErrors()['warning_count'] == 0 and !DateTime::getLastErrors()['error_count'])
                {
                    if($mask_out === null)
                    {
                        $mask_out = $mask_in;
                    }
                    return $date->format($mask_out);
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        /**
         * Verifica data and time
         * @param $date
         * @param string $mascara
         * @return bool|string
         */
        public static function isDateTime($date, $mascara = 'Y-m-d H:i:s')
        {
            if(empty($date))
            {
                return false;
            }

            $var = strlen(trim($date));
            if($var)
            {
                $date = DateTime::createFromFormat($mascara, $date);
                if(DateTime::getLastErrors()['warning_count'] == 0 and !DateTime::getLastErrors()['error_count'])
                {
                    return $date->format($mascara);
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        /**
         * Formata a data mysql para outros padroes
         * @param $date
         * @param string $format
         * @return bool|string
         */
        public static function dateFormat($date, string $format = '')
        {
            if(empty($date))
            {
                return false;
            }

            if(strlen($date) == 19)
            {
                $format = ($format) ? $format : 'd/m/Y H:i:s';
                $date_obj = DateTime::createFromFormat('Y-m-d H:i:s', $date);
            }
            else
            {
                $format = ($format) ? $format : 'd/m/Y';
                $date_obj = DateTime::createFromFormat('Y-m-d', $date);
            }

            if(DateTime::getLastErrors()['warning_count'] == 0 and !DateTime::getLastErrors()['error_count'])
            {
                return $date_obj->format($format);
            }
            else
            {
                return false;
            }
        }

        /**
         * Valida e retorna a data no formato MySQL
         * @param $date
         * @param bool $time_show
         * @return false|string
         */
        public static function dateConvertMysql($date, $time_show = true)
        {
            $date = trim($date);
            $data_array = explode("/", $date);
            $day = @$data_array[0];
            $month = @$data_array[1];
            if(strlen($date) == 19)
            {
                $year = substr(@$data_array[2], 0, 4);
                $time = substr(@$data_array[2], 4, 9);
                $new_date = $year . '-' . $month . '-' . $day . ' ' . $time;
                $date_obj = DateTime::createFromFormat('Y-m-d H:i:s', $new_date);
            }
            else
            {
                $year = @$data_array[2];
                $new_date = $year . '-' . $month . '-' . $day;
                $date_obj = DateTime::createFromFormat('Y-m-d', $new_date);
            }

            if(DateTime::getLastErrors()['warning_count'] == 0 and !DateTime::getLastErrors()['error_count'])
            {
                if($time_show)
                {
                    return $date_obj->format('Y-m-d H:i:s');
                }
                else
                {
                    return $date_obj->format('Y-m-d');
                }

            }
            else
            {
                return false;
            }
        }

        /**
         * Verifica se o email e valido
         * @param $mail
         * @return bool|string
         */
        public static function isMail($mail)
        {
            if (filter_var($mail, FILTER_VALIDATE_EMAIL) === FALSE)
            {
                return false;
            }
            else
            {
                return strtolower($mail);
            }
        }

        /**
         * Verifica se e um phone
         * @param $phone
         * @return bool|string
         */
        public static function isPhone($phone)
        {
            $phone = Utils::clearString($phone);
            if((is_numeric($phone)) AND (strlen($phone) >= 10) AND (strlen($phone) <= 15))
            {
                $validate = $phone;
            }
            else
            {
                $validate = FALSE;
            }
            return $validate;
        }

        /**
         * Acerta o nome do sujeito
         * @param $name
         * @return mixed
         */
        public static function capitalize($name)
        {
            $name = trim($name);
            $de = [' E ', ' De ', ' Da ', ' Das ', ' Do ', ' Dos '];
            $para = [' e ', ' de ', ' da ', ' das ', ' do ', ' dos '];
            $name = ucwords(mb_strtolower($name));
            $name = str_replace($de, $para, $name);
            return $name;
        }

        /**
         * Cartao cripto
         * @param array $value
         * @return string
         */
        public static function creditCardEncrypt($value = [])
        {
            $card = serialize($value);
            return Utils::encrypt($card);
        }

        /**
         * Cartao decripto
         * @param $value
         * @return mixed
         */
        public static function creditCardDecrypt($value)
        {
            $card = @gzuncompress(@base64_decode(@str_pad(@strtr($value, '-_', '+/'), @strlen($value) % 4, '=', STR_PAD_RIGHT)));
            return unserialize($card);
        }

        /**
         * Criptografando dado
         * @param $value
         * @return string
         * Criar varivel de sistema
         * OPENSSL_CONF=D:\apache\conf\openssl.cnf
         * http://php.net/manual/pt_BR/function.openssl-pkey-new.php
         */
        public static function encrypt($value)
        {
            return @rtrim(@strtr(@base64_encode(@gzcompress($value, 9)), '+/', '-_'), '=');
        }

        /**
         * Descriptografando dado
         * @param $value
         * @return string
         */
        public static function decrypt($value)
        {
            return @gzuncompress(@base64_decode(@str_pad(@strtr($value, '-_', '+/'), @strlen($value) % 4, '=', STR_PAD_RIGHT)));
        }

        /**
         * Aplica uma mascara no valor
         * Ex: ###.###.###-## para CPF
         * @param $formato
         * @param $valor
         * @return mixed
         */
        public static function mascara($formato, $valor)
        {
            $search = [' ', '.', '+', '-', '/', '(', ')'];
            $replace = ['', '', '', '', '', '', ''];
            $valor = str_replace($search, $replace, $valor);
            $valor_count = strlen($valor);
            $formato_array = explode("#", $formato);

            $formato_alt = "";
            for($a = 0; $a < $valor_count; $a++)
            {
                $formato_alt .= (string) (isset($formato_array[$a])) ? $formato_array[$a] : '';
                $formato_alt .= '#';
            }

            $mascarado = vsprintf(str_replace("#", "%s", $formato_alt), str_split($valor));
            if($mascarado)
            {
                $output = $mascarado;
            }
            else
            {
                $output = $valor;
            }
            return $output;
        }

        /**
         * Formata a data
         * @param $date
         * @param string $mascara
         * @return bool|string
         */
        public static function dateMask($date, $mascara = 'd/m/Y H:i:s')
        {
            if(empty($date))
            {
                return false;
            }

            $var = strlen(trim($date));
            if($var)
            {
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
                if(DateTime::getLastErrors()['warning_count'] == 0 and !DateTime::getLastErrors()['error_count'])
                {
                    return $date->format($mascara);
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        /**
         * Convert o resulte em algo usavel
         * @param $result
         * @return mixed
         */
        public static function objToArray($result)
        {
            $json = json_encode($result);
            return (array) json_decode($json, true);
        }

        /**
         * Retorna os valores do sistema
         * ultimo script executado
         * @return array|mixed
         */
        public static function getDetailsExec()
        {
            $trace = debug_backtrace();
            $trace = end($trace);
            $trace = self::objToArray($trace);
            $trace = $trace['object'];
            return $trace;
        }

        /**
         * Redirect url, controller
         *
         * [
         *    code => 302,
         *    url => 'http://teste.com.br',
         *    controller => 'Index',
         *    action => 'teste'
         * ],
         * 'dashboard/?teste=1'
         *
         * Code aceitos [
         *    301 => Moved Permanently,
         *    302 => Found,
         *    303 => See Other
         *    307 =>  Temporary Redirect
         * ]
         * @param array $params
         * @param string $return_to
         * @return mixed
         */
        public static function redirect(array $params, string $return_to = '')
        {
            /**
             * Por url
             */
            if(isset($params['url']))
            {
                Session::write('return_to', $return_to);
                $code = (isset($params['code'])) ? $params['code'] : 302;
                $url = $params['url'];
                if(!(strstr($url, 'http://') or strstr($url, 'https://')))
                {
                    $url = __DIR_INDEX__ . substr($url, 1);
                }
                header('location: ' . $url, true, $code);
                die;
            }

            /**
             * Por controller
             */
            $controller = "Src\Controller\\" . $params['controller'] . 'Controller';
            $controller = new $controller();
            $action = $params['action'];
            return $controller->$action();
        }

        /**
         * @param $var
         * @return array|mixed
         */
        public static function escape($var)
        {
            if(is_array($var))
            {
                return array_map(__METHOD__, $var);
            }
            if(!empty($var) && is_string($var))
            {
                return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "`", "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', "\\`", '\\Z'), $var);
            }
            return $var;
        }

        /**
         * Verifica se e um numero
         * @param $numeric
         * @return bool
         */
        public static function isNumeric($numeric)
        {
            if (is_numeric($numeric))
            {
                $validate = TRUE;
            }
            else
            {
                $validate = FALSE;
            }
            return $validate;
        }

        /**
         * Verifica se e um numero inteiro
         * @param $int
         * @return bool
         */
        public static function isInteger($int)
        {
            if (is_int($int))
            {
                $validate = TRUE;
            }
            else
            {
                $validate = FALSE;
            }
            return $validate;
        }

        /**
         * @param $string
         * @return string
         */
        public static function removeAcento($string)
        {
            return preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml|caron);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
        }

        /**
         * Rertorna dados da imagem
         * @param $url
         * @return array|bool
         */
        public static function isImage($url)
        {
            $img_info = @getimagesize($url);
            if($img_info)
            {
                switch ($img_info[2])
                {
                    case 1:
                        $img_type = 'gif';
                        break;
                    case 2:
                        $img_type = 'jpg';
                        break;
                    case 3:
                        $img_type = 'png';
                        break;
                    case 4:
                        $img_type = 'swf';
                        break;
                    case 5:
                        $img_type = 'psd';
                        break;
                    case 6:
                        $img_type = 'bmp';
                        break;
                    case 7:
                        $img_type = 'tiff'; // intel byte order
                        break;
                    case 8:
                        $img_type = 'tiff'; // motorola byte order
                        break;
                    case 9:
                        $img_type = 'jpc';
                        break;
                    case 10:
                        $img_type = 'jp2';
                        break;
                    case 11:
                        $img_type = 'jpx';
                        break;
                    case 12:
                        $img_type = 'jb2';
                        break;
                    case 13:
                        $img_type = 'swc';
                        break;
                    case 14:
                        $img_type = 'iff';
                        break;
                    case 15:
                        $img_type = 'wbmp';
                        break;
                    case 16:
                        $img_type = 'xbm';
                        break;

                    default:
                        $img_type = 'xxx';
                }

                return [
                    'url' => $url,
                    'width' => $img_info[0],
                    'height' => $img_info[1],
                    'ext' => $img_type,
                    'bits' => $img_info['bits'],
                    'mime' => $img_info['mime']
                ];
            }
            else
            {
                return false;
            }
        }

        /**
         * Valida se a url é valida
         * @param $url
         * @return bool
         */
        public static function isUrl($url)
        {
            $options = array(
                'http' => array(
                    'method'  => 'GET',
                    'ignore_errors' => true,
                    'timeout' => 5
                ),
                'ssl' => [
                    //'cafile' => "/etc/ssl/certs/ca-certificates.crt",
                    'verify_peer' => false,
                    'verify_peer_name' => false
                ]
            );

            $context  = stream_context_create($options);
            $result = @file_get_contents($url, false, $context);
            $header = (isset($http_response_header)) ? $http_response_header : [];
            if( count($header) and ($header[0] == 'HTTP/1.1 200 OK' or $header[0] == 'HTTP/1.0 302 Found'))
            {
                $check = true;
            }
            else
            {
                $check = false;
            }
            return $check;
        }

        /**
         * Verifica se o acesso esta sendo feito pelo shell
         * se nao for, exibe erro e para
         */
        public static function isShell()
        {
            if(!$GLOBALS['shell'])
            {
                echo __("Access only allowed through the shell!");
                die;
            }
        }

        /**
         * Valida user name
         * @param string $username
         * @param int $min
         * @param int $max
         * @return bool
         */
        public static function usernameRule(string $username, int $min = 4, int $max = 20)
        {
            $pattern = "/^[a-z]{1}[a-z0-9._]{" . ($min - 1) . "," . ($max - 1) . "}$/";
            if(preg_match($pattern, $username))
            {
                return true;
            }
            return false;
        }

        /**
         * Valida Fullname
         * @param string $fullname
         * @param int $min
         * @param int $max
         * @return bool
         */
        public static function fullnameRule(string $fullname , int $min = 0, int $max = 0)
        {
            $fullname_len = strlen(trim($fullname));
            if ($min and $max)
            {
                if(!($fullname_len >= $min and $fullname_len <= $max)) return false;
            }
            elseif ($min)
            {
                if(!($fullname_len >= $min)) return false;
            }
            elseif ($max)
            {
                if(!($fullname_len <= $max)) return false;
            }
            else
            {
                // Vida que segue
            }
            $pattern = "/^(?:[\u00c0-\u01ffa-zA-Z'-]){3,}(?:\s[\u00c0-\u01ffa-zA-Z'-]{1,})+$/";
            if(preg_match($pattern, $fullname))
            {
                return true;
            }
            return false;
        }

        /**
         * Valida name
         * @param string $name
         * @param int $min
         * @param int $max
         * @return bool
         */
        public static function nameRule(string $name , int $min = 0, int $max = 0)
        {
            $name_len = strlen(trim($name));
            if ($min and $max)
            {
                if(!($name_len >= $min and $name_len <= $max)) return false;
            }
            elseif ($min)
            {
                if(!($name_len >= $min)) return false;
            }
            elseif ($max)
            {
                if(!($name_len <= $max)) return false;
            }
            else
            {
                // Vida que segue
            }

            $pattern = "/^(?:[\u00c0-\u01ffa-zA-Z '-]{3,})$/";
            if(preg_match($pattern, $name))
            {
                return true;
            }

            return false;
        }

        /**
         * Para configurar password
         * @param $pass
         * @param int $size
         * @param int $rule
         * @return array
         */
        public static function passwordRules($pass, $size = 6, $rule = 1, $max = 20)
        {
            $regex_options = [
                1 => [
                    'regex' => "(.{" . $size . "})",
                    'description' => __("Minimum and maximum number of characters") . " (" . $size . " - " . $max . ")"
                ],
                2 => [
                    'regex' => "(?=(?:.*[a-z]){1,})",
                    'description' => __("At least one lower case letter")
                ],
                3 => [
                    'regex' => "(?=(?:.*[A-Z]){1,})",
                    'description' => __("At least one capital letter")
                ],
                4 => [
                    'regex' => "(?=(?:.*\d){1,})",
                    'description' => __("At least one number")
                ],
                5 => [
                    'regex' => "(?=(?:.*[!@#$%^&*()\-_=+{};:,<.>]){1,})",
                    'description' => __("At least one special character")
                ]
            ];

            switch ($rule)
            {
                case 1:
                    $regex = $regex_options[1]['regex'];
                    $description = $regex_options[1]['description'];
                    break;
                case 2:
                    $regex = $regex_options[2]['regex'] . $regex_options[1]['regex'];
                    $description = $regex_options[1]['description'] . "\n" . $regex_options[2]['description'];
                    break;
                case 3:
                    $regex = $regex_options[2]['regex']. $regex_options[3]['regex'] . $regex_options[1]['regex'];
                    $description = $regex_options[1]['description'] . "\n" . $regex_options[2]['description'] . "\n" . $regex_options[3]['description'];
                    break;
                case 4:
                    $regex = $regex_options[2]['regex'] . $regex_options[3]['regex'] . $regex_options[4]['regex'] . $regex_options[1]['regex'];
                    $description = $regex_options[1]['description'] . "\n" . $regex_options[2]['description'] . "\n" . $regex_options[3]['description'] . "\n" . $regex_options[4]['description'];
                    break;
                case 5:
                    $regex = $regex_options[2]['regex'] . $regex_options[3]['regex'] . $regex_options[4]['regex'] . $regex_options[5]['regex'] . $regex_options[1]['regex'];
                    $description = $regex_options[1]['description'] . "\n" . $regex_options[2]['description'] . "\n" . $regex_options[3]['description'] . "\n" . $regex_options[4]['description'] . "\n" . $regex_options[5]['description'];
                    break;
                default:
                    $regex = $regex_options[1]['regex'];
                    $description = $regex_options[1]['description'];
            }

            if (preg_match("/" . $regex . "/", $pass) and strlen($pass) <= $max)
            {
                $check = [
                    'status' => true,
                    'description' => __('Meets requirements')
                ];
            }
            else
            {
                $check = [
                    'status' => false,
                    'description' => $description
                ];
            }

            return $check;
        }

        /**
         * Hash para a senha
         * @param $string
         * @return string
         */
        public static function hash($string)
        {
            return sha1(Config::vars('salt') . $string);
        }

        /**
         * Token de autenticacao
         * @param $user
         * @return string
         */
        public static function token($user)
        {
            return sha1(Config::vars('salt') . date('Y-m-d H:i:s') . $user);
        }

        /**
         * Salva log da query que rodou
         * @param string $query
         * @param array $bind
         * @param string $identifier
         */
        public static function queryDecode(string $query, array $bind, string $identifier = ':')
        {
            if(Config::vars('debug'))
            {
                if(Config::vars('php.query_log'))
                {
                    foreach($bind as $key => $value)
                    {
                        if(!(strpos($key, ':') === false))
                        {
                            $identifier_str = '';
                        }
                        else
                        {
                            $identifier_str = $identifier;
                        }
                        $value = gettype($value) === 'string' ? "'" . $value . "'" : $value;
                        $query = str_replace($identifier_str . $key, $value, $query);
                    }

                    $log = fopen(Config::vars('php.query_log_file'), "a+");
                    $text = "--------------------------------------------------------------------------------\n";
                    $text .= "Date: " . date('Y-m-d H:i:s') . "\n";
                    $text .= "Query: " . $query . "\n";
                    $text .= "--------------------------------------------------------------------------------\n\n";

                    fwrite($log, $text);
                    fclose($log);
                }
            }
        }

        /**
         * Retorna a url
         * @param bool $use_forwarded_host
         * @return string
         */
        public static function urlRoot(bool $use_forwarded_host = false)
        {
            $s = $_SERVER;
            $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
            $sp       = strtolower( $s['SERVER_PROTOCOL'] );
            $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
            $port     = $s['SERVER_PORT'];
            $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
            $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
            $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
            return $protocol . '://' . $host;
        }

        /**
         * Retorna a url completa
         * @param bool $use_forwarded_host
         * @return string
         */
        public static function urlFull($use_forwarded_host = false )
        {
            return self::urlRoot($use_forwarded_host) . $_SERVER['REQUEST_URI'];
        }

        /**
         * Monta range para excel
         * @param array $range
         * @return array
         */
        public static function rangeExcel($range = array('A', 'Z'))
        {
            $values = [];
            while ($range[0] !== $range[1])
            {
                $values[] = $range[0]++;
            }
            return array_merge($values, array_splice($range, 0, 1));
        }

        /**
         * @param $type
         * @return string
         */
        public static function columnType($type)
        {
            switch ($type['native_type'])
            {
                case 'LONG':
                case 'TINY':
                    $type = 'int';
                break;
                case 'VAR_STRING';
                    $type = 'string';
                break;
                case 'BLOB':
                case 'STRING ':
                    $type = 'text';
                break;
                case 'TIMESTAMP':
                    $type = 'datetime';
                break;
                case 'NEWDECIMAL':
                    if($type['precision'] == 2)
                    {
                        $type = 'moeda';
                    }
                    else
                    {
                        $type = 'text';
                    }
                break;

                default:
                    $type = 'text';
            }
            return $type;
        }

        /**
         * Retorna nome da coluna pelo id
         * @param $n
         * @return string
         */
        public static function nameExcelColumns($n)
        {
            for($r = ""; $n >= 0; $n = intval($n / 26) - 1)
            {
                $r = chr($n%26 + 0x41) . $r;
            }

            return $r;
        }

        /**
         * Para o erro do str_pad
         * @param $input
         * @param $pad_length
         * @param string $pad_string
         * @param int $pad_type
         * @param string $encoding
         * @return string
         */
        public static function mb_str_pad( $input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT, $encoding = "UTF-8")
        {
            $diff = strlen( $input ) - mb_strlen($input, $encoding);
            return str_pad( $input, $pad_length + $diff, $pad_string, $pad_type );
        }

        /**
         * Retorna detales do browser
         * https://www.php.net/manual/pt_BR/function.get-browser.php
         * http://browscap.org/
         * @return array|bool
         */
        public static function getBrowser()
        {
            $browser = (array) @get_browser();
            return ($browser) ? $browser : false;
        }

        /**
         * Metodo de request
         * @return bool
         */
        public static function isPost()
        {
            return ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;
        }

        /**
         * Metodo de request
         * @return bool
         */
        public static function isGet()
        {
            return ($_SERVER['REQUEST_METHOD'] == 'GET') ? true : false;
        }

        /**
         * Retorno o ip do cliente
         * @return mixed
         */
        public static function getClientIp()
        {
            if(isset($_SERVER['HTTP_CLIENT_IP']))
            {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
            elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
                $ip = @$_SERVER['REMOTE_ADDR'];
            }
            return  $ip;
        }

        /**
         * Grava na sessao a mensagem para o front
         * @param $type
         * @param $message
         * @param string $width
         */
        public static function setMessage($type, $message, $width = '40vw')
        {
            Session::write('message', [
                'class' => $type,
                'message' => $message,
                'width' => $width
            ]);
        }

        /**
         * Grava na sessao a dados do form
         */
        public static function setFormData($name, $data)
        {
            Session::write('form_data', [$name => $data]);
        }

        /**
         * Is Ajax
         * @return bool
         */
        public static function isAjax()
        {
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            {
                return true;
            }

            return false;
        }

        /**
         * Valida campo
         * retorna detalhe do erro
         * @param $value
         * @param array $validation
         * @return mixed
         */
        public static function validate($value, array $validation)
        {
            switch ($validation['validate'])
            {
                case 'none':
                    // No validate
                break;

                case 'username':
                    if(!self::usernameRule($value, $validation['options']['min'], $validation['options']['max']))
                    {
                        return __('Username does not meet requirements');
                    }
                break;

                case 'mail':
                    if(strlen(trim($value)) > $validation['options']['max']) return __('Invalid email');
                    if(self::isMail($value) === false)
                    {
                        return __('Invalid email');
                    }
                break;

                case 'fullname':
                    if(!self::fullnameRule($value, $validation['options']['min'], $validation['options']['max']))
                    {
                        return __('Full name does not meet requirements');
                    }
                break;

                case 'name':
                    if(!self::nameRule($value, $validation['options']['min'], $validation['options']['max']))
                    {
                        return __('Name does not meet requirements');
                    }
                break;

                case 'gender':
                    if(!self::isGender($value))
                    {
                        return __('Gender does not meet requirements');
                    }
                break;

                case 'password':
                    $check = self::passwordRules($value, $validation['options']['min'], $validation['options']['rule'], $validation['options']['max']);
                    if($check['status'] === false)
                    {
                        return __('Password does not meet requirements') . ":\n" . $check['description'];
                    }
                break;

                case 'cnpj':
                    if(self::isCnpj($value) === false)
                    {
                        return __('CNPJ does not meet requirements');
                    }
                break;

                case 'cpf':
                    if(self::isCpf($value) === false)
                    {
                        return __('CPF does not meet requirements');
                    }
                break;

                case 'cellphone':
                    $value = self::clearString($value);
                    if(strlen($value) != $validation['options']['len'] and !Utils::isNumeric($value))
                    {
                        return __('Cell phone does not meet requirements');
                    }
                break;

                case 'zip':
                    $value = self::clearString($value);
                    if(strlen($value) != $validation['options']['len'] and !Utils::isNumeric($value))
                    {
                        return __('Zip code does not meet requirements');
                    }
                break;

                case 'text-size':
                    $value =  strlen(trim($value));
                    $min = $validation['options']['min'];
                    $max = $validation['options']['max'];

                    $erro = false;

                    if ($min and $max)
                    {
                        if(!($value >= $min and $value <= $max)) $erro = true;
                    }
                    elseif ($min)
                    {
                        if(!($value >= $min)) $erro = true;
                    }
                    elseif ($max)
                    {
                        if(!($value <= $max)) $erro = true;
                    }
                    else
                    {
                        // Vida que segue
                    }

                    if($erro)
                    {
                        return __('Field accepted from :min to :max characters', [
                            ':min' => $min,
                            ':max' => $max
                        ]);
                    }
                    return true;
                break;

                case 'numeric':
                    if(self::isNumeric($value) === false)
                    {
                        return __('Value is not numeric');
                    }
                break;

                case 'date':
                    if(self::isDate($value, $validation['options']['format']) === false)
                    {
                        return __('Value is not valid date');
                    }
                break;

                case 'gender':
                    if(!in_array($value, ['M', 'F']))
                    {
                        return __('Gender is not valid');
                    }
                break;

                default:
                    return __('Validation not configured');
            }

            return true;
        }

        /**
         * Gera uma chave qualquer
         * @param int $dig
         * @return string
         */
        public static function genKey($dig = 32)
        {
            $chars = array("a", "A", "b", "B", "c", "C", "d", "D", "e", "E", "f", "F", "g", "G", "h", "H", "i", "I", "j", "J", "k", "K", "l", "L", "m", "M", "n", "N", "o", "O", "p", "P", "q", "Q", "r", "R", "s", "S", "t", "T", "u", "U", "v", "V", "w", "W", "x", "X", "y", "Y", "z", "Z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
            $max_elements = count($chars) - 1;
            $newpw = $chars[rand(0, $max_elements)];

            if ($dig < 4) {
                $dig = 4;
            }

            for ($a = 1; $a < $dig; $a++) {
                $newpw .= $chars[rand(0, $max_elements)];
            }
            return $newpw;
        }

        /**
         * Transforma palavra em slug
         */
        public static function makeSlug($text)
        {
            return strtolower(str_replace(' ', '-', self::removeAcento($text)));
        }

        /**
         * Controller esta no profile
         * @param $controller
         * @return bool
         */
        public static function profileController(string $controller)
        {
            $profile = Session::read('Auth')['profile'];
            $controller = strtolower($controller);
            if(key_exists($controller, $profile))
            {
                return true;
            }
            return false;
        }

        /**
         * Controller esta no profile
         * @param $controller
         * @param $action
         * @return bool
         */
        public static function profileAction(string $controller, string $action)
        {
            $profile = Session::read('Auth')['profile'];
            $controller = strtolower($controller);
            $action = strtolower($action);
            if(key_exists($controller, $profile))
            {
                if(key_exists($action, $profile[$controller]))
                {
                    return true;
                }
            }
            return false;
        }

        /**
         * Controller esta no profile
         * @param $controller
         * @param $action
         * @param $sub
         * @return bool
         */
        public static function profileActionSub(string $controller, string $action, $sub)
        {
            $profile = Session::read('Auth')['profile'];
            $controller = strtolower($controller);
            $action = strtolower($action);
            if(key_exists($controller, $profile))
            {
                if(key_exists($action, $profile[$controller]))
                {
                    if(in_array($sub, $profile[$controller][$action]))
                    {
                        return true;
                    }
                }
            }
            return false;
        }
    }
}