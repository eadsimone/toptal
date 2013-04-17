<?php

/*
 * This call is from clientPlan
//desired result
{
    "planLimit": {
        "stores": 2,
        "players": 10,
        "videos": 7,
        "products": 30,
        "transaction": 1000,
        "storage": 100,
        "bandwith": 55
    }
}
*/

include '../functions.php';

function return_new_json($json){

    $resp_obj=$json['responseObject']['clientPlan']['plan']['planItems'];

    foreach( $resp_obj as $key => $value ){
        $name = $value['description'];
        $total= $value['itemLimit'];

        $plans[strtolower($name)] = $total;

    }

    $new_data = array("planLimit" => $plans);

    return json_encode($new_data);

}

$json = ServicebusGetClientInfo( $_SESSION['SSMData']['clientGuid']);

$data = json_decode($json,true);

echo return_new_json($data);