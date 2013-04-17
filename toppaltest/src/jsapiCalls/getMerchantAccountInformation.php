<?php
/*
{
    "merchantAccountInformation" : {
        "paypalDirect": {
            "paypalEmailAddress" : "",
            "paypalApiUsername" : "",
            "paypalApiPassword" : "",
            "paypalApiSignature" : ""
        },
        "payOnline" : {
            "merchantID" : "",
            "privateKey" : ""
        },
        "personal" : {
            "linkedAccountID" : ""
        },
        "paypal" : {
            "paypalEmailAddress" : ""
        },
        "braintree" : {
            "merchantID"  : "t52vct3qsqwkgmj2",
            "publicKey"  : "mh7grbytj5tb8558",
            "privateKey" : "btzvppt622926gzw",
            "ClientSideEncriptionKey" : "MIIBCgKCAQEAudMKUTL3avde6+ZYeU5unJKIOsuSV/ohx930u9Fk0i/6qqy7I/a+f0brqyYDZurgzcR6+QqUlCAc+dpsm7tmwRj9zGMVuepuSFfQU1N3/FZHlXJm4jGmDNepoVDAyLY32+Mye4WixUCCzZFUrP3JcLshafAqifhLbhHG23ijXdvmktYm+a9sFJqiABrcSUU0yIi+uGK8xhBPgTFSM4APC8NjFmnOAteK7zSXvI0v0w5Z5h78H/kIC92dWxv5y0X/9vbHZE3glwWR9MIJ7/GyZ9M6dlfH+8ZQ4sAb+S5jVOwL1lLaiFDPBBRPZ+h0wq2j1ArgH2ALjVFCpcvRkVT7TQIDAQAB",
            "Environment" : {
                "options" : [
                    {
                        "label" : "Production",
                        "value" : "PRODUCTION"
                    },
                    {
                        "label" : "Sandbox",
                        "value" : "SANDBOX"
                    }
                ],
                "value"	  : "PRODUCTION"
            }
        },
        "merchantAccountType" : {
            "options" : [
                {
                    "label" : "Braintree merchant account",
                    "value" : "braintree",
                    "selected" : "selected"
                },
                {
                    "label" : "Paypal pro account",
                    "value" : "paypalDirect"
                },
                {
                    "label" : "Pay online",
                    "value" : "payOnline"
                },
                {
                    "label" : "Personal merchant account",
                    "value" : "personal"
                },
                {
                    "label" : "Braintree merchant account",
                    "value" : "braintree"
                },
                {
                    "label" : "Paypal Business Standard/Advanced",
                    "value" : "paypal"
                }
            ],
            "value"   : "braintree"
        }

    }
}*/
include '../functions.php';

function return_new_json($json){

    $resp_obj=$json['responseObject'];

    $merchan_info_list= array();

    //foreach( $resp_obj as $key => $value ){
    $name = $resp_obj['typeName'];

    /*$used = $resp_obj['clientPlanItemUsage']['currentUsage'];

   $total= $resp_obj['planItem']['itemLimit'];
   $division= percent($used,$total);*/
    if($name=="payOnlineInfo"){
        $merchant[$name]=array(
            "merchantId"=>$resp_obj['payOnlineMerchantId'],
            "publicKey"=>$resp_obj['publicKey'],
            "privateKey"=>$resp_obj['payOnlinePrivateKey'],
            "ClientSideEncriptionKey"=>$resp_obj['clientSideEncryptionKey']
        );
    }
//     elseif($name=="paypalDirect"){
//         $merchant[$name]=array(
//             "paypalApiUsername"=>$resp_obj['paypalApiUsername'],
//             "paypalApiPassword"=>$resp_obj['paypalApiPassword'],
//             "paypalApiSignature"=>$resp_obj['paypalApiSignature'],
//             "paypalEmailAddress"=>$resp_obj['receiverEmail']
//         );

//     }
//     elseif($name=="braintreeLinked"){
//         $merchant[$name]=array(
//             "linkedMerchantAccountName"=>$resp_obj['linkedMerchantAccountName']
//         );

//     }
    elseif($name=="paypal"){
        $merchant[$name]=array(
            "receiverEmail"=>$resp_obj['receiverEmail']
        );

    }
    else
    {
        $merchant[strtolower($name)]=array(
            "merchantId"=>$resp_obj['merchantId'],
            "publicKey"=>$resp_obj['publicKey'],
            "privateKey"=>$resp_obj['privateKey'],
            "ClientSideEncriptionKey"=>$resp_obj['clientSideEncryptionKey']
        );
    }



    if($resp_obj['environment'] == "PRODUCTION") {
        $merchant['environment']['PRODUCTION'] = true;
    } else {
        $merchant['environment']['SANDBOX'] = true;
    }

    $option[0]=array("label" => "Braintree merchant account", "value" => "braintree");
    $option[1]=array("label" => "Pay online", "value" => "payOnlineInfo");
    $option[2]=array("label" => "Paypal", "value" => "paypal");
//     $option[3]=array("label" => "Paypal pro account", "value" => "paypalDirect");
//     $option[4]=array("label" => "Personal merchant account", "value" => "braintreeLinked");
    
    $i = 0;
    foreach($option as $item) {
        if($item['value'] == $resp_obj['typeName']) {
            break;
        }
        $i++;
    }

    $option[$i]['selected'] = true;

    $merchant['merchantAccountType']['options']=$option;

    $merchant['merchantAccountType']['value']=$resp_obj['typeName'];



    // $merchant['merchantAccountType']= $resp_obj['typeName'];

    $merchan_info_list[]=$merchant;
    //}

    $new_data['merchantAccountInformation']=$merchant;

    //$new_data = array("merchantAccountInformation" => $merchan_info_list);

    return json_encode($new_data);

}

//$json = ServicebusGetClientInfo( $_SESSION['SSMData']['clientGuid']);

$json = ServicebusGetMerchantinformation($_SESSION['SSMData']['clientGuid']);
//$json = ServicebusGetMerchantinformation();



//echo "<pre>" . prettyJSON($json,true) . "</pre>";

$data = json_decode($json,true);
$p=return_new_json($data);
echo return_new_json($data);