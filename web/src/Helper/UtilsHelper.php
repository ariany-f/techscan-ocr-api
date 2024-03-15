<?php

/**
 * Fidelidade
 * @author Ariany Ferreira <ariany.ferreira@tecnoprog.com.br>
 * @copyright  Tecnoprog © 2019, Tecnoprog Informatica e Eletronica LTDA - ME.
 */

namespace src\Helper {

    use Src\Controller\Component\UtilsComponent;
    use Tecno\Lib\Session;
    use Config\Config;
    use Src\App;
    use Tecno\Lib\Utils;
    use DateTime;
    use Src\Controller\Component\Digi5Component;

    class UtilsHelper
    {

        /**
         * Verifica se é mobile
         */
        public static function isMobile()
        {
            $useragent = $_SERVER['HTTP_USER_AGENT'];

            $mobile = false;
            if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {

                $mobile = true;
            }

            return $mobile;
        }
        
        function verificarString($string, $array) {
            // Usa array_reduce() para verificar se algum elemento do array está presente na string
            return array_reduce($array, function($carry, $elemento) use ($string) {
                // Verifica se o elemento está presente na string
                return $carry && strpos($string, $elemento) === false;
            }, true);
        }

        /**
         * Caso haja mensagem setada na sessão
         */
        public static function readMessage()
        {
            $return = '';
            $message = Session::read('message');

            if ($message and isset($message['message'])) {
                $return = "<script>" .
                    "$(document).ready(function(){" .
                    "$.alert({" .
                    "boxWidth : '" . $message['width'] . "'," .
                    "title: '" . "'," .
                    "theme: 'material'," .
                    "useBootstrap: false," .
                    "type:'" . (($message['class'] == 'error') ? 'red' : 'green') . "'," .
                    "content:'" . str_replace("\n", "<br/>", $message['message']) . "'," .
                    "})" .
                    "});" .
                    "</script>";
                Session::del('message');
            }
            return $return;
        }

        /**
         * Gênero
         */
        public static function gender($letter)
        {
            switch ($letter) {
                case 'M':
                    return __('Male');
                    break;

                case 'F':
                    return __('Female');
                    break;

                default:
                    return false;
            }
        }

        /**
         * Verifica se há dados do formulário anteriormente preenchidos
         */
        public static function readFormData()
        {
            $return = '';
            $form_data = Session::read('form_data');

            if ($form_data) {
                $input = null;
                $form_name = array_keys($form_data)[0];
                if (!empty($form_name)) {
                    foreach ($form_data[$form_name] as $k => $data) {
                        if (!empty($data)) {
                            $input .= "$('input[name=\"" . $k . "\"]').val('" . $data . "');";
                        }
                    }

                    $return = "<script>" .
                        "$(document).ready(function(){" .
                        "if($('form." . $form_name . "').length){" .
                        $input .
                        "}" .
                        "});" .
                        "</script>";
                }

                Session::del('form_data');
            }
            return $return;
        }

        /**
         * Format Money according to location
         */
        public static function moneyFormat($formato, $valor)
        {
            setlocale(LC_MONETARY, Session::read('lang') ?? Config::vars('lang') ?? 'pt_BR');
            if (function_exists('money_format')) {
                return money_format($formato, $valor);
            }

            if (setlocale(LC_MONETARY, 0) == 'C') {
                return number_format($valor, 2);
            }

            $locale = localeconv();
            $regex = '/^' .             // Inicio da Expressao
                '%' .              // Caractere %
                '(?:' .            // Inicio das Flags opcionais
                '\=([\w\040])' .   // Flag =f
                '|' .
                '([\^])' .         // Flag ^
                '|' .
                '(\+|\()' .        // Flag + ou (
                '|' .
                '(!)' .            // Flag !
                '|' .
                '(-)' .            // Flag -
                ')*' .             // Fim das flags opcionais
                '(?:([\d]+)?)' .   // W  Largura de campos
                '(?:#([\d]+))?' .  // #n Precisao esquerda
                '(?:\.([\d]+))?' . // .p Precisao direita
                '([in%])' .        // Caractere de conversao
                '$/';             // Fim da Expressao

            if (!preg_match($regex, $formato, $matches)) {
                trigger_error(__('Invalid format:') . $formato, E_USER_WARNING);
                return $valor;
            }

            $opcoes = array(
                'preenchimento'   => ($matches[1] !== '') ? $matches[1] : ' ',
                'nao_agrupar'     => ($matches[2] == '^'),
                'usar_sinal'      => ($matches[3] == '+'),
                'usar_parenteses' => ($matches[3] == '('),
                'ignorar_simbolo' => ($matches[4] == '!'),
                'alinhamento_esq' => ($matches[5] == '-'),
                'largura_campo'   => ($matches[6] !== '') ? (int)$matches[6] : 0,
                'precisao_esq'    => ($matches[7] !== '') ? (int)$matches[7] : false,
                'precisao_dir'    => ($matches[8] !== '') ? (int)$matches[8] : $locale['int_frac_digits'],
                'conversao'       => $matches[9]
            );

            if ($opcoes['usar_sinal'] && $locale['n_sign_posn'] == 0) {
                $locale['n_sign_posn'] = 1;
            } elseif ($opcoes['usar_parenteses']) {
                $locale['n_sign_posn'] = 0;
            }
            if ($opcoes['precisao_dir']) {
                $locale['frac_digits'] = $opcoes['precisao_dir'];
            }
            if ($opcoes['nao_agrupar']) {
                $locale['mon_thousands_sep'] = '';
            }

            $tipo_sinal = $valor >= 0 ? 'p' : 'n';
            if ($opcoes['ignorar_simbolo']) {
                $simbolo = '';
            } else {
                $simbolo = $opcoes['conversao'] == 'n' ? $locale['currency_symbol'] : $locale['int_curr_symbol'];
            }

            $numero = number_format(abs($valor), $locale['frac_digits'], $locale['mon_decimal_point'], $locale['mon_thousands_sep']);
            $sinal = $valor >= 0 ? $locale['positive_sign'] : $locale['negative_sign'];
            $simbolo_antes = $locale[$tipo_sinal . '_cs_precedes'];

            $espaco1 = $locale[$tipo_sinal . '_sep_by_space'] == 1 ? ' ' : '';
            $espaco2 = $locale[$tipo_sinal . '_sep_by_space'] == 2 ? ' ' : '';

            $formatado = '';
            switch ($locale[$tipo_sinal . '_sign_posn']) {
                case 0:
                    if ($simbolo_antes) {
                        $formatado = '(' . $simbolo . $espaco1 . $numero . ')';
                    } else {
                        $formatado = '(' . $numero . $espaco1 . $simbolo . ')';
                    }
                    break;

                case 1:
                    if ($simbolo_antes) {
                        $formatado = $sinal . $espaco2 . $simbolo . $espaco1 . $numero;
                    } else {
                        $formatado = $sinal . $numero . $espaco1 . $simbolo;
                    }
                    break;

                case 2:
                    if ($simbolo_antes) {
                        $formatado = $simbolo . $espaco1 . $numero . $sinal;
                    } else {
                        $formatado = $numero . $espaco1 . $simbolo . $espaco2 . $sinal;
                    }
                    break;

                case 3:
                    if ($simbolo_antes) {
                        $formatado = $sinal . $espaco2 . $simbolo . $espaco1 . $numero;
                    } else {
                        $formatado = $numero . $espaco1 . $sinal . $espaco2 . $simbolo;
                    }
                    break;

                case 4:
                    if ($simbolo_antes) {
                        $formatado = $simbolo . $espaco2 . $sinal . $espaco1 . $numero;
                    } else {
                        $formatado = $numero . $espaco1 . $simbolo . $espaco2 . $sinal;
                    }
                    break;
            }

            if ($opcoes['largura_campo'] > 0 && strlen($formatado) < $opcoes['largura_campo']) {
                $alinhamento = $opcoes['alinhamento_esq'] ? STR_PAD_RIGHT : STR_PAD_LEFT;
                $formatado = str_pad($formatado, $opcoes['largura_campo'], $opcoes['preenchimento'], $alinhamento);
            }

            return $formatado;
        }

        public static function formatBrand($brand)
        {
            switch ($brand) {
                case 'master':
                case 'mastercard':
                case 'MasterCard':
                    return 'MasterCard';
                case 'visa':
                case 'Visa':
                    return 'Visa';
                case "amex":
                case "Amex":
                    return "Amex";
                case "elo":
                case "Elo":
                    return "Elo";
                case "diners":
                case "Diners":
                    return "Diners";
                case "discover":
                case "Discover":
                    return "Discover";
                case "jcb":
                case "Jcb":
                    return "JCB";
                case "aura":
                case "Aura":
                    return "Aura";
                case "Sorocred":
                case "sorocred":
                    return "Sorocred";
                case "qigog":
                    return "QiGOG Corp";
                default:
                    return $brand;
            }
        }

        public static function formatCardNumberMask($card)
        {
            $card = substr($card, 0, 4) . "********" . substr($card, 12, 4);

            return $card;
        }

        public static function search($array, $key, $value)
        {
            $results = array();

            if (is_array($array)) {
                if (isset($array[$key]) && $array[$key] == $value) {
                    $results[] = $array;
                }

                foreach ($array as $subarray) {
                    $results = array_merge($results, search($subarray, $key, $value));
                }
            }

            return $results;
        }

        /**
         * Verifica se há usuário logado
         */
        public static function userLogged()
        {
            $user_logged = false;

            if (isset($_SESSION['Auth']) && !empty($_SESSION['Auth'])) {
                $user_logged = true;
            }

            return $user_logged;
        }

        /**
         * @param null $startMothn
         * @param string $idOrName
         * @param bool $leadingZero
         * @return mixed
         */
        public static function allMonthsStartedFrom($startMothn = null, $idOrName = "id", $leadingZero = true)
        {
            if (empty($startMothn)) {
                $startMothn = date('M');
            }
            for ($i = $startMothn; $i <= 12; $i++) {
                $format = ($leadingZero) ? "%02d" : "%d";
                $months[$i] = sprintf($format, $i);
            }
            return $months;
        }

        /**
         * @param int $addYears
         * @return mixed
         */
        public static function creditCargValidThruYearRange($addYears = 30)
        {
            for ($i = (int) date('Y'); $i <= ((int) date('Y') + $addYears); $i++) {
                $validYears[$i] = $i;
            }
            return $validYears;
        }

        /**
         * Completa o numero com Zeros a esquerda
         * @param $valor
         * @param int $size
         * @return string
         *
         */
        public static function zeroLeft($valor, $size = 1)
        {
            return str_pad($valor, $size, "0", STR_PAD_LEFT);
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
            for ($a = 0; $a < $valor_count; $a++) {
                $formato_alt .= (string) $formato_array[$a];
                $formato_alt .= '#';
            }

            $mascarado = vsprintf(str_replace("#", "%s", $formato_alt), str_split($valor));
            if ($mascarado) {
                $output = $mascarado;
            } else {
                $output = $valor;
            }
            return $output;
        }

        /**
         * Retorna a data completa formatada
         */
        public static function fullDate(string $date, string $format = "d/m/Y", $time = "H:i", $between = ' \à\s ')
        {
            $date = strtotime($date);
            if (!empty($time)) {
                $format .= $between . $time;
            }
            return date($format, $date);
        }

        /**
         * @param $value
         * @param string $prefix
         * @param string $location
         * @return string
         */
        public static function currency($value, $prefix = 'R$', $location = 'BR')
        {
            return $prefix . ' ' . number_format($value, 2, ',', '.');
        }

        /**
         * Converte a data da agenda para a data padrao
         * @param $date
         * @return string
         */
        public static function dateFormatAgenda($date)
        {
            $date_obj = DateTime::createFromFormat('j/m/Y h:i A', $date);
            $date_new = $date_obj->format('Y-m-d H:i');
            return $date_new;
        }

        /**
         * Remover acento de string
         */
        public static function removerAcento($string)
        {
            return preg_replace(["/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"], explode(" ", "a A e E i I o O u U n N"), $string);
        }
        

        public static function percentage($parcial, $total)
        {
            return round(100 - ($parcial / $total * 100), 2);
        }
    }
}
