<?php
include '../functions.php';

$playerGuid = $_GET['pGuid'];

$request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":null,"params":{"ids":["' . $playerGuid . '"]}}';
$sb_path = "/api/cms/players/delete";

$request = str_replace("{{clientGuid}}", $_SESSION['SSMData']['clientGuid'], $request);

$response = ServicebusRequest($sb_path, $request);

echo print_r($response, true);

