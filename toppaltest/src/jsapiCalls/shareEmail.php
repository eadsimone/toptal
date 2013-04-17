<?php
include '../functions.php';

// echo "|||GET||| " . print_r($_GET, true);
// echo "|||POST||| " . print_r($_POST, true);

if(!isset($_POST['publish_email']) || $_POST['publish_email']=='') {
    echo json_encode(Array('responseCode' => 999, 'responseText' => 'the field Email Address is empty'));
    exit;
}

$recipients = array_map("trim", explode(",", $_POST['publish_email']));

foreach($recipients as $sendee) {
	$res = filter_var($sendee, FILTER_VALIDATE_EMAIL);
	if($res==false){
		echo json_encode(Array('responseCode' => 999, 'responseText' => 'Format email ' . $sendee . ' is NOT valid'));
		exit;
	}
}

$clientInfo = json_decode(ServicebusGetClientInfo( $_SESSION['SSMData']['clientGuid']), true);
$senderName = $clientInfo['responseObject']['name'];
$senderEmail = $clientInfo['responseObject']['email'];

$variables = array(
					"senderName" => $senderName,
					"senderEmail" => $senderEmail,
					"recipients" => '"' . implode('","',$recipients) . '"',
					"message" => $_POST['publish_message'],
					"playerGuid" => $_GET['pGuid'],
					"clientGuid" => $_SESSION['SSMData']['clientGuid']
					);

$json = '
{
    "fullName": "{{senderName}}",
    "yourEmail": "{{senderEmail}}",
    "shareEmails": [{{recipients}}],
    "message": "{{message}}",
    "playerId": "{{playerGuid}}",
	"typeName": "shareVideo"
}
';

$request = '{"apiKey":"{{publicKey}}","clientId":"{{clientGuid}}","requestObject":' . $json .',"params":null}';
$sb_path = "/api/player/emailshare";

foreach($variables as $key => $value) {
	$request = str_replace("{{" . $key . "}}", $value, $request);
}

$response = ServicebusRequest($sb_path, $request, false);

echo $response;