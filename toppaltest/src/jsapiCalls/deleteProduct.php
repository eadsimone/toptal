<?php
include '../functions.php';

$productGuid = $_GET['guid'];

$request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":{"ids":["' . $productGuid . '"]}}';
$sb_path = "/api/cms/items/delete";

$request = str_replace("{{clientGuid}}", $_SESSION['SSMData']['clientGuid'], $request);

$response = ServicebusRequest($sb_path, $request);

echo print_r($response, true);

