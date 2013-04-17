<?php

/*
 * This call is from clientPlan
//desired result
{
    "planUsage": {
        "stores": {
            "total": 5,
            "used": 2,
            "percent": 20
        },
        "containers": {
            "total": 5,
            "used": 2,
            "percent": 20
        },
        "media": {
            "total": 5,
            "used": 1,
            "percent": 20
        },
        "products": {
            "total": 5,
            "used": 1,
            "percent": 20
        },
        "transaction": {
            "total": 5,
            "used": 1,
            "percent": 20
        },
        "storage": {
            "total": 5,
            "used": 100,
            "percent": 20
        },
        "bandwith": {
            "total": 5,
            "used": 500,
            "percent": 20
        }
    }
}
*/

include '../functions.php';
require_once '../helpers/plan_helper.php';

$json = ServicebusGetClientInfo( $_SESSION['SSMData']['clientGuid']);

$data = json_decode($json,true);

echo return_new_json_plan_usage($data);