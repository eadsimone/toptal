<?php
include '../functions.php';
//
//echo "|||GET||| " . print_r($_GET, true);
//echo "|||POST||| " . print_r($_POST, true);
if(isset($_POST['supportlink']) && ($_POST['supportlink']!='')){
    if (!preg_match('/^((http|https):\/\/)?[a-zа-я0-9]+([\-\.]{1}[a-zа-я0-9]+)*\.[a-zа-я]{2,5}(:[0-9]{1,5})?(\/.*)?$/i',$_POST['supportlink'])) {
        echo json_encode(Array('responseCode' => 999, 'responseText' => 'Please enter a valid url.'));
        exit;
    }
}

if( isset($_POST['shippingRule']) && isset($_POST['shippingRate']) ) {

    $shippingRuleAllowed = Array(
        'flatrate_item_fixed', 'flatrate_item_percent', 'flatrate_order_fixed', 'flatrate_order_percent', 'freeshipping'
    );
    if(in_array($_POST['shippingRule'], $shippingRuleAllowed) !== FALSE) {

        if( $_POST['shippingRate'] != 0 && $_POST['shippingRate'] != '') {

            $response = ServieBusSetShippingMethods(
                $_SESSION['SSMData']['clientGuid'],
                $_POST['shippingRule'],
                $_POST['shippingRate']
            );
            
           echo $response;

        } else {
            echo json_encode(
                Array(
                    'responseCode' => 4000,
                    'responseObject' => 'Shipping rate not supported'
                )
            );
        }

    } else {
        echo json_encode(
            Array(
                'responseCode' => 4000,
                'responseObject' => 'Shipping Method not supported'
            )
        );
    }
    //ServieBusSetShippingMethods
}