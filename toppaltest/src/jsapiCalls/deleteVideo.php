<?php
include '../functions.php';

$videoGuid = $_GET['guid'];


$request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":{"ids":["' . $videoGuid . '"]}}';
$sb_path = "/api/cms/videos/delete";

$request = str_replace("{{clientGuid}}", $_SESSION['SSMData']['clientGuid'], $request);

$response = ServicebusRequest($sb_path, $request);

echo print_r($response, true);

