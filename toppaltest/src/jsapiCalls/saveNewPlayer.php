<?php

/*
//desired result

{
    "typeName": "player",
    "id": null,
    "name": "Example Player",
    "description": "This is an example player.",
    "assetStatus": "ACTIVE",
    "store": {
        "id": "388",
        "typeName": "store"
    }
}
*/

include '../functions.php';
require_once '../helpers/plan_helper.php';

/*to validate from server side*/
if(!isset($_POST['add_player_name']) || $_POST['add_player_name']=='') {
    echo json_encode(Array('responseCode' => 999, 'responseText' => 'the field name is empty'));
    exit;
}elseif($_POST['add_player_name']!=''){
    $spchar=array('[','@',']','{','}','#','$','^','&','(',')','<','>');
    foreach($spchar as $value){

        if(strstr($_POST['add_player_name'], $value)!=false){
            echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid player name.'));
            exit;
        }
    }
}

if(ctype_space($_POST['add_player_name'])) {
    echo json_encode(Array('responseCode' => 999, 'responseText' => 'the field name only contain whitespace'));
    exit;
}

$variables = array(
		'name' => strip_tags(trim($_POST['add_player_name'])),
		'description' => strip_tags($_POST['add_player_description']),
		'storeGuid' =>  $_SESSION['SSMData']['storeGuid']
);

$json = '
{
    "typeName": "player",
    "id": null,
    "name": "{{name}}",
    "description": "{{description}}",
    "assetStatus": "ACTIVE",
	"shareMessage": "I thought you might like this cool video.",
	"store": {
        "id": "{{storeGuid}}",
        "typeName": "store"
    },
	"playerConfiguration": {
		"stopVideoOnOverlayTriggers": true
	}
}
';

foreach($variables as $key => $value) {
	$json = str_replace("{{" . $key . "}}", $value, $json);
}

$clientInfo = ServicebusGetClientInfo( $_SESSION['SSMData']['clientGuid']);
$planUsage = json_decode(return_new_json_plan_usage(json_decode($clientInfo,true)), TRUE);

if(canAddMorePlayers($planUsage) === TRUE) {
//echo $json;
    $orig_data = '{"apiKey":"{{publicKey}}","clientId":"'. $_SESSION['SSMData']['clientGuid'].'","requestObject":' . $json .',"params":null}';
    $sb_path = "/api/cms/players/createorupdate";

    $response = ServicebusRequest($sb_path, $orig_data);
} else {
    $response = json_encode(
        Array(
            'responseCode' => 2000,
            'responseObject' => Array(),
            'responseText' => 'You have reached a limit of your actual plan'
        )
    );
}

echo print_r($response, true);