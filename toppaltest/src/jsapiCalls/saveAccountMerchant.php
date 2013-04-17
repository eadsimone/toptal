<?php
include '../functions.php';

///*Begin,Validation Server side*/

//if(isset($_POST['email'])&&($_POST['email']!='')){
//    $res = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
//    if($res==false){
//        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Format email ' . $_POST['email'] . ' is NOT valid'));
//        exit;
//    }
//}
//
//if($_POST['cvv']=='' ||$_POST['creditcard']=='' || $_POST['zipcode']==''){
//    echo json_encode(Array('responseCode' => 999, 'responseText' => 'Zip Code, Credit Card, Cvv are required.'));
//    exit;
//}
//if(!isset($_POST['player_name']) || $_POST['player_name']=='') {
//    echo json_encode(Array('responseCode' => 999, 'responseText' => 'the field name is empty'));
//    exit;
//}
//
////note:it is on ui side but is not working
//if(isset($_POST['keywordbox'])&&($_POST['keywordbox']!='')){
//    $keywords=$_POST['keywordbox'];
//    $keywordList = explode(',',$keywords);
//    for($i = 0; $i < count($keywordList); $i++) {
//        $keyword = trim($keywordList[$i]);
//        if (strlen($keyword) > 20) {
//            echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please, enter 20 or less characters for each keyword. The keywords must be separated by commas'));
//            exit;
//        }
//    }
//}
//
////note:it is on ui side but is not working
//if(isset($_POST['limit-selected-categories'])&&($_POST['limit-selected-categories']!='')){
//if(isset($_POST['selected-categories-id-list'])){
//$categories_array=explode(",",$_POST['selected-categories-id-list']);
//$numberofcategories=count($categories_array);
//    if($_POST['limit-selected-categories']<$numberofcategories){
//        echo json_encode(Array('responseCode' => 999, 'responseText' => 'The  categories limit was exceeded'));
//        exit;
//    }
//    }
//}
////note:it is on ui side but is not working
//if(isset($_POST['marketplaceSeoUrlSuffix'])&&($_POST['marketplaceSeoUrlSuffix']!='')){
//
//    if (!preg_match('/^[a-zA-Z0-9_-]+$/',$_POST['marketplaceSeoUrlSuffix'])) {
//        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please use only letters, numbers, hyphens (-) or underscores (_) in this field. No spaces or other characters are allowed.'));
//        exit;
//    }
//}




$json = json_decode(ServicebusGetMerchantinformation($_SESSION['SSMData']['clientGuid']), true);

$Merchant_account_info = $json['responseObject'];


switch ($_POST['merchant-options']) {
    case "braintree":

        /*BrainTreeInfoTO
        {
           X "typeName": "braintree",
            X"publicKey": "sdfj:LJJ:JFSFSOOOoofsdofuqrq98u3,zgg834t8gkkglgm,vbcvbll219009",
            X"privateKey": "fgkfjjdkj4300gifgKJODL0f49fFGH%#gbh0h0fkh5yp3pfgdfhn<dg-3e525n",
            "linkedMerchantAccountName": "Cinsay",
            X"clientSideEncryptionKey": "Example crypt key - 1234567890",
            X"merchantId": "9378",
            X"gatewayUrl": "https://www.pathtogateway.com",
            X"environment": "SANDBOX",
            "merchantProvisioningStatus": "PENDING",
            X"name": "braintree info for customer 123",
            X"id": "3832"
        }*/
        /*validation server side*/
        if($_POST['braintree_encryptionkey']=='' ||$_POST['braintree_publickey']=='' || $_POST['braintree_environment']=='' || $_POST['braintree_merchantid']==''){
            echo json_encode(Array('responseCode' => 999, 'responseText' => 'Merchant ID,Public Key,Private Key,Client Side Encryption Key are required.'));
            exit;
        }

        unset($Merchant_account_info['creationTime']);
        unset($Merchant_account_info['guid']);
        unset($Merchant_account_info['modificationTime']);
        unset($Merchant_account_info['merchantProvisioningStatus']);
        unset($Merchant_account_info['supportedMerchantProviders']);


        $Merchant_account_info['clientSideEncryptionKey']=$_POST['braintree_encryptionkey'];
        $Merchant_account_info['publicKey']=$_POST['braintree_publickey'];
        $Merchant_account_info['environment']=$_POST['braintree_environment'];
        $Merchant_account_info['privateKey']=$_POST['braintree_privatekey'];
        $Merchant_account_info['merchantId']=$_POST['braintree_merchantid'];
        break;
    case "paypalDirect":
           /* {
            X"typeName": "paypal_direct",
            X"receiverEmail": "afansky@gmail.com",
            X"paypalApiUsername": "username for customer 123 PayPal Direct account",
            X"paypalApiPassword": "password for customer 123 PayPal Direct account",
            X"paypalApiSignature": "signature credentials for customer 123 PayPal Direct account",
            X"environment": "SANDBOX",
            X"merchantProvisioningStatus": "PENDING",
            X"name": "PayPal Direct info for customer 123",
            X"id": null
        }*/
        /*validation server side*/
        if($_POST['PayPalEMailAddress']=='' ||$_POST['PayPalApiUserName']=='' || $_POST['PayPalApiPassword']=='' || $_POST['PayPalApiSignature']==''){
            echo json_encode(Array('responseCode' => 999, 'responseText' => 'PayPal E-Mail Address, PayPal Api User Name, PayPal Api Password, PayPal Api Signature are required.'));
            exit;
        }
        if(isset($_POST['PayPalEMailAddress'])&&($_POST['PayPalEMailAddress']!='')){
            $res = filter_var($_POST['PayPalEMailAddress'], FILTER_VALIDATE_EMAIL);
            if($res==false){
                echo json_encode(Array('responseCode' => 999, 'responseText' => 'Format email ' . $_POST['PayPalEMailAddress'] . ' is NOT valid'));
                exit;
            }
        }



        $Merchant_account_info['typeName']="paypalDirect";
        $Merchant_account_info['receiverEmail']=$_POST['PayPalEMailAddress'];
        $Merchant_account_info['paypalApiUsername']=$_POST['PayPalApiUserName'];
        $Merchant_account_info['paypalApiPassword']=$_POST['PayPalApiPassword'];
        $Merchant_account_info['paypalApiSignature']=$_POST['PayPalApiSignature'];

        //take out all unnecessary fields
        unset($Merchant_account_info['clientSideEncryptionKey']);
        unset($Merchant_account_info['gatewayUrl']);
        unset($Merchant_account_info['publicKey']);
        unset($Merchant_account_info['privateKey']);
        unset($Merchant_account_info['merchantId']);
        unset($Merchant_account_info['default']);
        unset($Merchant_account_info['supportedMerchantProviders']);
        unset($Merchant_account_info['creationTime']);
        unset($Merchant_account_info['guid']);
        unset($Merchant_account_info['modificationTime']);
        unset($Merchant_account_info['guid']);



        break;
    case "payOnlineInfo":

        /*PayOnlineTO
        {
        X"typeName": "payonline",
        "receiverEmail": "afansky@gmail.com",
        "payOnlineMerchantId": "merchant ID for customer 123 PayOnline account",
        "payOnlinePrivateKey": "private key for customer 123 PayOnline account",
        "environment": "SANDBOX",
        "merchantProvisioningStatus": "PENDING",
        "name": "PayOnline info for customer 123",
        "id": "1234"
        }*/
        /*validation server side*/
        if($_POST['payonline_merchantid']=='' ||$_POST['payonline_privatekey']==''){
            echo json_encode(Array('responseCode' => 999, 'responseText' => 'Merchant ID, Private Key  are required.'));
            exit;
        }

        $Merchant_account_info['typeName']="payOnlineInfo";
        $Merchant_account_info['payOnlineMerchantId']=$_POST['payonline_merchantid'];
        $Merchant_account_info['payOnlinePrivateKey']=$_POST['payonline_privatekey'];

        //take out all unnecessary fields
        unset($Merchant_account_info['clientSideEncryptionKey']);
        unset($Merchant_account_info['gatewayUrl']);
        unset($Merchant_account_info['publicKey']);
        unset($Merchant_account_info['privateKey']);
        unset($Merchant_account_info['merchantId']);
        unset($Merchant_account_info['default']);
        unset($Merchant_account_info['supportedMerchantProviders']);
        unset($Merchant_account_info['creationTime']);
        unset($Merchant_account_info['guid']);
        unset($Merchant_account_info['modificationTime']);
        unset($Merchant_account_info['guid']);

        //NOTE:"receiverEmail": "afansky@gmail.com", this field is not coming from POST

        break;
    case "braintreeLinked":
        if($_POST['linkedaccuont']==''){
            echo json_encode(Array('responseCode' => 999, 'responseText' => ' Linked Account ID is required.'));
            exit;
        }

        break;
    case "paypal":
        /*    {
            X"typeName": "paypal",
            X"receiverEmail": "afansky@gmail.com",
            X"environment": "SANDBOX",
            X"merchantProvisioningStatus": "PENDING",
            X"name": null,
            X"id": null
        }*/
        /*validation server side*/
        if(isset($_POST['paypal_email'])&&($_POST['paypal_email']!='')){
            $res = filter_var($_POST['paypal_email'], FILTER_VALIDATE_EMAIL);
            if($res==false){
                echo json_encode(Array('responseCode' => 999, 'responseText' => 'Format email ' . $_POST['paypal_email'] . ' is NOT valid'));
                exit;
            }
        }elseif($_POST['paypal_email']==''){
                echo json_encode(Array('responseCode' => 999, 'responseText' => 'Zip Code, Credit Card, Cvv are required.'));
                exit;
        }

        $Merchant_account_info['typeName']="paypal";
        $Merchant_account_info['receiverEmail']=$_POST['paypal_email'];
        
        //take out all unnecessary fields
        unset($Merchant_account_info['clientSideEncryptionKey']);
        unset($Merchant_account_info['gatewayUrl']);
        unset($Merchant_account_info['publicKey']);
        unset($Merchant_account_info['privateKey']);
        unset($Merchant_account_info['merchantId']);
        unset($Merchant_account_info['default']);
        unset($Merchant_account_info['supportedMerchantProviders']);
        unset($Merchant_account_info['creationTime']);
        unset($Merchant_account_info['guid']);
        unset($Merchant_account_info['modificationTime']);
        unset($Merchant_account_info['guid']);
        unset($Merchant_account_info['id']);
        
        break;
}


$clientid=$_SESSION['SSMData']['clientGuid'];
$client_id=getClientId(ServicebusGetClientInfo($clientid));

$orig_data = '{"apiKey":"{{publicKey}}","clientId":"'.$client_id .'","requestObject":' . json_encode($Merchant_account_info) .',"params":null}';
$sb_path = "/api/client/merchantinfo/update";

$response = ServicebusRequest($sb_path, $orig_data);

//hack till jesse finish the call
//$response = '{
//   "responseCode":"1000",
//   "responseObject":"ok",
//   "responseText":"successful"
//}';

echo print_r($response, true);