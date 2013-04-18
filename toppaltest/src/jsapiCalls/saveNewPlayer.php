<?php

/*
//desired result

{
    "typeName": "player",
    "id": null,
    "name": "Example Player",
    "description": "This is an example player.",
    "assetStatus": "ACTIVE",
    "store": {
        "id": "388",
        "typeName": "store"
    }
}
*/

include '../functions.php';
require_once '../helpers/plan_helper.php';


$app->response()->header("Content-Type", "application/json");
//    $event = $app->request()->post();
//    $result = $db->todolist->insert($event);
//    echo json_encode(array("id" => $result["id"]));