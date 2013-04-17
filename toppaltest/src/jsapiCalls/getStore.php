<?php
/*
//this call will pull only from getClient

//desired result
{
   "merchantTermsAndConditionsUrl":"www.TermsConditionsLinkinkpeche.com",//terms && condition link
         "customerSupportEmailAddress":"peche@cinsay.com",
         "customerSupportSiteURL":"www.supportLinkpeche.com",//support link
         "customerServiceTelephoneNumber":"7732700731",
         "customerServiceInfoTitle":"Info Title peche",
         "customerServiceInfo":"info peche",
         "customerServiceInfoLogoUrl":"",
}*/
include '../functions.php';

function return_new_json($json){

$resp_obj=$json['responseObject'];


$new_json=array(
    "telephone"=> $resp_obj[0]['customerServiceTelephoneNumber'],
    "email"=> $resp_obj[0]['customerSupportEmailAddress'],
    "supportlink"=> $resp_obj[0]['customerSupportSiteURL'],
    "termsconditionslink"=> $resp_obj[0]['merchantTermsAndConditionsUrl'],
    "infotitle"=> $resp_obj[0]['customerServiceInfoTitle'],
    "info" => $resp_obj[0]['customerServiceInfo'],
    "infologo" => $resp_obj[0]['customerServiceInfoLogoUrl']);

    return json_encode($new_json);
}


/*$clientGuid='5cc553d3-3cfc-48d3-b8f2-85bd075060f6';
$storeGuid='6bc86bf8-370c-4fd2-a493-5a292604da53';*/

$json = ServicebusGetStoreInfo( $_SESSION['SSMData']['clientGuid'], $_SESSION['SSMData']['storeGuid']);

$data = json_decode($json,true);

//echo "<pre>" . prettyJSON($json,true) . "</pre>";

echo return_new_json($data);

