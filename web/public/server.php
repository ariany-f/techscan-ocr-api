<?php
class WebServiceOcrSBXSoap {

    public function __construct()
    {
    }

    public function GetAllGates($parameters) {
        // URL para a qual você deseja enviar a requisição
        $url = $_SERVER['HTTP_HOST'] . '/api/web/public/portoes/';
        // Inicializa a sessão cURL
        $curl = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Retorna o resultado como uma string em vez de imprimi-lo na tela
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'));

        // Executa a requisição e armazena a resposta
        $response = curl_exec($curl);

        // Verifica se ocorreu algum erro durante a requisição
        if(curl_errno($curl)) {
            return new SoapFault("Server",  "Erro Inesperado", "ServerURI", 'Erro na requisição cURL: ' . curl_error($curl));
        }

        // Fecha a sessão cURL
        curl_close($curl);

        $data = json_decode($response, true);

        foreach($data as $portoes)
        {
            $obj[] = [
                'IdGate' => $portoes['id'],
                'NameGate' => $portoes['name'],
            ];
        }

        return array('GetAllGatesResult' => $obj);
    }

    public function GetLastPassageDetail($parameters) {

        if(empty($parameters->gate))
        {
            return new SoapFault("Client",  "Parâmetros inválidos", "actorURI", 'Parâmetro gate obrigatório');
        }
        if(empty($parameters->generateImages))
        {
            $parameters->generateImages = true;
        }
        if((!empty($parameters->direction)) && (!in_array($parameters->direction, ['Entry', 'Exit', 'None'])))
        {
            return new SoapFault("Client",  "Parâmetros inválidos", "actorURI", 'Parâmetro direction inválido');
        }
        // Verificar se é uma string
        if (is_string($parameters->generateImages)) {
            // Converter para booleano
            $parameters->generateImages = filter_var($parameters->generateImages, FILTER_VALIDATE_BOOLEAN);
        }

        if(!is_bool($parameters->generateImages))
        {
            return new SoapFault("Client",  "Parâmetros inválidos", "actorURI", 'Parâmetro generateImages inválido');
        }

        // URL para a qual você deseja enviar a requisição
        $url = $_SERVER['HTTP_HOST'] . '/api/web/public/ultima-passagem/';

        switch($parameters->direction)
        {
            case 'Entry':
                $direction = '1';
                break;
            case 'None':
                $direction = '3';
                break;
            case 'Exit':
                $direction = '2';
                break;
            default:
                $direction = '';
                break;
        }

        $postData = array(
            'gate' => $parameters->gate,
            'direction' => $direction,
            'generateImages' => $parameters->generateImages,
            'AssertDigS' => $parameters->AssertDigS
        );

        // Inicializa a sessão cURL
        $curl = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Retorna o resultado como uma string em vez de imprimi-lo na tela
        curl_setopt($curl, CURLOPT_POST, true); // Define o método da requisição como POST
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));

        // Executa a requisição e armazena a resposta
        $response = curl_exec($curl);

        // Verifica se ocorreu algum erro durante a requisição
        if(curl_errno($curl)) {
            return new SoapFault("Server",  "Erro Inesperado", "ServerURI", 'Erro na requisição cURL: ' . curl_error($curl));
        }

        // Fecha a sessão cURL
        curl_close($curl);

        $data = json_decode($response, true)['data'][0];
        $plate = [];
        $container = [];
        foreach ($data['list'] as $k => $event) {
            if (isset($event['plate']) && !empty($event['plate'])) {
                $count_plates[] = $event;

                if($parameters->generateImages)
                {
                    $images = explode(",", $event['images']);
                    for($a=0;$a<count($images);$a++)
                    {
                        $plate[] = [
                            'Id' => $event['id'],
                            'PlateNumber' =>  $event['plate'],
                            'ImagePath' =>  'http://' . $_SERVER['HTTP_HOST'] . '/api/web/public/' . $images[$a],
                            'ImageBytes' => base64_encode(file_get_contents('http://' .$_SERVER['HTTP_HOST'] . '/api/web/public/' . $images[$a]))
                        ];
                    }
                }
                else
                {
                    $plate[] = [
                        'Id' => $event['id'],
                        'PlateNumber' =>  $event['plate'],
                    ];
                }
            }
            if (isset($event['container']) && !empty($event['container'])) {
                $count_containers[] = $event;

                if($parameters->generateImages)
                {
                    $images = explode(",", $event['images']);
                    for($a=0;$a<count($images);$a++)
                    {
                        $container[] = [
                            'Id' => $event['id'],
                            'PlateNumber' =>  $event['plate'],
                            'ImagePath' =>  'http://' . $_SERVER['HTTP_HOST'] . '/api/web/public/' . $images[$a],
                            'ImageBytes' => base64_encode(file_get_contents('http://' .$_SERVER['HTTP_HOST'] . '/api/web/public/' . $images[$a]))
                        ];
                    }
                }
                else
                {
                    $container[] = [
                        'Id' => $event['id'],
                        'PlateNumber' =>  $event['plate'],
                    ];
                }
            }
        }

        $obj = [
            'IdPassage' => $data['id'],
            'IdGate' => $parameters->gate,
            'Date' => $data['created_at'], // Formato ISO 8601 para xsd:dateTime
            'Plate' => $data['plate'] ?? '',
            'Container' => $data['container'] ?? '',
            'Container2' => '',
            'Validated' => (($data['status'] == 'Aprovada' || $data['status'] == 'Erro') ? 'true' : 'false'),
            'Direction' => $parameters->direction,
            'PlateHorse' => '',
            'PlateHorse2' => '',
            'nmGate' =>$data['gate_name'],
            'ListPlate' => $plate,
            'ListPlateAll' => array(),
            'ListContainer' => $container,
            'Flag_Assert_PassagemPlateHorse' => 1,
            'Flag_Assert_PassagemPlate' => 1,
            'Flag_Assert_PassagemCntr' => 1,
            'Flag_Assert_PassagemCntr2' => 1,
            'Flag_Assert_PlateHorse' => 1,
            'Flag_Assert_Plate' => 1,
            'Flag_Assert_Cntr' => 1,
            'Flag_Assert_Cntr2' => 1,
            'Flag_Selected' => 1,
        ];

        return array('GetLastPassageDetailResult' => $obj);
    }

    public function GetPreviousPassageDetail($parameters) {
        if(empty($parameters->IdPassage))
        {
            return new SoapFault("Client",  "Parâmetros inválidos", "actorURI", 'Parâmetro IdPassage obrigatório');
        }
        if(empty($parameters->generateImages))
        {
            $parameters->generateImages = true;
        }
        // Verificar se é uma string
        if (is_string($parameters->generateImages)) {
            // Converter para booleano
            $parameters->generateImages = filter_var($parameters->generateImages, FILTER_VALIDATE_BOOLEAN);
        }

        if(!is_bool($parameters->generateImages))
        {
            return new SoapFault("Client",  "Parâmetros inválidos", "actorURI", 'Parâmetro generateImages inválido');
        }

        // URL para a qual você deseja enviar a requisição
        $url = $_SERVER['HTTP_HOST'] . '/api/web/public/passagem-anterior/' . $parameters->IdPassage;


//        $postData = array(
//            'IdPassage' => $parameters->IdPassage,
//            'generateImages' => $parameters->generateImages,
//            'AssertDigS' => $parameters->AssertDigS
//        );

        // Inicializa a sessão cURL
        $curl = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Retorna o resultado como uma string em vez de imprimi-lo na tela
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'));

        // Executa a requisição e armazena a resposta
        $response = curl_exec($curl);

        // Verifica se ocorreu algum erro durante a requisição
        if(curl_errno($curl)) {
            return new SoapFault("Server",  "Erro Inesperado", "ServerURI", 'Erro na requisição cURL: ' . curl_error($curl));
        }

        // Fecha a sessão cURL
        curl_close($curl);

        $data = json_decode($response, true)['data'][0];
        $plate = [];
        $container = [];
        foreach ($data['list'] as $k => $event) {
            if (isset($event['plate']) && !empty($event['plate'])) {
                $count_plates[] = $event;

                if($parameters->generateImages)
                {
                    $images = explode(",", $event['images']);
                    for($a=0;$a<count($images);$a++)
                    {
                        $plate[] = [
                            'Id' => $event['id'],
                            'PlateNumber' =>  $event['plate'],
                            'ImagePath' =>  'http://' . $_SERVER['HTTP_HOST'] . '/api/web/public/' . $images[$a],
                            'ImageBytes' => base64_encode(file_get_contents('http://' .$_SERVER['HTTP_HOST'] . '/api/web/public/' . $images[$a]))
                        ];
                    }
                }
                else
                {
                    $plate[] = [
                        'Id' => $event['id'],
                        'PlateNumber' =>  $event['plate'],
                    ];
                }
            }
            if (isset($event['container']) && !empty($event['container'])) {
                $count_containers[] = $event;

                if($parameters->generateImages)
                {
                    $images = explode(",", $event['images']);
                    for($a=0;$a<count($images);$a++)
                    {
                        $container[] = [
                            'Id' => $event['id'],
                            'PlateNumber' =>  $event['plate'],
                            'ImagePath' =>  'http://' . $_SERVER['HTTP_HOST'] . '/api/web/public/' . $images[$a],
                            'ImageBytes' => base64_encode(file_get_contents('http://' .$_SERVER['HTTP_HOST'] . '/api/web/public/' . $images[$a]))
                        ];
                    }
                }
                else
                {
                    $container[] = [
                        'Id' => $event['id'],
                        'PlateNumber' =>  $event['plate'],
                    ];
                }
            }
        }

        $obj = [
            'IdPassage' => $data['id'],
            'IdGate' => $parameters->gate,
            'Date' => $data['created_at'], // Formato ISO 8601 para xsd:dateTime
            'Plate' => $data['plate'] ?? '',
            'Container' => $data['container'] ?? '',
            'Container2' => '',
            'Validated' => (($data['status'] == 'Aprovada' || $data['status'] == 'Erro') ? 'true' : 'false'),
            'Direction' => $parameters->direction,
            'PlateHorse' => '',
            'PlateHorse2' => '',
            'nmGate' =>$data['gate_name'],
            'ListPlate' => $plate,
            'ListPlateAll' => array(),
            'ListContainer' => $container,
            'Flag_Assert_PassagemPlateHorse' => 1,
            'Flag_Assert_PassagemPlate' => 1,
            'Flag_Assert_PassagemCntr' => 1,
            'Flag_Assert_PassagemCntr2' => 1,
            'Flag_Assert_PlateHorse' => 1,
            'Flag_Assert_Plate' => 1,
            'Flag_Assert_Cntr' => 1,
            'Flag_Assert_Cntr2' => 1,
            'Flag_Selected' => 1,
        ];

        return array('GetPreviousPassageDetailResult' => $obj);
    }

    public function GetPassageDetail($parameters) {
        if(empty($parameters->IdPassage))
        {
            return new SoapFault("Client",  "Parâmetros inválidos", "actorURI", 'Parâmetro IdPassage obrigatório');
        }
        if(empty($parameters->generateImages))
        {
            $parameters->generateImages = true;
        }
        // Verificar se é uma string
        if (is_string($parameters->generateImages)) {
            // Converter para booleano
            $parameters->generateImages = filter_var($parameters->generateImages, FILTER_VALIDATE_BOOLEAN);
        }

        if(!is_bool($parameters->generateImages))
        {
            return new SoapFault("Client",  "Parâmetros inválidos", "actorURI", 'Parâmetro generateImages inválido');
        }

        // URL para a qual você deseja enviar a requisição
        $url = $_SERVER['HTTP_HOST'] . '/api/web/public/infopassagens/' . $parameters->IdPassage;


//        $postData = array(
//            'IdPassage' => $parameters->IdPassage,
//            'generateImages' => $parameters->generateImages,
//            'AssertDigS' => $parameters->AssertDigS
//        );

        // Inicializa a sessão cURL
        $curl = curl_init($url);

        // Configura as opções da requisição
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Retorna o resultado como uma string em vez de imprimi-lo na tela
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'));

        // Executa a requisição e armazena a resposta
        $response = curl_exec($curl);

        // Verifica se ocorreu algum erro durante a requisição
        if(curl_errno($curl)) {
            return new SoapFault("Server",  "Erro Inesperado", "ServerURI", 'Erro na requisição cURL: ' . curl_error($curl));
        }

        // Fecha a sessão cURL
        curl_close($curl);

        $data = json_decode($response, true)['data'][0];
        $plate = [];
        $container = [];
        foreach ($data['list'] as $k => $event) {
            if (isset($event['plate']) && !empty($event['plate'])) {
                $count_plates[] = $event;

                if($parameters->generateImages)
                {
                    $images = explode(",", $event['images']);
                    for($a=0;$a<count($images);$a++)
                    {
                        $plate[] = [
                            'Id' => $event['id'],
                            'PlateNumber' =>  $event['plate'],
                            'ImagePath' =>  'http://' . $_SERVER['HTTP_HOST'] . '/api/web/public/' . $images[$a],
                            'ImageBytes' => base64_encode(file_get_contents('http://' .$_SERVER['HTTP_HOST'] . '/api/web/public/' . $images[$a]))
                        ];
                    }
                }
                else
                {
                    $plate[] = [
                        'Id' => $event['id'],
                        'PlateNumber' =>  $event['plate'],
                    ];
                }
            }
            if (isset($event['container']) && !empty($event['container'])) {
                $count_containers[] = $event;

                if($parameters->generateImages)
                {
                    $images = explode(",", $event['images']);
                    for($a=0;$a<count($images);$a++)
                    {
                        $container[] = [
                            'Id' => $event['id'],
                            'PlateNumber' =>  $event['plate'],
                            'ImagePath' =>  'http://' . $_SERVER['HTTP_HOST'] . '/api/web/public/' . $images[$a],
                            'ImageBytes' => base64_encode(file_get_contents('http://' .$_SERVER['HTTP_HOST'] . '/api/web/public/' . $images[$a]))
                        ];
                    }
                }
                else
                {
                    $container[] = [
                        'Id' => $event['id'],
                        'PlateNumber' =>  $event['plate'],
                    ];
                }
            }
        }

        $obj = [
            'IdPassage' => $data['id'],
            'IdGate' => $parameters->gate,
            'Date' => $data['created_at'], // Formato ISO 8601 para xsd:dateTime
            'Plate' => $data['plate'] ?? '',
            'Container' => $data['container'] ?? '',
            'Container2' => '',
            'Validated' => (($data['status'] == 'Aprovada' || $data['status'] == 'Erro') ? 'true' : 'false'),
            'Direction' => $parameters->direction,
            'PlateHorse' => '',
            'PlateHorse2' => '',
            'nmGate' =>$data['gate_name'],
            'ListPlate' => $plate,
            'ListPlateAll' => array(),
            'ListContainer' => $container,
            'Flag_Assert_PassagemPlateHorse' => 1,
            'Flag_Assert_PassagemPlate' => 1,
            'Flag_Assert_PassagemCntr' => 1,
            'Flag_Assert_PassagemCntr2' => 1,
            'Flag_Assert_PlateHorse' => 1,
            'Flag_Assert_Plate' => 1,
            'Flag_Assert_Cntr' => 1,
            'Flag_Assert_Cntr2' => 1,
            'Flag_Selected' => 1,
        ];

        return array('GetPassageDetailResult' => $obj);
    }
}

try {

    $options = [
        'uri' => 'http://' . $_SERVER['HTTP_HOST'] . '/api/web/public/server.php'
    ];

    $server = new SoapServer('service.wsdl', $options);

    $server->setClass('WebServiceOcrSBXSoap');
    $server->handle();

} catch (SOAPFault $f) {
    echo $f->getMessage();
}
