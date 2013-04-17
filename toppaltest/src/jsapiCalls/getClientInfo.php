<?php
/*
//this call will pull only from getClient

note: for it use the SBClientInfo call, but . . . then
cinsay_Toyin Akinmusuru: strip out clientPlan
strip out clientConfig.billingInfo
strip out clientConfig.merchantInfo
strip out supportedLocales
strip out supportedCurrencyCodes

*/

include '../functions.php';

function return_new_json($json){

    $resp_obj=$json['responseObject'];



    foreach ($resp_obj as $index => $data) {
        if ($index == 'billingInfo' || $index == 'merchantInfo' || $index == 'supportedLocales' || $index == 'supportedCurrencyCodes' ) {
            unset($resp_obj[$index]);
        }
    }

    return json_encode($resp_obj);
}

//IMPORTANT!!! I think that we should take out "defaultMerchantInfo":{}, also

$json = ServicebusGetClientInfo( $_SESSION['SSMData']['clientGuid']);
$data = json_decode($json,true);
echo return_new_json($data);