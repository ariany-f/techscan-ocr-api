<?php 

require_once('../vendor/econea/nusoap/src/nusoap.php');


    function convertToXml($object) {
      
        $xml = '<IdPassage>' . $object['id'] . '</IdPassage>';
        $xml .= '<IdGate>' . $object['gate'] . '</IdGate>';
        $xml .= '<Date>' . $object['created_at'] . '</Date>';
        $xml .= '<Validated>' . (($object['status'] == 'Aprovada' || $object['status'] == 'Erro') ? 'true' : 'false'). '</Validated>';
        $xml .= '<Direction>' . $object['direction'] . '</Direction>';

        $xml_plate = '<ListPlate>';
        $xml_container = '<ListContainer>';
        $count_plates = [];
        $count_containers = [];
        foreach ($object['list'] as $event) {
            if(isset($event['plate']) && !empty($event['plate']))
            {
                $count_plates[] = $event;
                $xml_plate .= '<DTOPlate>';
                $xml_plate .= '<Id>' . $event['id'] . '</Id>';
                $xml_plate .= '<PlateNumber>' . $event['plate'] . '</PlateNumber>';
                $xml_plate .= '<ImagePath>' . $event['images'] . '</ImagePath>';
                // Adicione outras tags aqui conforme necessário
                $xml_plate .= '</DTOPlate>';
            }
            else if(isset($event['container']) && !empty($event['container']))
            {
                $count_containers[] = $event;
                $xml_container .= '<DTOContainer>';
                $xml_container .= '<Id>' . $event['id'] . '</Id>';
                $xml_container .= '<ContainerNumber>' . $event['container'] . '</ContainerNumber>';
                $xml_container .= '<ImagePath>' . $event['images'] . '</ImagePath>';
                // Adicione outras tags aqui conforme necessário
                $xml_container .= '</DTOContainer>';
            }
        }
        if( $xml_plate !=='<ListPlate>')
        {
            for($i=0; $i < count($count_plates); $i++)
            {
                if($i > 0)
                {
                    $that = $i+1;
                    $xml .= "<Plate$that>" . ($count_plates[$i]['plate'] ?? ''). "</Plate$that>";
                }
                else
                {
                    $xml .= '<Plate>' . ($count_plates[$i]['plate'] ?? ''). '</Plate>';
                }
            }
        }
        if($xml_container !== '<ListContainer>')
        {
            for($f=0; $f < count($count_containers); $f++)
            {
                if($f > 0)
                {
                    $that = $f+1;
                    $xml .= "<Container$that>" . ($count_containers[$f]['container'] ?? ''). "</Container$that>";
                }
                else
                {
                    $xml .= '<Container>' . ($count_containers[$f]['container'] ?? ''). "</Container>";
                }
            }
        }

        if( $xml_plate !=='<ListPlate>')
        {
            $xml_plate .= '</ListPlate>';
            $xml .= $xml_plate;
        }
        if( $xml_container !==  '<ListContainer>')
        {
            $xml_container .= '</ListContainer>';
            $xml .= $xml_container;
        }

        return $xml;
    }

    function GetLastPassageDetail($gate, $direction, $generateImages, $AssertDigS) {

        if(!in_array($direction, ['Entry', 'Exit', 'None']))
        {
            return new soap_fault("soap: Client",  "", "Parâmetros inválidos", array("error" => array("code" => "403", "detail" => "Parâmetro direction inválido")));
        }
        // Verificar se é uma string
        if (is_string($generateImages)) {
            // Converter para booleano
            $generateImages = filter_var($generateImages, FILTER_VALIDATE_BOOLEAN);
        }

        if(!is_bool($generateImages))
        {
            return new soap_fault("soap: Client",  "", "Parâmetros inválidos", array("error" => array("code" => "403", "detail" => "Parâmetro generateImages inválido")));
        }

        // URL para a qual você deseja enviar a requisição
        $url = $_SERVER['HTTP_HOST'] . '/api/web/public/ultima-passagem/';

        $postData = json_encode(array(
            'gate' => $gate,
            'direction' => $direction!== '' ? ($direction == 'Entry' ? '1' : ($direction == 'None' ? '3' : '2')) : '',
            'generateImages' => $generateImages,
            'AssertDigS' => $AssertDigS
        ));

        // Inicializa a sessão cURL
        $curl = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Retorna o resultado como uma string em vez de imprimi-lo na tela
        curl_setopt($curl, CURLOPT_POST, true); // Define o método da requisição como POST
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData); // Define os dados a serem enviados no corpo da requisição

        // Executa a requisição e armazena a resposta
        $response = curl_exec($curl);

        // Verifica se ocorreu algum erro durante a requisição
        if(curl_errno($curl)) {

            return new soap_fault("soap: Server",  "", "Erro Inesperado", array("error" => array("code" => "500", "detail" => 'Erro na requisição cURL: ' . curl_error($curl))));
        }

        // Fecha a sessão cURL
        curl_close($curl);

        $data = json_decode($response, true);

        return isset($data['data']) ? convertToXml($data['data']) : new soap_fault("soap: Client",  "", "Busca Inválida", array("error" => array("code" => "404", "detail" => 'Sua busca não teve retornos')));
    }

$server = new soap_server();
$server->soap_defencoding = 'UTF-8';
$server->decode_utf8 = false;
$server->encode_utf8 = true;

// Configurar um namespace SOAP personalizado
$soap_namespace = 'http://schemas.xmlsoap.org/soap/envelope/';
$soap_prefix = 'soap';
$server->namespaces["$soap_prefix"] = "$soap_namespace";

$server->configureWSDL('urn:GetLastPassageDetail', $soap_prefix, $_SERVER['HTTP_HOST'] . '/api/web/public/server.php');
$server->wsdl->schemaTargetNamespace =$_SERVER['HTTP_HOST'] . '/api/web/public/server.php';

// Registre a função no serviço SOAP
$server->register(
    'GetLastPassageDetail', // Nome da função
    array('gate' => 'xsd:string', 'direction' => 'xsd:string'), // Parâmetros de entrada
    array('GetLastPassageDetailResult' => 'xsd:array'),
    $_SERVER['HTTP_HOST'] . '/api/web/public/server.php',
    $_SERVER['HTTP_HOST'] . '/api/web/public/server.php',
    'rpc',
    'encoded',
    'Ultima passagem do OCR'
);

$server->service(file_get_contents("php://input"));
?>