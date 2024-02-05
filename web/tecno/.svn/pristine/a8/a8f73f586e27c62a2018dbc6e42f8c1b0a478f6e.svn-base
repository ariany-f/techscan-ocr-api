<?php
/**
 * Framework Tecno
 * @author Anderson Carlos <anderson.carlos@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace Tecno\Lib {

    use Config\Config;

    class Request {

        /**
         * Faz request em uma url
         * se response vazio retorna chave curl_errors
         * @param string $url
         * @param array $header
         * @param string $method
         * @param string $params
         * @param string $log_file
         * @return mixed
         */
        public static function send(string $url, array $header, string $method, string $params, string $log_file = 'request_send.log', $timeout = 5)
        {
            /**
             * Para saber em que modo o app esta;
             * Se esta com debug ativo
             */
            $service_mode = Config::vars('service_mode');
            $debug = Config::vars('debug');

            /**
             * Verificar host
             * Verificar certificado
             */
            $security = 1;
            if($service_mode == 'dev')
            {
                $security = 0;
            }

            $method = strtoupper($method);
            $header_mod = [];
            array_push($header_mod, "User-Agent: Tecnoprog Framework");
            foreach ($header as $key => $value)
            {
                array_push($header_mod, $key . ':' . $value);
            }
            array_push($header_mod, 'Content-Length: ' . strlen($params));

            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch,CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch,CURLOPT_POST,($method == 'GET') ? false : true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, $security);
            curl_setopt($ch,CURLOPT_HTTPHEADER, $header_mod);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch,CURLOPT_HEADER, true);
            curl_setopt($ch,CURLOPT_VERBOSE, true);
            $response = @curl_exec($ch);
            $error = @curl_error($ch);
            $getinfo = @curl_getinfo($ch);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header_arr = explode("\r\n", substr($response, 0, $header_size));
            $body = substr($response, $header_size);
            @curl_close($ch);

            /**
             * Prepara hedear de response
             */
            $header = [];
            foreach ($header_arr as $key => $value)
            {
                if($key == 0)
                {
                    $value = @explode(" ", $value);
                    $header['Version'] = trim(@$value[0]);
                    $header['StatusCode'] = trim(@$value[1]);
                }
                else
                {
                    if($value)
                    {
                        $value = @explode(":", @$value);
                        @$header[trim(@$value[0])] = trim(@$value[1]);
                    }
                }
            }

            /**
             * Array para o log e parcial de saida
             */
            $output = [
                'request' => [
                    'url' => $url,
                    'headers' => $header_mod,
                    'method' => $method,
                    'params' => $params,
                ],
                'response' => [
                    'headers' => $header,
                    'infos' => $getinfo,
                    'body' => $body,
                    'errors' => $error
                ],
            ];

            /**
             * Salva log
             */
            if($debug)
            {
                $status = debug_backtrace();
                $log = fopen(__DIR_ROOT__ . "/tmp/logs/" . $log_file, "a+");
                fwrite($log, date('Y-m-d H:i:s') . ' - ' . microtime(true) . "\n" . print_r(['file' => $status[0]['file'], 'line' => $status[0]['line'], 'data' => $output], true) . "\n\n");
                fclose($log);
            }
            return $output['response'];
        }
    }
}