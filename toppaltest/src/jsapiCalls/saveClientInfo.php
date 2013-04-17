<?php
include '../functions.php';

$_POST['clientGuid'] =  $_SESSION['SSMData']['clientGuid'];
echo "|||POST||| " . print_r($_POST, true);

$jsonData = json_decode(ServicebusGetClientInfo( $_SESSION['SSMData']['clientGuid']), true);

$client = $jsonData['responseObject'];

//account information
$client['name'] = $_POST['name'];
$client['email'] = $_POST['email'];
$client['marketPlaceBioHeadline'] = $_POST['marketplacebioheadline'];
$client['marketPlaceBioText'] = $_POST['marketplacebiotext'];
$client['marketPlaceSeoUrlSuffix'] = $_POST['seourlsuffix'];
$client['defaultlocale'] = 
$client['defaultcurrency'] =


//merchant account information
$client['merchantInfo']['typeName'] = $_POST['merchant-options'];
$client['merchantInfo']['clientSideEncryptionKey'] = $_POST['braintree_encryptionkey'];
$client['merchantInfo']['merchantId'] = $_POST['braintree_merchantid'];
$client['merchantInfo']['environment'] = $_POST['braintree_environment'];
$client['merchantInfo']['privateKey'] = $_POST['braintree_encryptionkey'];
$client['merchantInfo']['publicKey'] = $_POST['braintree_publickey'];

//billing information

//echo $json;
$orig_data = '{"apiKey":"{{publicKey}}","clientId":"'. $_SESSION['SSMData']['clientGuid'].'","requestObject":' . json_encode($client) .',"params":null}';
$sb_path = "/api/cms/players/createorupdate";


$response = ServicebusRequest($sb_path, $orig_data);

echo print_r($response, true);