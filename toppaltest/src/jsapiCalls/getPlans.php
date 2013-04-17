<?php
/*{
    "plans": [
        {
            "type" : "ENTREPRENEUR",
            "name" : "Entrepreneur",
            "stores": 1,
            "containers": 1,
            "videos": 1,
            "products": 1,
            "transaction": 1,
            "storage": 1,
            "bandwidth": 1,
            "total": "$40 per month"
        },
        {
            "type" : "PROFESSIONAL",
            "name" : "Professional",
            "stores": 2,
            "containers": 3,
            "videos": 4,
            "products": 2,
            "transaction": 3,
            "storage": 2,
            "bandwidth": 3,
            "total": "$60 per month"
        },
        {
            "type" : "PREMIER",
            "name" : "Premiere",
            "stores": 3,
            "containers": 4,
            "videos": 5,
            "products": 3,
            "transaction": 4,
            "storage": 3,
            "bandwidth": 4,
            "total": "$80 per month"
        },
        {
            "type" : "PREMIERPLUS",
            "name" : "Premiere plus",
            "stores": 5,
            "containers": 5,
            "videos": 5,
            "products": 5,
            "transaction": 5,
            "storage": 5,
            "bandwidth": 5,
            "total": "$110 per month"
        }
    ],
    "current": "PREMIER"
}*/
include '../functions.php';

function currentPlan($data){

	$resp_obj=$data['responseObject']['clientPlan']['plan']['planItems'];

	foreach( $resp_obj as $key => $value ){
		$name = $value['description'];
		$total= $value['itemLimit'];
		if($total == "-1") {
			$total = __("unlimited");
		}
		
		$plan[strtolower($name)] = $total;

	}
	
	$plan['total'] = $data['responseObject']['clientPlan']['plan']['price'];
	$plan['displayOrder'] = $data['responseObject']['clientPlan']['plan']['displayOrder'];
	$plan['name'] = $data['responseObject']['clientPlan']['plan']['name'];
	$plan['description'] = $data['responseObject']['clientPlan']['plan']['description'];
	$plan['selectable'] = false;
	$plan['currentPlan'] = true;
	
	$new_data = array($plan);

	return $plan;

}

function return_new_json_get_plans($json, $currentPlan){


    $resp_obj=$json["responseObject"];

    foreach( $resp_obj as $k => $v ){

        $planItems=$v["planItems"];

        $plans['type'] = $v['typeName'] ;
        $plans['name'] = $v['name'] ;

        if (!empty($planItems)) {
            foreach( $planItems as $key => $value ){
                $name = $value['description'];
                $total= $value['itemLimit'];
                if($total == "-1") {
                	$total = __("unlimited");
                }

                $plans[strtolower($name)] = $total;
            }
        }
        $plans['total'] = $v['price'] ;
        $plans['id'] = $v['id'] ;
        $plans['guid'] = $v['guid'] ;
        $plans['displayOrder']  = $v['displayOrder'];
        
        if((int)$plans['displayOrder'] <= (int)$currentPlan['displayOrder']) {
        	$plans['selectable'] = false;
        } else {
        	$plans['selectable'] = true;
        }
        
        $plansList[$plans['displayOrder']] = $plans;
    }

    $plansList[$currentPlan['displayOrder']] = $currentPlan;

    ksort($plansList);
    $new_data = array("plans" => array_values($plansList), "currentPlanx" => $currentPlan);

    return json_encode($new_data);
}

$json = ServicebusGetPlans( $_SESSION['SSMData']['clientGuid']);

//echo "<pre>" . prettyJSON($json,true) . "</pre>";

$data = json_decode($json,true);

$clientInfo = json_decode(ServicebusGetClientInfo( $_SESSION['SSMData']['clientGuid']), true);

$currentPlan = currentPlan($clientInfo);

echo return_new_json_get_plans($data, $currentPlan);
//echo return_new_json($data);


