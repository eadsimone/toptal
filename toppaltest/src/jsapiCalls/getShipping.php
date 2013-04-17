<?php

include '../functions.php';

$storeInfo = json_decode(ServicebusGetStoreInfo($_SESSION['SSMData']['clientGuid'], $_SESSION['SSMData']['storeGuid']), TRUE);
$storeID = $storeInfo['responseObject'][0]['externalStoreId'];

$shippingMethods = json_decode(ServicebusGetShippingMethods($_SESSION['SSMData']['clientGuid'], $storeID), TRUE);

if(isset($shippingMethods['responseObject']['responseObject']['flatrate'])) { 
	$flatRate = $shippingMethods['responseObject']['responseObject']['flatrate'];
} else {
	$flatRate = null;
}

$shippingRate = isset($flatRate['price']) ? $flatRate['price'] : 0;

/*                "type": "I",
                "specificerrmsg": "This shipping method is currently unavailable. If you would like to ship using this shipping method, please contact us.",
                "handling_type": "F",*/

$shippingRules = Array(
    'shippingRules' => Array(
        Array(
            'name'  => 'Free Shipping',
            'id'    => 'freeshipping'
        ),
        Array(
            'name'  => 'Flat Rate Shipping per Order',
            'id'    => 'flatrate_order_fixed'
        ),
        Array(
            'name'  => 'Flat Rate Shipping per Item',
            'id'    => 'flatrate_item_fixed'
        ),
        Array(
            'name'  => 'Percentage Shipping per Order',
            'id'    => 'flatrate_order_percent'
        ),
        Array(
            'name'  => 'Percentage Shipping per Item',
            'id'    => 'flatrate_item_percent'
        )
    ),
    'shippingRate'  => $shippingRate
);

$keyToActivate = NULL;

if($flatRate['type'] == 'I' && $flatRate['handling_type'] == 'F') {
    $keyToActivate = 'flatrate_item_fixed';
}

if($flatRate['type'] == 'O' && $flatRate['handling_type'] == 'F') {
    $keyToActivate = 'flatrate_order_fixed';
}

if($flatRate['type'] == 'I' && $flatRate['handling_type'] == 'P') {
    $keyToActivate = 'flatrate_item_percent';
}

if($flatRate['type'] == 'O' && $flatRate['handling_type'] == 'P') {
    $keyToActivate = 'flatrate_order_percent';
}

if($keyToActivate !== NULL) {
    foreach ($shippingRules['shippingRules'] AS $index => $rule) {
        if($rule['id'] == $keyToActivate) {
            $shippingRules['shippingRules'][$index]['active'] = 'true';
            break;
        }
    }
}

echo json_encode($shippingRules);

//echo $shippingRules;
