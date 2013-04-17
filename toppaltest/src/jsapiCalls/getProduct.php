<?php
include '../functions.php';
require_once '../helpers/product_helper.php';

function return_new_json($sbJSON, $pGuid) {
    $response = Array();
    $productType = strtolower(trim($sbJSON['responseObject'][0]['typeName']));
    if($productType == "ecomm") {
    	if(count($sbJSON['responseObject'][0]['itemVariants']) > 1) {
    		$productType = "productWithOptions";
    	}
    }

    
    $data = getArrayByProduct($productType, $sbJSON, $pGuid);

    return $data;
}

$json = return_new_json( json_decode(ServicebusGetProduct( $_SESSION['SSMData']['clientGuid'], $_GET['pGuid']), TRUE), $_GET['pGuid'] );
echo json_encode($json);

//continue from here