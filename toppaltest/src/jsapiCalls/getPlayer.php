<?php
/*
//desired result
{
    "player":{
        "name": "MySmartStore",
        "guid": "14eb98bc-99e4-4c47-922a-36db1737263f",
        "description": "This video is about the generic whatever and the generic this or that ;)",
        "shareMessage": "This is neat",
        "marketplaceSeoUrlSuffix": "14eb98bc-99e4-4c47-922a-36db1737263f",
        "assetStatus": "ACTIVE",
        "embedCode": "<iframe src='http://services.stag.cinsay.com/html-player/embed.jsp?playerid=14eb98bc-99e4-4c47-922a-36db1737263f&rmiurl=services.stag.cinsay.com&cdnurl=services.stag.cinsay.com&width=700&height=394' WIDTH='700' HEIGHT='394' FRAMEBORDER='0' SCROLLING='no' style='padding:0;margin:0;border:none;'></iframe>",
        "playerConfiguration": {
            "typeName": "playerConfiguration",
            "locale": "en_US",
            "brandGuid": null,
            "linkedOverlays": {},
            "defaultFlowBackgroundImage": null,
            "ecommFlowBackgroundImage": null,
            "donationFlowBackgroundImage": null,
            "leadGenFlowBackgroundImage": null,
            "buyNowText": "Buy Today!",
            "customShareUrl": null,
            "affiliateTrackingUrl": "http://fromjson.com",
            "limitProductQuantityPurchase": false,
            "limitNumberOfPurchases": true,
            "stopVideoOnOverlayTriggers": false,
            "useCustomShareUrl": false,
            "takeActionText": "Please click me :-(",
            "purchaseRedirectUrl": "www.bbadeauxforpresident.com",
            "endOfPlayRedirectUrl": "www.impeachbbadeaux.com",
            "name": null,
            "id": "12424",
            "creationTime": null,
            "modificationTime": null,
            "guid": null
        }
    }
}
*/

include '../functions.php';


function return_new_json($json){

	$resp_data=$json['responseObject'];
	
	//blank out client instances
	unset($resp_data[0]['client']);
	unset($resp_data[0]['store']['client']);
	
	//loop through and create a firstThumb which holds the first itemVariant's thumb.url
	for($i = 0; $i < count($resp_data[0]['items']); $i++) {
		if(isset($resp_data[0]['items'][$i]['itemVariants'][0])) {
			$resp_data[0]['items'][$i]['itemVariants'][0]['firstThumb'] = $resp_data[0]['items'][$i]['itemVariants'][0]['thumb']['url'];
		}
	}
	if($resp_data[0]['assetStatus'] == "ACTIVE") {
		$resp_data[0]['active'] = true;
	} else {
		$resp_data[0]['active'] = false;
	}
	
	$new_data = array("player" => $resp_data[0]);
	
	return json_encode($new_data);

}



$json = ServicebusGetPlayer( $_SESSION['SSMData']['clientGuid'], $_GET['pGuid']);

$data = json_decode($json,true);

echo return_new_json($data);

//to test
//$pGuid='090f454d-04b3-4c66-8ea9-841a567b1516';//for feb account
//$clientGuid='5cc553d3-3cfc-48d3-b8f2-85bd075060f6';
//$json = ServicebusGetPlayer($clientGuid, $pGuid);
//$data = json_decode($json,true);
//echo return_new_json($data);