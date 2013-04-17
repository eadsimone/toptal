<?php
include '../functions.php';

$json = '
{
    "newClientPlanId": "{{plan_id}}",
	"typeName": "upgradeClientPlan"
}
';

$plan_id = $_GET['plan_id'];

$json = str_replace("{{plan_id}}", $plan_id, $json);

$json = json_encode(json_decode($json));

$request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":' . $json .',"params":null}';
$sb_path = "/api/client/plan/upgrade";

$request = str_replace("{{clientGuid}}", $_SESSION['SSMData']['clientGuid'], $request);

$response = ServicebusRequest($sb_path, $request);

echo print_r($response, true);