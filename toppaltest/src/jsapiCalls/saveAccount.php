<?php
include '../functions.php';

///*Begin,Validation Server side*/
// if(!isset($_POST['name']) || $_POST['name']=='') {
//     echo json_encode(Array('responseCode' => 999, 'responseText' => 'Field name is empty'));
//     exit;
// }
//note:it is on ui side but is not working
if(isset($_POST['seourlsuffix'])&&($_POST['seourlsuffix']!='')){

    if (!preg_match('/^[a-zA-Z0-9_-]+$/',$_POST['seourlsuffix'])) {
        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please use only letters, numbers, hyphens (-) or underscores (_) in this field. No spaces or other characters are allowed.'));
        exit;
    }
}


//note:it is on ui side but is not working
if(isset($_POST['email'])&&($_POST['email']!='')){
    $res = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if($res==false){
        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Format email ' . $_POST['email'] . ' is NOT valid'));
        exit;
    }
}

$json = json_decode(ServicebusGetClientInfo( $_SESSION['SSMData']['clientGuid']),true);

$accouninfo = $json['responseObject'];

//remove crap we don't need
//unset($accouninfo['client']);
//unset($accouninfo['store']);
//unset($accouninfo['items']); //we don't need to push these base since we'll specify ids
//unset($accouninfo['videos']); //we don't need to push these base since we'll specify ids

//set variables

$accouninfo['name']=$_POST['name'];
$accouninfo['email']=$_POST['email'];

if(isset($_POST['defaultlocale'])) {
	$supportedLocaleBool = false;
	foreach($accouninfo['supportedLocales'] as $supportedLocale) {
		if($supportedLocale['code'] == $_POST['defaultlocale']) {
			$supportedLocale['defaultLocale'] = true;
			$supportedLocaleBool = true;
		} else {
			$supportedLocale['defaultLocale'] = false;
		}
	}
}

if(isset($_POST['defaultcurrency'])) {
	$supportedCurrencyCodeBool = false;
	foreach($accouninfo['supportedCurrencyCodes'] as $supportedCurrencyCode) {
		if($supportedCurrencyCode['currencyCode'] == $_POST['defaultcurrency']) {
			$supportedCurrencyCode['defaultCurrency'] = true;
			$$supportedCurrencyCodeBool = true;
		} else {
			$supportedCurrencyCode['defaultCurrency'] = false;
		}
	}
}

if(isset($_POST['seourlsuffix'])) {
	$accouninfo['marketPlaceSeoUrlSuffix'] = $_POST['seourlsuffix'];
}

$accouninfo['marketPlaceBioHeadline']=$_POST['marketplacebioheadline'];
$accouninfo['marketPlaceBioText']=$_POST['marketplacebiotext'];


//$accouninfo='
//{
//    "description": null,
//    "domain": "lea.local",
//    "email": null,
//    "clientConfig": {
//        "description": "--Enter a description for the client configuration--",
//        "server": null,
//        "billingInfo": null,
//        "merchantInfo": {
//            "typeName": "braintree",
//            "environment": "SANDBOX",
//            "merchantProvisioningStatus": null,
//            "name": null,
//            "id": "3832",
//            "creationTime": 1336634616000,
//            "modificationTime": 1336635987000,
//            "guid": "4753c5de-d436-4894-aeae-bf1e603edb0d",
//            "entityClass": "com.cinsay.clp.dal.model.MerchantInfo"
//        },
//        "domainName": "client-admin",
//        "dbUsername": null,
//        "dbPassword": null,
//        "dbSchema": null,
//        "serverClientConfigType": null,
//        "name": "Clientconfigforclient446",
//        "id": "184",
//        "typeName": null,
//        "creationTime": 1328788446000,
//        "modificationTime": 1336634616000,
//        "guid": "509d9194-6209-4d80-917b-4c000e96b93e",
//        "entityClass": "com.cinsay.clp.dal.model.ClientConfig"
//    },
//    "externalCustomerId": "33",
//    "brand": null,
//    "channelPartner": null,
//    "storeId": null,
//    "clientPlans": null,
//    "subdomain": "client-admin-1",
//    "logo": null,
//    "contentShared": false,
//    "activeTheme": null,
//    "storeCategoryId": null,
//    "facebookAppId": null,
//    "gigyaAppId": null,
//    "gaTrackingId": null,
//    "clientCode": null,
//    "storeServiceUrl": null,
//    "ntorusEnabled": true,
//    "markedForDelete": false,
//    "name": "afansky_store",
//    "id": "446",
//    "typeName": null,
//    "creationTime": 1328788446000,
//    "modificationTime": 1328788446000,
//    "guid": "2ac792b8-d4bf-44df-a7e8-c6fea1058e7f",
//    "entityClass": "com.cinsay.clp.dal.model.Client"
//}';


$orig_data = '{"apiKey":"{{publicKey}}","clientId":"'. $accouninfo['id'] .'","requestObject":' . json_encode($accouninfo) .',"params":null}';
//$sb_path = "/api/cms/players/createorupdate";
$sb_path = "/api/client/update";


$response = ServicebusRequest($sb_path, $orig_data);

//$response = ServicebusGetClientInfo( $_SESSION['SSMData']['clientGuid']);

echo print_r($response, true);