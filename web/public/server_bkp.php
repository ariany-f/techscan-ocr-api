<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once('../vendor/econea/nusoap/src/nusoap.php');

$server = new nusoap_server();

$server->soap_defencoding = 'utf-8';

$namespace = "http://tempuri.org/";
$server->configureWSDL(
    "WebServiceOcrSBX",
    $namespace,
    '',
    'rpc',
    '',
    $namespace
);

//$server->wsdl->bindings["WebServiceOcrSBXBinding"]->setName('WebServiceOcrSBXSoap');

//$server->wsdl->addComplexType(
//    'ArrayOfDTOPassage',
//    'complexType',
//    'struct',
//    '',
//    'SOAP-ENC:Array',
//    array(),
//    array(
//        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:DTOPassage[]')
//    ),
//    'tns:DTOPassage'
//);

$server->wsdl->addComplexType(
    'DTOPassage',
    'complexType',
    'struct',
    'sequence',
    '',
    array(
        'IdPassage' => array('name' => 'IdPassage', 'type' => 'xsd:string'),
        'IdGate' => array('name' => 'IdGate', 'type' => 'xsd:string'),
        'Date' => array('name' => 'Date', 'type' => 'xsd:dateTime'),
        'Plate' => array('name' => 'Plate', 'type' => 'xsd:string'),
        'Container' => array('name' => 'Container', 'type' => 'xsd:string'),
        'Container2' => array('name' => 'Container2', 'type' => 'xsd:string'),
        'Validated' => array('name' => 'Validated', 'type' => 'xsd:boolean'),
        'Direction' => array('name' => 'Direction', 'type' => 'tns:EnumDirection'),
        'PlateHorse' => array('name' => 'PlateHorse', 'type' => 'xsd:string'),
        'PlateHorse2' => array('name' => 'PlateHorse2', 'type' => 'xsd:string'),
        'nmGate' => array('name' => 'nmGate', 'type' => 'xsd:string'),
        'Flag_Assert_PassagemPlateHorse' => array('name' => 'Flag_Assert_PassagemPlateHorse', 'type' => 'xsd:string'),
        'Flag_Assert_PassagemPlate' => array('name' => 'Flag_Assert_PassagemPlate', 'type' => 'xsd:string'),
        'Flag_Assert_PassagemCntr' => array('name' => 'Flag_Assert_PassagemCntr', 'type' => 'xsd:string'),
        'Flag_Assert_PassagemCntr2' => array('name' => 'Flag_Assert_PassagemCntr2', 'type' => 'xsd:string'),
        'Flag_Assert_PlateHorse' => array('name' => 'Flag_Assert_PlateHorse', 'type' => 'xsd:string'),
        'Flag_Assert_Plate' => array('name' => 'Flag_Assert_Plate', 'type' => 'xsd:string'),
        'Flag_Assert_Cntr' => array('name' => 'Flag_Assert_Cntr', 'type' => 'xsd:string'),
        'Flag_Assert_Cntr2' => array('name' => 'Flag_Assert_Cntr2', 'type' => 'xsd:string'),
        'Flag_Selected' => array('name' => 'Flag_Selected', 'type' => 'xsd:string'),
    )
);

$server->wsdl->addSimpleType(
    'EnumDirection', // Nome do tipo de enumeração
    'xsd:string', // Tipo base
    'restriction', // Restrição do tipo
    array(
        'Entry' => array('value' => 'Entry'),
        'Exit' => array('value' => 'Exit'),
        'None' => array('value' => 'None')
    )
);
//
//$server->wsdl->addComplexType(
//    'ArrayOfDTOPlate',
//    'complexType',
//    'struct',
//    '',
//    'SOAP-ENC:Array',
//    array(),
//    array(
//        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:DTOPlate[]')
//    ),
//    'tns:DTOPlate'
//);
//
//$server->wsdl->addComplexType(
//    'DTOPlate',
//    'complexType',
//    'struct',
//    'sequence',
//    '',
//    array(
//        'Id' => array('name' => 'Id', 'type'=>'xsd:string'),
//        'PlateNumber' => array('name' => 'PlateNumber', 'type'=>'xsd:string'),
//        'ImagePath' => array('name' => 'ImagePath', 'type'=>'xsd:string'),
//        'ImageBytes' => array('name' => 'ImageBytes', 'type'=>'xsd:string')
//    )
//);
//
//$server->wsdl->addComplexType(
//    'ArrayOfDTOPlateAll',
//    'complexType',
//    'struct',
//    '',
//    'SOAP-ENC:Array',
//    array(),
//    array(
//        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:DTOPlateAll[]')
//    ),
//    'tns:DTOPlateAll'
//);

//$server->wsdl->addComplexType(
//    'DTOPlateAll',
//    'complexType',
//    'struct',
//    'sequence',
//    '',
//    array(
//        'Id' => array('name' => 'Id', 'type'=>'xsd:string'),
//        'ImagePath' => array('name' => 'ImagePath', 'type'=>'xsd:string'),
//        'ImageBytes' => array('name' => 'ImageBytes', 'type'=>'xsd:string')
//    )
//);
//
//$server->wsdl->addComplexType(
//    'ArrayOfDTOContainer',
//    'complexType',
//    'struct',
//    '',
//    'SOAP-ENC:Array',
//    array(),
//    array(
//        array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:DTOContainer[]')
//    ),
//    'tns:DTOContainer'
//);
//
//$server->wsdl->addComplexType(
//    'DTOContainer',
//    'complexType',
//    'struct',
//    'sequence',
//    '',
//    array(
//        'Id' => array('name' => 'Id', 'type'=>'xsd:string'),
//        'ContainerNumber' => array('name'=> 'ContainerNumber', 'type'=>'xsd:string'),
//        'ImagePath' => array('name' => 'ImagePath', 'type'=>'xsd:string'),
//        'ImageBytes' => array('name' => 'ImageBytes', 'type'=>'xsd:string'),
//        'Fl_Ck_Digit' => array('name' => 'Fl_Ck_Digit', 'type'=>'xsd:boolean')
//    )
//);
//
//$server->wsdl->addComplexType(
//    'GetPassages',
//    'complexType',
//    'struct',
//    'sequence',
//    '',
//    array(
//        'dateBegin' => array('name' => 'dateBegin', 'type' => 'xsd:string'),
//        'dateEnd' => array('name' => 'dateEnd' ,'type'=>'xsd:string'),
//        'plateHorse' => array('name' => 'plateHorse' ,'type'=>'xsd:string'),
//        'plate' => array('name' => 'plate' ,'type'=>'xsd:string'),
//        'container' => array('name' => 'container' ,'type'=>'xsd:string'),
//        'container2' => array('name' => 'container2' ,'type'=>'xsd:string'),
//        'Idgate' => array('name' => 'Idgate' ,'type'=>'xsd:string'),
//        'generateImages' => array('name' => 'generateImages', 'type'=>'xsd:boolean'),
//        'AssertDigS' => array('name' => 'AssertDigS' ,'type'=>'xsd:string')
//    )
//);
//
//$server->wsdl->addComplexType(
//    'GetPassagesResponse',
//    'complexType',
//    'struct',
//    'sequence',
//    '',
//    array(
//        'GetPassagesResult' => array('name' => 'GetPassagesResult', 'type' => 'tns:ArrayOfDTOPassage')
//    )
//);
//
//$server->wsdl->addComplexType(
//    'GetAllPassage',
//    'complexType',
//    'struct',
//    'sequence',
//    '',
//    array(
//        'limit' => array('name' => 'limit', 'type' => 'xsd:int'),
//        'gate' => array('name' => 'gate', 'type' => 'xsd:string'),
//        'generateImages' => array('name' => 'generateImages', 'type' => 'xsd:boolean'),
//        'AssertDig' => array('name' => 'AssertDig', 'type' => 'xsd:boolean'),
//    )
//);
//
//$server->wsdl->addComplexType(
//    'GetAllPassageResponse',
//    'complexType',
//    'struct',
//    'sequence',
//    '',
//    array(
//        'GetAllPassageResult' => array('name' => 'GetAllPassageResult', 'type' => 'tns:ArrayOfDTOPassage')
//    )
//);

$server->wsdl->addComplexType(
    'GetLastPassageDetail',
    'complexType',
    'struct',
    'sequence',
    '',
    array(
        'gate' => array('name' => 'gate', 'type' => 'xsd:string'),
        'direction' => array('name' => 'direction', 'type' => 'tns:EnumDirection'),
        'generateImages' => array('name' => 'generateImages', 'type' => 'xsd:boolean'),
        'AssertDigS' => array('name' => 'AssertDigS', 'type' => 'xsd:string')
    )
);

$server->wsdl->addComplexType(
    'GetLastPassageDetailResponse',
    'complexType',
    'struct',
    'sequence',
    '',
    array(
        'GetLastPassageDetailResult' => array(
            'name' => 'GetLastPassageDetailResult',
            'type' => 'tns:DTOPassage'
        )
    )
);
//
//$server->wsdl->addComplexType(
//    'GetPreviousPassageDetail',
//    'complexType',
//    'struct',
//    'sequence',
//    '',
//    array(
//        'IdPassage' => array('name' => 'IdPassage', 'type' => 'xsd:string'),
//        'generateImages' => array('name' => 'generateImages', 'type' => 'xsd:boolean'),
//        'AssertDigS' => array('name' => 'AssertDigS', 'type' => 'xsd:string'),
//    )
//);
//
//$server->wsdl->addComplexType(
//    'GetPreviousPassageDetailResponse',
//    'complexType',
//    'struct',
//    'sequence',
//    '',
//    array(
//        'GetPreviousPassageDetailResult' => array('name' => 'GetPreviousPassageDetailResult', 'type' => 'tns:DTOPassage')
//    )
//);
//
//$server->wsdl->addComplexType(
//    'GetPassageDetail',
//    'complexType',
//    'struct',
//    'sequence',
//    '',
//    array(
//        'IdPassage' => array('name' => 'IdPassage', 'type' => 'xsd:string'),
//        'generateImages' => array('name' => 'generateImages', 'type' => 'xsd:boolean'),
//        'AssertDigS' => array('name' => 'AssertDigS', 'type' => 'xsd:string'),
//    )
//);
//
//$server->wsdl->addComplexType(
//    'GetPassageDetailResponse',
//    'complexType',
//    'struct',
//    'sequence',
//    '',
//    array(
//        'GetPassageDetailResult' => array('name' => 'GetPassageDetailResult', 'type' => 'tns:DTOPassage')
//    )
//);
//
//$server->wsdl->addComplexType(
//    'GetContainer',
//    'complexType',
//    'struct',
//    'sequence',
//    '',
//    array(
//        'dateBegin' => array('name' => 'dateBegin', 'type' => 'xsd:string'),
//        'dateEnd' => array('name' => 'dateEnd', 'type' => 'xsd:string'),
//        'IdGate' => array('name' => 'IdGate', 'type' => 'xsd:string'),
//    )
//);

// Implementação do método
function GetLastPassageDetail($gate, $direction, $generateImages, $AssertDigS) {
    // Retorne um array associativo que corresponde à estrutura do tipo complexo DTOPassage
    $array = array(
        'IdPassage' => '12345',
        'IdGate' => $gate,
        'Date' => '2023-05-29T13:45:00', // Formato ISO 8601 para xsd:dateTime
        'Plate' => 'ABC1234',
        'Container' => 'XYZ5678',
        'Container2' => 'LMN9101',
        'Validated' => true,
        'Direction' => $direction,
        'PlateHorse' => 'DEF4567',
        'PlateHorse2' => 'GHI8901',
        'nmGate' => 'Main Gate',
        'Flag_Assert_PassagemPlateHorse' => 'flag1',
        'Flag_Assert_PassagemPlate' => 'flag2',
        'Flag_Assert_PassagemCntr' => 'flag3',
        'Flag_Assert_PassagemCntr2' => 'flag4',
        'Flag_Assert_PlateHorse' => 'flag5',
        'Flag_Assert_Plate' => 'flag6',
        'Flag_Assert_Cntr' => 'flag7',
        'Flag_Assert_Cntr2' => 'flag8',
        'Flag_Selected' => 'flag9',
    );

    return $array;
}

// Registra o método com a assinatura
$server->register(
    'GetLastPassageDetail',
    array('parameters' => 'tns:GetLastPassageDetail'),
    array('parameters' => 'tns: GetLastPassageDetailResponse'),
    $namespace,
    'http://tempuri.org/GetLastPassageDetail',
    'document',
    'literal',
    '',
    'http://schemas.xmlsoap.org/soap/encoding/',
    ''
);

$server->service(file_get_contents("php://input"));
?>