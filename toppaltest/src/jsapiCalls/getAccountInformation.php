<?php
/*
//this call will pull only from getClient

//desired result
{
    "firstName": "First Name",
    "lastName": "Last Name",
    "email": "email@email.com",
    "defaultLanguage": "en_US",
    "currency": "USD",
    "marketPlaceSEO": "suffix",
    "marketPlaceBioHeadline": "Headline",
    "marketPlaceBioText": "Text"
}*/
include '../functions.php';

function return_new_json($json){

$resp_obj=$json['responseObject'];


$new_json=array(
    "name"=> $resp_obj['name'],
    //"email"=> $resp_obj['email'],
	"email" => $_SESSION['SSMData']['userEmail'], //TOYIN: need to replace with email once getClientInfo call is fixed
    "marketPlaceSEO"=> $resp_obj['marketPlaceSeoUrlSuffix'],
    "marketPlaceBioHeadline"=> $resp_obj['marketPlaceBioHeadline'],
    "marketPlaceBioText"=> $resp_obj['marketPlaceBioText'],
    "supportedLocales" => $resp_obj['supportedLocales'],
    "supportedCurrencyCodes" => $resp_obj['supportedCurrencyCodes']);

    return json_encode($new_json);
}

//$clientGuid=SSMData('clientGuid');
$json = ServicebusGetClientInfo( $_SESSION['SSMData']['clientGuid']);

$data = json_decode($json,true);
$P=return_new_json($data);
echo return_new_json($data);
//echo "<pre>";
//print_r(return_new_json($obj));
//echo "</pre>";

